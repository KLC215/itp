<?php

namespace App\Http\Controllers;

use App\Helpers\CalculateExpCoins;
use App\Helpers\CalculateStars;
use App\Helpers\ChallengeHelper;
use App\Models\Answer;
use App\Models\Badge;
use App\Models\Item;
use App\Models\Question;
use App\Models\Stage;
use App\Models\Statistic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ChallengeController extends Controller
{
	public function index()
	{
		$challenges = Stage::where('parent_id', Stage::CHALLENGE_ID)
						   ->get();
		
		foreach ($challenges as $challenge) {
			if(Auth::user()->exp < 3000) {
				$challenge['lock'] = true;
			}
		}
		
		return view('challenge.index', compact('challenges'));
	}
	
	public function start($challenge)
	{
		
		$selectedChallenge = Stage::where('name', $challenge)
								  ->firstOrFail();
		
		$questions = Question::where('level_id', '>', 1)
							 ->get()
							 ->shuffle();
		
		$badges = Badge::where('stage_id', $selectedChallenge->id)->get();
		
		$answers = [];
		foreach ($questions as $question) {
			$question->questionType;
			$answers[] = Answer::where('question_id', $question->id)->firstOrFail();
		}
		
		$items = Item::where('stage_id', $selectedChallenge->id)
					 ->get();
		foreach ($items as $item) {
			$item->users;
		}
		
		return view('challenge.start', compact([
			'questions',
			'answers',
			'selectedChallenge',
			'items',
			'badges'
		]));
		
	}
	
	public function complete()
	{
		$request = request([
			'stageId', 'finishTime', 'correctRatio', 'errorRatio', 'badgeId'
		]);
		
		// Get stage_user table
		$stage_user = DB::table('stage_user')->where([
			['stage_id', $request['stageId']],
			['user_id', Auth::id()],
			['is_completed', true],
		])->first();
		
		$badge_user = DB::table('badge_user')->where([
			['badge_id', $request['badgeId']],
			['user_id', Auth::id()],
		])->first();
		
		// Get stage
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
			$data = ChallengeHelper::updateStageUser($request, $stage, $stage_user);
			ChallengeHelper::addStageLog($data, $stage->display_name, $request['finishTime']);
			
			return [
				'exp'  => $data['exp'],
				'coin' => $data['coins'],
			];
		}
		
		$data = ChallengeHelper::createStageUser($request, $stage);
		ChallengeHelper::addStageLog($data, $stage->display_name, $request['finishTime']);
		
		return [
			'exp'  => $data['exp'],
			'coin' => $data['coins'],
		];
		
		
	}
	
	public function deductItemQty()
	{
		$request = request(['itemId', 'itemName']);
		
		$query = DB::table('item_user')
				   ->where([
					   ['user_id', Auth::id()],
					   ['item_id', $request['itemId']],
				   ]);
		$query->decrement('quantity', 1);
		$query->update(['updated_at' => Carbon::now()]);
		
		
		switch ($request['itemName']) {
			case 'give-me-10-seconds':
				return [
					'success' => true,
					'message' => 'The timer has been increased by 10 seconds!',
				];
			case 'give-me-a-heart':
				return [
					'success' => true,
					'message' => 'Your health has been increased by 1 !',
				];
		}
		
		return [
			'success' => false,
			'message' => 'You do nothing here!',
		];
	}
	
	/*private function updateExistStageUser($stage, $stage_user, $request)
	{
		$statistics = json_decode($stage_user->statistics);
		$starCal = new CalculateStars($request['finishTime'], $request['errorRatio'], $stage->stage_type_id);
		$stars = $starCal->getStars();
		
		if ($stars < 0) {
			$stars = 0;
		}
		
		DB::table('stage_user')
		  ->where([
			  ['stage_id', $request['stageId']],
			  ['user_id', Auth::id()],
			  ['is_completed', true],
		  ])
		  ->update([
			  'statistics'      => json_encode([
				  'error_ratio'   => $statistics->error_ratio > $request['errorRatio']
					  ? $request['errorRatio']
					  : $statistics->error_ratio,
				  'finished_time' => $statistics->finished_time > $request['finishTime']
					  ? $request['finishTime']
					  : $statistics->finished_time,
				  'stars'         => $statistics->stars > $stars
					  ? $statistics->stars
					  : $stars,
			  ]),
			  'completed_times' => $stage_user->completed_times += 1,
			  'updated_at'      => Carbon::now(),
		  ]);
		
		$stat = Statistic::findOrFail(Auth::id());
		$stat->star_received += $stars;
		
		$newTimeSpentCoding = strtotime($stat->time_spent_coding);
		$newTimeSpentCoding += $request['finishTime'] / 1000;
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
		$stat->average_time_taken = $avg;
		$stat->time_spent_coding = $newTimeSpentCoding;
		$stat->save();
		
		$exp = $stage->preferences['exp'];
		$coins = $stage->preferences['coin'];
		if ($request['correctRatio'] <= 1) {
			$exp = 50;
			$coins = 50;
		}
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
	
	private function createStageUser($request, $stage)
	{
		$starCal = new CalculateStars($request['finishTime'], $request['errorRatio'], $stage->stage_type_id);
		$stars = $starCal->getStars();
		
		if ($stars < 0) {
			$stars = 0;
		}
		
		DB::table('stage_user')->insert([
			'stage_id'        => $request['stageId'],
			'user_id'         => Auth::id(),
			'is_completed'    => true,
			'statistics'      => json_encode([
				'error_ratio'   => $request['errorRatio'],
				'finished_time' => $request['finishTime'],
				'stars'         => $stars,
			]),
			'completed_times' => 1,
			'created_at'      => Carbon::now(),
			'updated_at'      => Carbon::now(),
		]);
		
		$statistic = Statistic::find(Auth::id());
		$statistic->star_received = $stars;
		
		$newTimeSpentCoding = strtotime($statistic->time_spent_coding);
		$newTimeSpentCoding += $request['finishTime'] / 1000;
		$newTimeSpentCoding = date('H:i:s', $newTimeSpentCoding);
		$finishTime = 0;
		$completedTimes = 0;
		$stage_user_data = DB::table('stage_user')->where([
			['user_id', Auth::id()],
			['is_completed', true],
		])->get();
		foreach ($stage_user_data as $stage_user_datum) {
			$statistics = json_decode($stage_user_datum->statistics);
			$finishTime += $statistics->finished_time / 1000;
			$completedTimes += $stage_user_datum->completed_times;
		}
		$avg = gmdate('H:i:s', $finishTime / $completedTimes);
		$statistic->average_time_taken = $avg;
		$statistic->time_spent_coding = $newTimeSpentCoding;
		$statistic->save();
		
		$exp = $stage->preferences['exp'];
		$coins = $stage->preferences['coin'];
		
		if ($request['correctRatio'] <= 1) {
			$exp = 50;
			$coins = 50;
		}
		
		$expCoinsCal = new CalculateExpCoins($exp, $coins, $stars, $stage->stage_type_id);
		$exp += $expCoinsCal->getExp();
		$coins += $expCoinsCal->getCoins();
		
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
