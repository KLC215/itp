<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	protected $casts = [
		'question' => 'json'
	];

	public function questionType()
	{
		return $this->hasOne(QuestionType::class, 'id', 'question_type_id');
	}

	public function level()
	{
		return $this->belongsTo(Level::class);
	}

	public function stage()
	{
		return $this->belongsTo(Stage::class);
	}

	public function answers()
	{
		return $this->hasMany(Answer::class);
	}
}
