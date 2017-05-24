<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use App\Models\User;
use Illuminate\Http\Request;

class LeaderBoardController extends Controller
{
	private $filters = [
		'exp'      => 'exp',
		'coin'     => 'coin',
		'avg_time' => 'average_time_taken',
		'time'     => 'time_spent_coding',
		'star'     => 'star_received',
	];
	
	
	/**
	 * LeaderBoardController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	public function index()
	{
		$users = $this->getUsersOrderByAssets('exp');
		
		//$users->sortByDesc('exp');
		
		return view('leaderboard.index', compact('users'));
		//return $users;
	}
	
	public function getUsersOrderByFilter($filter)
	{
		switch ($filter) {
			case 'exp':
			case 'coin':
				return $this->getUsersOrderByAssets($this->filters[$filter]);
			case 'avg_time':
				return $this->getUsersOrderByStatistics($this->filters[$filter], 'asc');
			case 'star':
			case 'time':
				return $this->getUsersOrderByStatistics($this->filters[$filter], 'desc');
		}
	}
	
	public function getUsersOrderByAssets($asset)
	{
		return User::orderBy($asset, 'desc')
				   ->take(50)
				   ->get();
	}
	
	public function getUsersOrderByStatistics($statistic, $order)
	{
		return Statistic::with('user')
						->orderBy($statistic, $order)
						->take(50)
						->get();
	}
}
