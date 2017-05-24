<?php


namespace App\Helpers;


use App\Models\Statistic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArcadeHelper
{
	public static function createStageUser($request, $stage)
	{
		$stars = self::getStageStars($request, $stage);
		
		self::insertToStageUser($request, $stars);
		
		$reward = self::updateUserStatistics($request, $stars, $stage);
		
		return $reward;
	}
	
	public static function updateStageUser($stage, $stage_user, $request)
	{
		switch ($request['levelId']) {
			case 1:
				$message = self::updateExistStageUserWithTutorialLevel($stage, $stage_user, $request);
				
				return $message;
			case $request->levelId > 1:
				$reward = self::updateExistStageUserWithLevels($stage, $stage_user, $request);
				
				return $reward;
		}
		
		return null;
	}
	
	public static function addStageLog($data, $stage, $time)
	{
		DB::table('user_operation_logs')->insert([
			'user_id'    => Auth::id(),
			'log'        => 'You\'ve finished "' . $stage . '" in ' .
				Carbon::now()->addSecond($time / 1000)->diffForHumans() .
				', earned ' . $data['exp'] . ' EXP and ' . $data['coins'] . ' Coins.',
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		]);
	}
	
	public static function addTutorialLog($stage, $time)
	{
		DB::table('user_operation_logs')->insert([
			'user_id'    => Auth::id(),
			'log'        => 'You\'ve finished "' . $stage . '" in ' .
				Carbon::now()->addSecond($time / 1000)->diffForHumans(),
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		]);
	}
	
	private static function getStageStars($request, $stage)
	{
		$stage_type_id = $stage->stage_type_id == $stage->parent_id ? 0 : $stage->stage_type_id;
		$cal = new CalculateStars($request['finishTime'],
			$request['errorRatio'], $stage_type_id);
		$stars = $cal->getStars();
		if ($stars < 0) {
			$stars = 0;
		}
		
		return $stars;
	}
	
	private static function insertToStageUser($request, $stars)
	{
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
	}
	
	private static function updateUserStatistics($request, $stars, $stage, $isTutorial = null)
	{
		$stats = Statistic::find(Auth::id());
		
		$times = self::calculateNewTimes($request, $stats);
		
		$stats->star_received += $stars;
		$stats->average_time_taken = $times['avg'];
		$stats->time_spent_coding = $times['ntsc'];
		$stats->save();
		
		if ($isTutorial) {
			return [
				'message' => 'You have finished this stage, you will not get any reward but the statistics of stage will be updated!',
			];
		}
		
		$reward = self::giveReward($stage, $stars);
		
		return $reward;
	}
	
	private static function calculateNewTimes($request, $stats)
	{
		$newTimeSpentCoding = strtotime($stats->time_spent_coding);
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
		
		return [
			'ntsc' => $newTimeSpentCoding,
			'avg'  => $avg,
		];
	}
	
	private static function giveReward($stage, $stars)
	{
		$exp = $stage->preferences['exp'];
		$coins = $stage->preferences['coin'];
		
		$extras = self::calculateExpCoins($exp, $coins, $stars, $stage->stage_type_id);
		$exp += $extras['exp'];
		$coins += $extras['coins'];
		
		$user = User::findOrFail(Auth::id());
		$user->exp += $exp;
		$user->coin += $coins;
		$user->save();
		
		return [
			'exp'   => $exp,
			'coins' => $coins,
		];
	}
	
	private static function calculateExpCoins($exp, $coins, $stars, $stage_type_id)
	{
		$cal = new CalculateExpCoins($exp, $coins, $stars, $stage_type_id);
		$extraExp = $cal->getExp();
		$extraCoins = $cal->getCoins();
		
		return [
			'exp'   => $extraExp,
			'coins' => $extraCoins,
		];
	}
	
	private static function updateExistStageUserWithTutorialLevel($stage, $stage_user, $request)
	{
		$statistics = json_decode($stage_user->statistics);
		$stars = self::getStageStars($request, $stage);
		DB::table('stage_user')
		  ->where([
			  ['stage_id', $request['stageId']],
			  ['user_id', Auth::id()],
			  ['is_completed', true],
		  ])
		  ->update([
			  'statistics'      => json_encode([
				  'error_ratio'   => self::compareErrorRatio($statistics->error_ratio, $request),
				  'finished_time' => self::compareFinishTime($statistics->finished_time, $request),
				  'stars'         => self::compareStars($statistics->stars, $stars),
			  ]),
			  'completed_times' => $stage_user->completed_times += 1,
			  'updated_at'      => Carbon::now(),
		  ]);
		
		$message = self::updateUserStatistics($request, $stars, $stage, true);
		
		return $message;
	}
	
	private static function updateExistStageUserWithLevels($stage, $stage_user, $request)
	{
		$statistics = json_decode($stage_user->statistics);
		$stars = self::getStageStars($request, $stage);
		DB::table('stage_user')
		  ->where([
			  ['stage_id', $request['stageId']],
			  ['user_id', Auth::id()],
			  ['is_completed', true],
		  ])
		  ->update([
			  'statistics'      => json_encode([
				  'error_ratio'   => self::compareErrorRatio($statistics->error_ratio, $request),
				  'finished_time' => self::compareFinishTime($statistics->finished_time, $request),
				  'stars'         => self::compareStars($statistics->stars, $stars),
			  ]),
			  'completed_times' => $stage_user->completed_times += 1,
			  'updated_at'      => Carbon::now(),
		  ]);
		
		$reward = self::updateUserStatistics($request, $stars, $stage, false);
		
		return $reward;
	}
	
	private static function compareErrorRatio($error_ratio, $request)
	{
		return $request['errorRatio'] < $error_ratio
			? $request['errorRatio']
			: $error_ratio;
	}
	
	private static function compareFinishTime($finished_time, $request)
	{
		return $request['finishTime'] < $finished_time
			? $request['finishTime']
			: $finished_time;
	}
	
	private static function compareStars($stars, $newStars)
	{
		return $newStars > $stars
			? $newStars
			: $stars;
	}
}