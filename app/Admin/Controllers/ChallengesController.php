<?php

namespace App\Admin\Controllers;

use App\Models\Challenge;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ChallengesController extends Controller
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

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

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

            $content->header('header');
            $content->description('description');

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
        return Admin::grid(Challenge::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

			$grid->name('Challenge')->sortable();

			$grid->description('Description');

			$grid->preferences('Preferences')->display(function ($preferences) {

				$data = '';

				foreach ($preferences as $key => $val) {
					$data .= "{$key}: <i>{$val}</i><br>";
				}

				return $data;
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
        return Admin::form(Challenge::class, function (Form $form) {

            $form->display('id', 'ID');

			$form->text('name')->rules('required|max:255');
			$form->textarea('description')->rules('required');

			$form->divide();

			$form->embeds('preferences', 'Challenge preferences', function ($form) {
				$form->number('coin');
				$form->number('exp');
			});

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
