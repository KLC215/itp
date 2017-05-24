<?php

namespace App\Admin\Controllers;

use App\Models\Badge;

use App\Models\Stage;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class BadgesController extends Controller
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
			
			$content->header('Badges');
			$content->description('manage badges');
			
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
			
			$content->header('Edit badge');
			
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
			
			$content->header('Create badge');
			
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
		return Admin::grid(Badge::class, function (Grid $grid) {
			
			$grid->id('ID')->sortable();
			
			// TODO: 搞點BACKEND
			// TODO: 問題/答案
			// TODO: ARCADE/CHALLENGE
			$grid->stage('Give it after stage')->display(function ($stage) {
				return $stage
					? "<b><i>{$stage['display_name']}</i></b>"
					: '<i class="fa fa-times" aria-hidden="true" style="color: red"></i>';
			});
			$grid->image()->image('', 100, 100);
			$grid->description('Description');
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
		return Admin::form(Badge::class, function (Form $form) {
			
			$form->display('id', 'ID');
			
			$form->select('stage_id')
				 ->options($this->getSelectOptions(Stage::all()));
			
			$form->image('image')
				 ->move('/storage/images/badges')
				 ->rules('required');
			
			$form->textarea('description', 'Description')
				 ->rules('required');
			
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
