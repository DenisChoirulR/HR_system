<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User; 
use App\Event;

class ProfileController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	public function index()
	{
		$id = Auth::user()->id;
		$user = user::where('id', $id)->first();
		return view('profile/profile',['user' => $user]);
	}

	public function user_update(Request $request)
	{
		
		$birth_date = str_replace('/', '-', $request->date);
		$date = date("Y-m-d",strtotime($birth_date));

		$id = Auth::user()->id;
		$user = User::find($id);
		$user->name = $request->name;
		$user->email = $request->email;
		$user->gender = $request->gender;
		$user->birth_date = $date;
		$user->phone = $request->phone;
		$user->religion = $request->religion;
		$user->placement_location = $request->placement_location;
		$user->address = $request->address;
		$user->marital_status = $request->marital_status;
		$user->identity_card_no = $request->identity_card_no;
		$user->save();

		//event update
		Event::where('created_by',$id)->where('type', 'birthday')->update ([
			'date' => date("Y") . date("-m-d",strtotime($birth_date))
		]);
		return redirect('/profile');
	}

	public function ava_edit()
	{
		return view('/profile/ava_edit');
	}

	public function ava_update(Request $request){

		$request->validate([
			'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		]);

		$user = Auth::user();

		$avatarName = $user->id . '_' . preg_replace( '/[^a-z0-9]+/', '_', strtolower( $user->name ) ). '_' . time() . '.' . request()->avatar->getClientOriginalExtension();

		//store to public folder
		$request->avatar->storeAs('public',$avatarName);

		$user->avatar = $avatarName;
		$user->save();

		return back()
			->with('success','You have successfully upload image.');

	}
}
