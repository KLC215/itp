<?php

use Carbon\Carbon;

function logMessage($message)
{
	DB::table('user_operation_logs')->insert([
		'user_id'    => Auth::id(),
		'log'        => $message,
		'created_at' => Carbon::now(),
		'updated_at' => Carbon::now(),
	]);
}