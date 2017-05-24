<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\Statistic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$this->createStatistics();
		
		$stages = Stage::where('parent_id', '=', null)->get();
		
		
		return view('home', compact('stages'));
	}
	
	private function createStatistics()
	{
		$user = Auth::user();
		
		if (!$user->statistics_id) {
			$id = DB::table('statistics')->insertGetId([
				'average_time_taken' => '00:00:00',
				'time_spent_coding'  => '00:00:00',
				'star_received'      => 0,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);
			
			$user->statistics_id = $id;
			$user->save();
		}
		
		
	}
	
}
