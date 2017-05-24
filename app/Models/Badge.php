<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
	public function users()
	{
		return $this->belongsToMany(User::class, 'badge_user')
					->withTimestamps();
	}
	
	public function stage()
	{
		return $this->belongsTo(Stage::class, 'stage_id', 'id');
	}
}
