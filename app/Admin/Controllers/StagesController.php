<?php

namespace App\Admin\Controllers;

use App\Models\Stage;

use App\Models\StageType;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use function foo\func;

class StagesController extends Controller
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
			
			$content->header('Stages');
			$content->description('manage stages');
			
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
			
			$content->header('Edit stage');
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
			
			$content->header('Create stage');
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
		return Admin::grid(Stage::class, function (Grid $grid) {
			
			$grid->id('ID')->sortable();
			
			$grid->display_name('Stage')->sortable();
			
			$grid->parent('Parent')->display(function ($parent) {
				return $parent
					? "<b><i>{$parent['display_name']}</i></b>"
					: '<i class="fa fa-times" aria-hidden="true"></i>';
			});
			
			$grid->stageType()->display_name('Type')->label('info');
			
			$grid->description('Description');
			
			$grid->image()->image('', 100, 100);
			
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
		return Admin::form(Stage::class, function (Form $form) {
			
			$form->display('id', 'ID');
			
			$form->select('parent_id')
				 ->options($this->getSelectOptions(Stage::all()))
				 ->rules('required');
			
			$form->select('stage_type_id')
				 ->options($this->getSelectOptions(StageType::all()))
				 ->rules('required');
			
			//$form->text('name', 'Name')->help('<b>Suggested format:</b> <i>i-am-a-boy</i>');
			$form->hidden('name');
			
			$form->text('display_name', 'Display name')
				 ->rules('required');
			
			$form->textarea('description', 'Description')
				 ->rules('required');
			
			$form->image('image')
				 ->move('/storage/images/stages', date("Y-m-d H:i:s") . '-' . str_random(10))
				 ->rules('required');
			
			$form->embeds('preferences', 'Stage preferences', function ($form) {
				$form->number('coin');
				$form->number('exp');
				$form->number('functional_no');
			});
			
			$form->display('created_at', 'Created At');
			$form->display('updated_at', 'Updated At');
			
			$form->saving(function ($form) {
				$form->name = str_slug($form->display_name);
			});
		});
	}
	
	private function getSelectOptions($data)
	{
		$temp = [];
		
		$temp = array_add($temp, '', 'None');
		
		foreach ($data as $datum) {
			$temp = array_add($temp, $datum['id'], $datum['display_name']);
		}
		
		return $temp;
	}
}
