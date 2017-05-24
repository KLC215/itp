<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	protected $casts = [
		'features' => 'json',
	];
	
	public function stage()
	{
		return $this->belongsTo(Stage::class, 'stage_id', 'id');
	}
	
	public function users()
	{
		return $this->belongsToMany(User::class, 'item_user')
					->withPivot('quantity')
					->wherePivot('user_id', '=', \Auth::id());
	}
}
