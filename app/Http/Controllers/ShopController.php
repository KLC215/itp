<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Carbon\Carbon;
use ClassesWithParents\D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class ShopController
 * @package App\Http\Controllers
 */
class ShopController extends Controller
{
	
	/**
	 * ShopController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
	 * Show items in Shop page
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$items = Item::all();
		$coin = User::find(Auth::id())->coin;
		
		return view('shop.index', compact(['items', 'coin']));
	}
	
	/**
	 * Update user's coin and item quantity
	 */
	public function buyItems()
	{
		$data = request(['qty', 'itemId']);
		
		// Update user's balance
		$item = Item::find($data['itemId']);
		$user = User::findOrFail(Auth::id());
		
		$total = $item->features['cost'] * $data['qty'];
		$deal = $total - $user->coin <= 0;
		
		if (!$deal) {
			return [
				'success' => false,
				'msg'     => 'You don\'t have enough coin!',
			];
		}
		
		$user->coin = $user->coin - $total;
		$user->save();
		
		// Update item's quantity that the user has
		$item_user = DB::table('item_user')->where([
			['item_id', $data['itemId']],
			['user_id', $user->id],
		]);
		
		if ($item_user->exists()) {
			DB::table('item_user')->increment('quantity', $data['qty']);
		} else {
			DB::table('item_user')->insert([
				'item_id'    => $data['itemId'],
				'user_id'    => $user->id,
				'quantity'   => $data['qty'],
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			]);
		}
		
		return [
			'success' => true,
			'msg'     => "You have successfully bought items!",
		];
		
	}
	
}
