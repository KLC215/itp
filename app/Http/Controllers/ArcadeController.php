<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Stage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArcadeController extends Controller
{
	public function index()
	{
		$stages = Stage::where('parent_id', '=', Stage::ARCADE_ID)->get();

		return view('stages.index', compact('stages'));
	}

	public function routeFirstChild($fisrtChild)
	{
		$stages = Stage::where('id', '!=', Stage::ARCADE_ID)
					   ->where('parent_id', Stage::ARCADE_ID)
					   ->get();

		if (!$stages) {
			return false;
		}

		foreach ($stages as $stage) {
			if (strcmp($stage['name'], $fisrtChild) == 0) {

				$childStages = Stage::where('parent_id', $stage['id'])
									->get();

				return view('stages.child', compact(['stage', 'childStages']));

			}
		}

		//dd($stages[0]['name']);
	}

	public function routeSecondChild($firstChild, $secondChild, $step)
	{
		$parent = Stage::where('name', $firstChild)->firstOrFail();

		if (!$parent) {
			return false;
		}

		$childStage = Stage::where('name', $secondChild)
						   ->where('parent_id', $parent->id)
						   ->firstOrFail();

		if (!$childStage) {
			return false;
		}

		$questions = Question::where('stage_id', $childStage->id)->get();

		if (strcmp('tutorial', $parent->name) == 0) {

			$steps = [
				'arcade' => $secondChild,
				'titles' => ['Intro', 'Question'],
				'active' => 0,
			];

			foreach ($questions as $question) {
				$question->answers;
			}

			return view('stages.stage', compact(['questions', 'steps']));
		}
	}

	public function completedStage(Request $request)
	{
		$errorRatio = $request->error_ratio;
		$stageId = $request->stage_id;

		$stage = Stage::findOrFail($stageId);

		$user = User::findOrFail(Auth::id());

		//TODO: Save into stage_user table too

		// Give exp and coin to user
		User::where('id', $user->id)
			->update([
				'exp'  => $user->exp + $stage->preferences['exp'],
				'coin' => $user->coin + $stage->preferences['coin'],
			]);

		return json_encode([
			'exp' => $stage->preferences['exp'],
			'coin' => $stage->preferences['coin'],
		]);
	}
}
