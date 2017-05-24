<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Statistic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	public function index()
	{
		$user = Auth::user();
		
		$statistics = User::find(Auth::id())->hasStatistic;
		
		$badges = User::find(Auth::id())->badges;
		$allBadges = Badge::all();
		
		$logs = DB::table('user_operation_logs')
				  ->where('user_id', Auth::id())
				  ->orderBy('created_at', 'desc')
				  ->get();
		
		$isMe = true;
		
		return view('profile.index',
			compact(['user', 'statistics', 'badges', 'logs', 'isMe', 'allBadges'])
		);
	}
	
	public function browseOtherUserProfile($slug)
	{
		$isMe = false;
		
		$user = User::whereSlug($slug)->firstOrFail();
		
		$statistics = User::find($user->id)->hasStatistic;
		
		$badges = User::find($user->id)->badges;
		$allBadges = Badge::all();
		
		$logs = User::find($user->id)->logs;
		
		if ($user->id == Auth::id()) {
			$isMe = true;
		}
		
		return view('profile.index',
			compact(['user', 'statistics', 'badges', 'logs', 'isMe', 'allBadges'])
		);
	}
	
	public function resetPasswordPage()
	{
		$isMe = true;
		$user = Auth::user();
		
		return view('profile.account', compact(['user', 'isMe']));
	}
	
	public function updatePassword()
	{
		flash()->clear();
		$user = User::find(Auth::id());
		$request = request(['oldPassword', 'newPassword', 'confirmPassword']);
		
		foreach ($request as $key => $value) {
			if (empty($value)) {
				flash('The form cannot be empty!')->error();
				
				return view('profile.account', compact('user'));
			}
		}
		
		if (!Hash::check($request['oldPassword'], $user->password)) {
			logMessage('You tried to update password in ' . Carbon::now());
			flash('The old password does not match our record!')->error();
			
			return view('profile.account', compact('user'));
		} else if ($request['newPassword'] != $request['confirmPassword']) {
			logMessage('You tried to update password in ' . Carbon::now());
			flash('The confirmation password does not match the new password')->error();
			
			return view('profile.account', compact('user'));
		}
		
		$user->password = bcrypt($request['newPassword']);
		$user->save();
		
		logMessage('You updated your password!');
		flash('Password has been updated!')->success();
		
		return view('profile.account', compact('user'));
	}
}
