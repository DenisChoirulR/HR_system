<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Announcement;
use App\Http\Requests\AnnouncementRequest;
use DB;
use Mail;
use App\Mail\AnnouncementMail; 
use App\User;
use Auth;
use Session;

 

class AnnouncementController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('admin_check');
	}
	
	public function index()
	{
		$announcements = Announcement::with('users')->get();

		return view('announcement/announcement',['announcements'=>$announcements]);
	}

	public function add()
	{
		return view('announcement/form_announcement');
	}


	public function create(AnnouncementRequest $request)
	{
		/*Check koneksi internet*/
		$connected = @fsockopen("www.mailgun.com", 80);  
		if ($connected == null){
		    return redirect('/no-internet-connection');
		    exit();
		}
		
		/*Mengubah date sesuai dengan database*/
		$announcement_date = str_replace('/', '-', $request->expired_at);
		$date = date("Y-m-d",strtotime($announcement_date));

		/*Menginputkan data pengumuman ke dalam database*/
		Announcement::create([
			'title' => $request->title,
			'note' => $request->note,
			'user_id' => $request->user_id,
			'expired_at' => $date
		]);

		/*Membuat notifikasi di dashboard dan notifikasi email dengan mailgun*/

		//Mengambil seluruh data user
		$user = user::all();
		foreach ($user as $value) {
			$data = array();
			$data['name'] = $value['name'];
			$data['title'] = $request ->title;
			$data['expired_at'] = $request->expired_at;

			//Mengirim email announcement kepada user
			Mail::to($value['email'])->send(new AnnouncementMail($data));
			//Membuat notifikasi di dashboard
			create_notification($request->title, 'dashboard', $value['id']);
		}


		Session::flash('message','Announcement added successfully');

		return redirect('/announcement');
	}

	public function edit($id)
	{
		$announcements = Announcement::where('id', $id)->get();
		
		return view('announcement/announcement_edit',['announcements'=>$announcements]);

	}

	public function update(AnnouncementRequest $request)
	{
		/*Mengubah date sesuai dengan database*/
		$announcement_date = str_replace('/', '-', $request->expired_at);
		$date = date("Y-m-d",strtotime($announcement_date));

		/*Update Announcement*/
		Announcement::find($request ->id)-> update ([
			'title' => $request ->title,
			'note' => $request ->note,
			'employee_id' => $request ->employee_id,
			'expired_at' => $date
		]);

		Session::flash('message','Announcement edited successfully');

		return redirect ('/announcement');
	}

	public function delete($id)
	{
		Announcement::find($id)->delete();
		Session::flash('message','Announcement has been deleted');

		return redirect('/announcement');
	}
}
