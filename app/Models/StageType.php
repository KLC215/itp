<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StageType extends Model
{
	public function stage()
	{
		return $this->belongsTo(Stage::class);
	}
}
