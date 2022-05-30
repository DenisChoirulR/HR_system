<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Http\Requests\EventRequest;
use DB;
use Mail;
use App\Mail\EventMail;
use App\User;
use Auth;
use Session;
//use helper;

class EventController extends Controller
{ 
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$events = Event::with('users')->where('type', 'others')->get();

		return view('event/event',['events'=>$events]);
	}

	public function add()
	{
		return view('event/form_event');
	}

	public function create(EventRequest $request)
	{   
		/*Check koneksi internet*/
		$connected = @fsockopen("www.mailgun.com", 80);  
		if ($connected == null){
		    return redirect('/no-internet-connection');
		    exit();
		}

		//get date
		$event_date = str_replace('/', '-', $request->date);
		$date = date("Y-m-d",strtotime($event_date));

		Event::create([
			'date' => $date,
			'type' => $request->type,
			'title' => $request->title,
			'note' => $request->note,
			'created_by' => $request->created_by
		]);

		//email to all user
		$user = user::all();
		foreach ($user as $u) {
			$data = array();
			$data['name'] = $u['name'];
			$data['title'] = $request->title;
			$data['type'] = $request->type;
			$data['date'] = $request->date;

			//email notifikasi
			Mail::to($u['email'])->send(new EventMail($data));
			//notifikasi aplikasi
			create_notification($request->title, 'dashboard', $u['id']);
		}
		Session::flash('message','Event added successfully');

		return redirect('/event'); 
	}

	public function edit($id)
	{
		$events = event::where('id',$id)->get();		
		return view('event/event_edit',['events'=>$events]);
	}

	public function update(EventRequest $request)
	{
		$event_date = str_replace('/', '-', $request->date);
		$date = date("Y-m-d",strtotime($event_date));
		event::where('id',$request->id)->update ([
			'date' => $date,
			'type' => $request->type,
			'title' => $request->title,
			'note' => $request->note,
		]);

		Session::flash('message','Event edited successfully');

		return redirect ('/event');
	}

	public function delete($id)
	{
		Event::find($id)->delete();
		Session::flash('message','event has been deleted');

		return redirect('/event');
	}
}
