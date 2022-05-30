<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\user;
use App\event;
use App\attendance;
use Calendar;
use Auth;
use App\notification;

class DashboardController extends Controller
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
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{   
		//calendar
		$events = [];
		$data = DB::table('events')->join('users', 'users.id', '=', 'events.created_by')->get();

		if($data->count()){
			foreach ($data as $key => $value) {
				if ($value->type == "birthday") {
					$events[] = Calendar::event(
						$value->name.'`s '.$value->title,
						true,
						new \DateTime(date("Y") . date("-m-d",strtotime($value->date))),
						new \DateTime(date("Y") . date("-m-d",strtotime($value->date)).' +1 day')
					);
				}
				else{
					$events[] = Calendar::event(
						$value->name.'`s '.$value->title,
						true,
						new \DateTime($value->date),
						new \DateTime($value->date.' +1 day')
					);   
				}
			}
		}
		$calendar = Calendar::addEvents($events);
		//end calendar

		//What's going on
		$events = event::with('users')
		->with('substitute')
		->whereRaw('Date(date) >= CURDATE()')
		->orderBy('date', 'ASC')
		->get();

		//Announcement
		$announcement = DB::table('announcements')
		->whereRaw('Date(expired_at) >= CURDATE()')
		->orderBy('id', 'ASC')
		->get();

		//Time off summary
		$quota = DB::table('leave_types')->where('code','CT')->SUM('max_available');
		$used = DB::table('leaves')
		->join('leave_dates','leaves.id', '=', 'leave_dates.leave_id')
		->join('leave_types','leaves.leave_type_id', '=', 'leave_types.id')
		->where('user_id', Auth::user()->id)
		->where('leave_types.code', 'CT')
		->count();

		/*Attendance summary*/
		//on time
		$on_time = attendance::where('user_id', Auth::user()->id)
		->where('check_in','<=', '08:00')
		->count();

		//late
		$late = attendance::where('user_id', Auth::user()->id)
		->where('check_in','>', '08:00')
		->count();

		//best streak
		$attendance = attendance::where('user_id', Auth::user()->id)->get();
		$streak = 0;
		$best_streak = 0;
		foreach ($attendance as $a) {
			if (strtotime($a['check_in']) <= strtotime('8:00')) {
				$streak++;
				if ($streak > $best_streak) {
					$best_streak = $streak;
				}
			}
			else{
				$streak = 0;
			}
		}

		return view('dashboard')
		->with('calendar', $calendar)
		->with('events', $events)
		->with('announcement', $announcement)
		->with('quota', $quota)
		->with('used', $used)
		->with('on_time', $on_time)
		->with('late', $late)
		->with('best_streak', $best_streak);
	}

	public function not_yet_activated()
	{
		$active = Auth::user()->active;
		if ($active == 1) {
            return redirect('/dashboard');
        }
		return view('404');
	}    

	public function no_internet_connection()
	{
		return view('599');
	}    

	public function update_notification_status(Request $request) 
	{
		//console log (cmd)
		$out = new \Symfony\Component\Console\Output\ConsoleOutput();
		$out->writeln($request->post('id'));

		//get id
		$id = $request->post('id');
		
		//update notification status
		notification::where('id', $id)->update([
		 'read' => 1
		]);

		$response["id"] = $request->post('id');

		return json_encode($response);
	}

}
