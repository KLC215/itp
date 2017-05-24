<?php

namespace App\Http\Controllers;

use App\Helpers\ArcadeHelper;
use App\Helpers\CalculateExpCoins;
use App\Helpers\CalculateStars;
use App\Models\Answer;
use App\Models\Badge;
use App\Models\Question;
use App\Models\Stage;
use App\Models\Statistic;
use App\Models\User;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArcadeController extends Controller
{
	
	public function index()
	{
		$stages = Stage::where('parent_id', '=', Stage::ARCADE_ID)
					   ->get();
		
		foreach ($stages as $stage) {
			$hasChildStages = Stage::where('parent_id', $stage->id)->get();
			sizeof($hasChildStages) ? $stage['single'] = false : $stage['single'] = true;
			if ($stage->name == 'level-1') {
				if (Auth::user()->exp < 900) {
					$stage['lock'] = true;
				}
			} else if ($stage->name == 'level-2') {
				if (Auth::user()->exp < 2400) {
					$stage['lock'] = true;
				}
			}
		}
		
		return view('stages.index', compact('stages'));
	}
	
	public function subIndex($subArcade)
	{
		$subArcade = Stage::where('name', $subArcade)->firstOrFail();
		$subArcadeChilds = Stage::where('parent_id', $subArcade->id)->get();
		
		$countAllSubArcadeChilds = $subArcadeChilds->count();
		
		foreach ($subArcadeChilds as $subArcadeChild) {
			foreach ($subArcadeChild->users as $user) {
				if ($user->id == Auth::id()) {
					$subArcadeChild['completed'] = true;
					$subArcadeChild['stats'] = $user->pivot->statistics;
				} else {
					$subArcadeChild['completed'] = false;
				}
			}
		}
		
		return view('stages.child', compact(['subArcade', 'subArcadeChilds', 'countAllSubArcadeChilds']));
	}
	
	// Call by tutorial
	public function intro($subArcade, $subArcadeChild)
	{
		$intro = true;
		$steps = $this->getSteps(true, 0);
		
		return view('stages.stage', compact(['steps', 'subArcadeChild', 'intro']));
	}
	
	public function start($subArcade, $subArcadeChild)
	{
		$intro = false;
		$steps = [];
		$answers = [];
		
		if ($subArcade == 'tutorial') {
			$steps = $this->getSteps(true, 1);
		}
		
		$child = Stage::where('name', $subArcadeChild)->firstOrFail();
		$questions = Question::where('stage_id', $child->id)->get();
		$badges = Badge::where('stage_id', $child->id)->get();
		
		foreach ($questions as $question) {
			$answers[] = Answer::where('question_id', $question->id)->get();
		}
		
		return view('stages.stage', compact(['intro', 'questions', 'answers', 'subArcadeChild', 'steps', 'badges']));
	}
	
	public function singleArcadeStart($subArcade)
	{
		$stage = Stage::where('name', $subArcade)->firstOrFail();
		$questions = Question::where('stage_id', $stage->id)->get();
		$questionsCount = $questions->count() > 4 ? 5 : $questions->count();
		$randomQuestions = $questions->random($questionsCount);
		$randomQuestions = $randomQuestions->shuffle();
		$steps = $this->getSteps(false);
		$badges = Badge::where('stage_id', $stage->id)->get();
		$answers = [];
		
		foreach ($randomQuestions as $randomQuestion) {
			$randomQuestion->questionType;
			$answers[] = Answer::where('question_id', $randomQuestion->id)->firstOrFail();
		}
		
		return view('stages.single', compact(['randomQuestions', 'answers', 'steps', 'badges']));
	}
	
	public function complete()
	{
		$request = request(['stageId', 'levelId', 'finishTime', 'errorRatio', 'badgeId']);
		
		$stage_user = DB::table('stage_user')->where([
			['stage_id', $request['stageId']],
			['user_id', Auth::id()],
			['is_completed', true],
		])->first();
		
		$badge_user = DB::table('badge_user')->where([
			['badge_id', $request['badgeId']],
			['user_id', Auth::id()],
		])->first();
		
		$stage = Stage::findOrFail($request['stageId']);
		
		if (!$badge_user) {
			if ($request['badgeId'] > 0) {
				DB::table('badge_user')->insert([
					'badge_id'   => $request['badgeId'],
					'user_id'    => Auth::id(),
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
				]);
				logMessage('You got a new badge after ' . $stage->display_name . ' !');
			}
		}
		
		if ($stage_user) {
			$data = ArcadeHelper::updateStageUser($stage, $stage_user, $request);
			
			if (array_key_exists('exp', $data)) {
				ArcadeHelper::addStageLog($data, $stage->display_name, $request['finishTime']);
			} else {
				ArcadeHelper::addTutorialLog($stage->display_name, $request['finishTime']);
			}
			
			return $data;
		}
		
		
		/*if ($stage_user && $request['levelId'] == 1) {
			$data = $this->updateExistStageUser($stage, $stage_user, $request);
			$this->addLog($data, $stage->display_name, $request->finishTime);
			
			return [
				'message' => $data['message'],
			];
		}
		
		if ($stage_user && $request->levelId > 1) {
			$data = $this->updateExistStageUser($stage, $stage_user, $request);
			$this->addLog($data, $stage->display_name, $request->finishTime);
			
			return [
				'exp'  => $data['exp'],
				'coin' => $data['coins'],
			];
		}*/
		
		$data = ArcadeHelper::createStageUser($request, $stage);
		ArcadeHelper::addStageLog($data, $stage->display_name, $request['finishTime']);
		
		return [
			'exp'  => $data['exp'],
			'coin' => $data['coins'],
		];
		
	}
	
	public function deductUserCoins()
	{
		$user = Auth::user();
		
		$coin = $user->coin - 200;
		
		if ($coin < 0) {
			return [
				'success' => false,
				'message' => 'You don\'t have enough coin !',
			];
		}
		
		$user->coin = $coin;
		$user->save();
		
		return [
			'success' => true,
		];
	}
	
	private function getSteps($isTutorial, $active = 0)
	{
		if ($isTutorial) {
			return [
				'titles' => ['Intro', 'Question'],
				'active' => $active,
			];
		}
		$titles = [];
		for ($i = 1; $i <= 5; $i++) {
			$titles[] = 'Question ' . $i;
		}
		
		return [
			'titles' => $titles,
			'active' => $active,
		];
	}
	
	/*private function updateExistStageUser($stage = null, $stage_user, $request)
	{
		$statistics = json_decode($stage_user->statistics);
		
		$starCalculator = new CalculateStars($request->finishTime, $request->errorRatio, $stage->stage_type_id == $stage->parent_id ? 0 : $stage->stage_type_id);
		$stars = $starCalculator->getStars();
		
		DB::table('stage_user')
		  ->where([
			  ['stage_id', $request->stageId],
			  ['user_id', Auth::id()],
			  ['is_completed', true],
		  ])
		  ->update([
			  'statistics'      => json_encode([
				  'error_ratio'   => $statistics->error_ratio > $request->errorRatio
					  ? $request->errorRatio
					  : $statistics->error_ratio,
				  'finished_time' => $statistics->finished_time > $request->finishTime
					  ? $request->finishTime
					  : $statistics->finished_time,
				  'stars'         => $statistics->stars > $stars
					  ? $statistics->stars
					  : $stars,
			  ]),
			  'completed_times' => $stage_user->completed_times += 1,
			  'updated_at'      => Carbon::now(),
		  ]);
		
		$statistic = Statistic::find(Auth::id());
		$statistic->star_received += $stars;
		
		$newTimeSpentCoding = strtotime($statistic->time_spent_coding);
		$newTimeSpentCoding += $request->finishTime / 1000;
		$newTimeSpentCoding = date('H:i:s', $newTimeSpentCoding);
		$finishTimes = 0;
		$completedTimes = 0;
		$stage_user_data = DB::table('stage_user')->where([
			['user_id', Auth::id()],
			['is_completed', true],
		])->get();
		foreach ($stage_user_data as $stage_user_datum) {
			$statistics = json_decode($stage_user_datum->statistics);
			$finishTimes += $statistics->finished_time / 1000;
			$completedTimes += $stage_user_datum->completed_times;
		}
		$avg = gmdate('H:i:s', $finishTimes / $completedTimes);
		$statistic->average_time_taken = $avg;
		$statistic->time_spent_coding = $newTimeSpentCoding;
		$statistic->save();
		
		if ($request->levelId > 1) {
			$exp = $stage->preferences['exp'];
			$coins = $stage->preferences['coin'];
			
			$expCoinsCalculator = new CalculateExpCoins($exp, $coins, $stars, $stage->stage_type_id);
			$exp += $expCoinsCalculator->getExp();
			$coins += $expCoinsCalculator->getCoins();
			
			$user = User::findOrFail(Auth::id());
			$user->exp += $exp;
			$user->coin += $coins;
			$user->save();
			
			return [
				'exp'   => $exp,
				'coins' => $coins,
			];
		}
		
		return [
			'message' => 'You have finished this stage, you will not get any reward.',
		];
	}
	
	private function createStageUser($request, $stage)
	{
		$starCalculator = new CalculateStars($request->finishTime, $request->errorRatio, $stage->stage_type_id == $stage->parent_id ? 0 : $stage->stage_type_id);
		$stars = $starCalculator->getStars();
		
		DB::table('stage_user')->insert([
			'stage_id'        => $request->stageId,
			'user_id'         => Auth::id(),
			'is_completed'    => true,
			'statistics'      => json_encode([
				'error_ratio'   => $request->errorRatio,
				'finished_time' => $request->finishTime,
				'stars'         => $stars,
			]),
			'completed_times' => 1,
			'created_at'      => Carbon::now(),
			'updated_at'      => Carbon::now(),
		]);
		
		$statistic = Statistic::find(Auth::id());
		$statistic->star_received = $stars;
		
		$newTimeSpentCoding = strtotime($statistic->time_spent_coding);
		$newTimeSpentCoding += $request->finishTime / 1000;
		$newTimeSpentCoding = date('H:i:s', $newTimeSpentCoding);
		$finishTimes = 0;
		$completedTimes = 0;
		$stage_user_data = DB::table('stage_user')->where([
			['user_id', Auth::id()],
			['is_completed', true],
		])->get();
		foreach ($stage_user_data as $stage_user_datum) {
			$statistics = json_decode($stage_user_datum->statistics);
			$finishTimes += $statistics->finished_time / 1000;
			$completedTimes += $stage_user_datum->completed_times;
		}
		$avg = gmdate('H:i:s', $finishTimes / $completedTimes);
		$statistic->average_time_taken = $avg;
		$statistic->time_spent_coding = $newTimeSpentCoding;
		$statistic->save();
		
		$exp = $stage->preferences['exp'];
		$coins = $stage->preferences['coin'];
		if ($request->levelId > 1) {
			$expCoinsCalculator = new CalculateExpCoins($exp, $coins, $stars, $stage->stage_type_id);
			$exp += $expCoinsCalculator->getExp();
			$coins += $expCoinsCalculator->getCoins();
		}
		$user = User::findOrFail(Auth::id());
		$user->exp += $exp;
		$user->coin += $coins;
		$user->save();
		
		return [
			'exp'   => $exp,
			'coins' => $coins,
		];
	}
	
	private function addLog($data, $stage, $time)
	{
		DB::table('user_operation_logs')->insert([
			'user_id'    => Auth::id(),
			'log'        => 'You\'ve finished "' . $stage . '" in ' .
				Carbon::now()->addSecond($time / 1000)->diffForHumans() .
				', earned ' . $data['exp'] . ' EXP and ' . $data['coins'] . ' Coins.',
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		]);
	}*/
}
