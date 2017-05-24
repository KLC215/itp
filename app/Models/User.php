<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $fillable = [
		'name', 'email', 'password',
	];
	
	protected $hidden = [
		'password', 'remember_token', 'statistics_id',
	];
	
	public function statistic()
	{
		return $this->belongsTo(Statistic::class, 'id', 'statistics_id');
	}
	
	public function hasStatistic()
	{
		return $this->hasOne(Statistic::class, 'id', 'statistics_id');
	}
	
	public function badges()
	{
		return $this->belongsToMany(Badge::class, 'badge_user')
					->withTimestamps();
	}
	
	public function logs()
	{
		return $this->hasMany(UserOperationLog::class, 'user_id', 'id');
	}
	
	public function stages()
	{
		return $this->belongsToMany(Stage::class, 'stage_user')
					->withPivot(['is_completed', 'statistics']);
	}
	
	public function items()
	{
		return $this->belongsToMany(Item::class, 'item_user')
					->withPivot('quantity')
					->wherePivot('user_id', '=', \Auth::id());
	}
}
