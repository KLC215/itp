<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
	// Reference by DatabaseSeeder
	const ARCADE_ID    = 1;
	const CHALLENGE_ID = 2;
	
	protected $casts = [
		'preferences' => 'json',
	];
	
	public function stageType()
	{
		return $this->hasOne(StageType::class, 'id', 'stage_type_id');
	}
	
	public function questions()
	{
		return $this->hasMany(Question::class);
	}
	
	public function parent()
	{
		return $this->belongsTo(Stage::class, 'parent_id');
	}
	
	public function children()
	{
		return $this->hasMany(Stage::class, 'parent_id');
	}
	
	public function badge()
	{
		return $this->hasOne(Badge::class);
	}
	
	public function item()
	{
		return $this->hasOne(Item::class);
	}
	
	public function users()
	{
		return $this->belongsToMany(User::class, 'stage_user')
					->withPivot(['is_completed', 'statistics']);
	}
	
	public function calculateStars()
	{
	
	}
}
