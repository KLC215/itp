<?php

namespace App\Admin\Controllers;

use App\Models\Level;
use App\Models\Question;

use App\Models\QuestionType;
use App\Models\Stage;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Queue\QueueServiceProvider;

class QuestionsController extends Controller
{
	use ModelForm;

	/**
	 * Index interface.
	 *
	 * @return Content
	 */
	public function index()
	{
		return Admin::content(function (Content $content) {

			$content->header('Questions');
			$content->description('manage questions');

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

			$content->header('Edit question');
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

			$content->header('Create question');
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
		return Admin::grid(Question::class, function (Grid $grid) {

			$grid->id('ID')->sortable();

			$grid->level()
				 ->display_name('Level')
				 ->sortable();

			$grid->stage()
				 ->display_name('Stage')
				 ->sortable();

			$grid->questionType()
				 ->display_name('Type')
				 ->sortable();

			$grid->question_file('Question with file')->display(function ($question_file) {
				return $question_file
					? '<i class="fa fa-check" aria-hidden="true"></i>'
					: '<i class="fa fa-times" aria-hidden="true"></i>';
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
		return Admin::form(Question::class, function (Form $form) {

			$form->display('id', 'ID');

			$form->select('level_id')
				 ->options($this->getSelectOptions(Level::all()))
				 ->rules('required');

			$form->select('stage_id')
				 ->options($this->getSelectOptions(Stage::all()))
				 ->rules('required');

			$form->select('question_type_id')
				 ->options($this->getSelectOptions(QuestionType::all()))
				 ->rules('required');

			$form->embeds('question', 'Question preferences', function ($form) {

				$form->textarea('problem')->rules('required');

				$form->textarea('ask_for')->rules('required');

				$form->textarea('hints')->rules('required');

				$form->hidden('start_time')->default('');
				$form->hidden('end_time')->default('');
				$form->hidden('modified_time')->default('');
				$form->hidden('error_ratio')->default(0);

			});

			$form->file('question_file', 'Question file')
				 ->help('If the question type is coding, please upload the file!');

			$form->display('created_at', 'Created At');
			$form->display('updated_at', 'Updated At');

		});
	}

	private function getSelectOptions($data)
	{
		$temp = [];

		foreach ($data as $datum) {
			$temp = array_add($temp, $datum['id'], $datum['display_name']);
		}

		return $temp;

	}
}
