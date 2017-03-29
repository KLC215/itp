<?php

namespace App\Admin\Controllers;

use App\Models\Answer;

use App\Models\Question;
use App\Models\Stage;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class AnswersController extends Controller
{
	use ModelForm;

	private $randomNumbers = [];

	/**
	 * Index interface.
	 *
	 * @return Content
	 */
	public function index()
	{
		return Admin::content(function (Content $content) {

			$content->header('Answers');
			$content->description('manage answers');

			$content->body($this->grid());
		});
	}

	/**
	 * Edit interface.
	 *
	 * @param $id
	 *
	 * @return Content
	 */
	public function edit($id)
	{
		return Admin::content(function (Content $content) use ($id) {

			$content->header('Edit answer');
			$content->description('');

			$content->body($this->form()->edit($id));
		});
	}

	/**
	 * Create interface.
	 *
	 * @return Content
	 */
	public function create()
	{
		return Admin::content(function (Content $content) {

			$content->header('Create answer');
			$content->description('');

			$content->body($this->form());
		});
	}

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid()
	{
		return Admin::grid(Answer::class, function (Grid $grid) {

			$grid->id('ID')->sortable();

			$grid->question()
				 ->id('Question ID')
				 ->sortable();

			$grid->answer('Answer');
			$grid->feedback('Feedback');
			$grid->is_correct('Correct')->display(function ($is_correct) {
				return $is_correct
					? '<i class="fa fa-check" aria-hidden="true" style="color: green;"></i>'
					: '<i class="fa fa-times" aria-hidden="true" style="color: red;"></i>';
			});


			$grid->created_at();
			$grid->updated_at();
		});
	}

	/**
	 * Make a form builder.
	 *
	 * @return Form
	 */
	protected function form()
	{
		return Admin::form(Answer::class, function (Form $form) {

			$form->display('id', 'ID');

			$form->select('question_id', 'Question')
				 ->options($this->getSelectOptions(Question::all()))
				 ->rules('required');

			$form->number('answer', 'Answer');

			$form->text('feedback')->rules('required');

			$form->hidden('is_correct')->default(true);

			$form->display('created_at', 'Created At');
			$form->display('updated_at', 'Updated At');

			$form->saved(function ($form) {

				for ($i = 0; $i < 3; $i++) {
					$answer = new Answer([
						'question_id' => $form->question_id,
						'answer'      => $this->generateRandomAnswer($form->answer - 5, $form->answer + 10, $form->answer),
						'feedback'    => 'Wrong Answer, please try again.',
						'is_correct'  => false,
					]);
					$answer->save();
				}

				$this->randomNumbers = [];
			});

		});
	}

	private function getSelectOptions($data)
	{
		$temp = [];

		foreach ($data as $datum) {
			$temp = array_add($temp, $datum['id'], 'Question ID: ' . $datum['id'] . ' in ' . Stage::findOrFail($datum['stage_id'])->display_name);
		}

		return $temp;
	}

	private function generateRandomAnswer($min, $max, $except)
	{
		$randomNumber = rand($min, $max);

		if ($randomNumber == $except || in_array($randomNumber, $this->randomNumbers)) {
			return $this->generateRandomAnswer($min, $max, $except);
		}

		$this->randomNumbers[] = $randomNumber;

		return $randomNumber;
	}
}
