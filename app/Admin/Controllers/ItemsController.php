<?php

namespace App\Admin\Controllers;

use App\Models\Item;

use App\Models\Stage;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ItemsController extends Controller
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
			
			$content->header('Items');
			$content->description('manage items');
			
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
			
			$content->header('Edit Item');
			
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
			
			$content->header('Create Item');
			
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
		return Admin::grid(Item::class, function (Grid $grid) {
			
			$grid->id('ID')->sortable();
			
			$grid->stage('Give it after stage')->display(function ($stage) {
				return $stage
					? "<b><i>{$stage['display_name']}</i></b>"
					: '<i class="fa fa-times" aria-hidden="true" style="color: red"></i>';
			});
			
			$grid->display_name('Item')->sortable();
			$grid->description('Description');
			$grid->image()->image('', 100, 100);
			
			$grid->features('Features')->display(function ($features) {
				
				$data = '';
				
				foreach ($features as $key => $val) {
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
		return Admin::form(Item::class, function (Form $form) {
			
			$form->display('id', 'ID');
			
			$form->select('stage_id')
				 ->options($this->getSelectOptions(Stage::all()))->default(null);
			
			$form->hidden('name');
			
			$form->text('display_name', 'Display name')
				 ->rules('required|unique:stages');
			
			$form->textarea('description', 'Description')
				 ->rules('required');
			
			$form->image('image')
				 ->move('/storage/images/items')
				 ->rules('required');
			
			$form->embeds('features', 'Item features', function ($form) {
				$form->number('cost');
				$form->number('functional_no')->help('Maybe how many second, how many times of reward .etc');
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
