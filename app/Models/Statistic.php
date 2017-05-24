<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    public function user()
	{
		return $this->hasOne(User::class, 'statistics_id', 'id');
	}
	
	public function belongsToUser()
	{
		return $this->belongsTo(User::class, 'statistics_id', 'id');
	}
}
