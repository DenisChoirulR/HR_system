<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\LeaveRequest;
use App\Leave;
use App\User;
use App\Leave_type;
use App\Leave_date;
use App\Event;
use Auth;
use Mail;
use App\Mail\LeaveRequestMail;
use App\Mail\YourLeaveRequestMail;
use App\Mail\InfoLeaveRequestMail;
use App\Mail\SubstituteAcceptMail; 
use App\Mail\InfoAdminAcceptMail; 
use App\Mail\LeaveApprovedMail;
use App\Mail\InfoLeaveApprovedAdmin;
use App\Mail\InfoLeaveApprovedSubstitute;
use App\Mail\LeaveRejectedMail;
use App\Mail\InfoLeaveRejectedSubtituteMail;
use App\Mail\InfoLeaveRejectedAdminMail;
use App\Mail\LeaveCancelledMail;
use App\Mail\InfoLeaveCancelAdminMail;
use App\Mail\InfoLeaveCancelSubstituteMail;
use Session;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
	{
        $curr_user_id = Auth::user()->id;

        /********************************************************

        Algorithm to calculate the quota for each leave type:

        1. Get all leave_types (we want to match ids between two data sets (leave_type vs leave_usage)).
        2. Get all requested leaves (need to left join with multiple tables).
        3. Find the missing ids (the diff) between leave_type and leave_usage. If there are missing ids found, means that the user has used the quota, else show we need to add "used_count" attribute which doesn't exist before. This step is meant to handle the error from the missing count attribute.

        **********************************************************/
        /*leave types list start*/
        // Step 1: Get all leave_types
        $leave_types = DB::table('leave_types')
        ->select('id', 'name', 'max_available')
        ->get();

        // Step 2: Get all requested leaves / leave_usages
        $leave_usages = DB::table('leave_types')
        ->selectRaw('`leave_types`.`id`, `leave_types`.`name`, `leave_types`.`code`, `max_available`, `leaves`.`user_id`, count(*) as "used_count"')
        ->leftJoin('leaves', 'leave_types.id', '=', 'leaves.leave_type_id')
        ->leftJoin('leave_dates','leaves.id', '=', 'leave_dates.leave_id')
        ->whereYear('requested_date', '=', date("Y"))
        ->where('user_id', "=" , $curr_user_id)
        ->where('status', 'approved')
        ->groupBy('leave_types.code')
        ->groupBy('leave_types.id')
        ->groupBy('leave_types.name')
        ->groupBy('leave_types.max_available')
        ->groupBy('leaves.user_id')
        ->get();

        // Step 3: Find the diff between leave_usages and leave_types
        if ( count($leave_usages) < count($leave_types) ) {

            $leave_usage_ids = array();
            $leave_type_ids = array();

            foreach ($leave_usages as $key => $value) {
                $leave_usage_ids[] = $value->id;
            }

            foreach ($leave_types as $key => $value) {
                $leave_type_ids[] = $value->id;
            }
            
            $diff_leave_type_ids =  array_diff($leave_type_ids, $leave_usage_ids);

            foreach ($leave_types as $leave_type) {
                foreach ($diff_leave_type_ids as $diff_leave_type_id) {
                    if ( $leave_type->id == $diff_leave_type_id) {
                        $leave_type = (object) array_merge( (array)$leave_type, array( 'used_count' => 0 ) );
                        $leave_usages[] = $leave_type;
                        break;
                    }
                }
            }
        }
        /*leave types list end*/

        //Time off list
        //level user
        $leave_request = leave::with('leave_dates')->with('leave_types')->with('users')
        ->where('user_id',$curr_user_id)
        ->get();

        //level admin
        if (Auth::user()->access_type == "admin"){
             $leave_request = leave::with('leave_dates')->with('leave_types')->with('users')->get();
        }

        //Time off sub
        //level user
        $substitute_leave = leave::with('leave_dates')->with('users')->with('substitute')
        ->where('substitute_user_id',$curr_user_id)
        ->where('status', '!=', 'cancelled')
        ->get();

        //level admin
        if (Auth::user()->access_type == "admin"){
             $substitute_leave = leave::with('leave_dates')->with('users')->with('substitute')
            ->where('status', '!=', 'cancelled')
            ->get();
        }

        return view('leave/leave_list')
        ->with('leave_usages', $leave_usages)
        ->with('leave_request', $leave_request)
        ->with('substitute_leave', $substitute_leave);
	}

	public function add_leave_type()
	{
		return view('leave/leave_type_add');
	}

	public function leave_type_create(Request $request)
	{
		Leave_type::create([
		'name' => $request->name,
		'code' => $request->code,
		'max_available' => $request->max_available,
		'policy_note' => $request->policy_note,
		]);
        Session::flash('message','Leave type added successfully');

		return redirect('/leave-list');
	}

    public function leave_type_edit($id)
    {
        $leave_type = Leave_type::where('id',$id)->get();
        return view('leave/leave_type_edit',['leave_type' => $leave_type]);
     
    }

    public function leave_type_update(Request $request)
    {
        Leave_type::where('id',$request->id)->update([
        'name' => $request->name,
        'code' => $request->code,
        'max_available' => $request->max_available,
        'policy_note' => $request->policy_note
        ]);
        Session::flash('message','Leave type edited successfully');

        return redirect('/leave-list');
    }

    public function leave_type_delete($id)
    {
        Leave_type::where('id',$id)->delete();        
        Session::flash('message','Leave type has been deleted');
        return redirect('/leave-list');
    }

	public function leave_edit($id)
	{
		$leaves = leave::with('leave_types')
		->where('leaves.id',$id)
		->get();
		return view('leave/leave_edit',['leaves' => $leaves]);
	}

	public function leave_update(Request $request)
	{
		Leave::where('leaves.id',$request ->id)-> update ([
    		'id' => $request ->id,
    		'leave_note' => $request ->leave_note,
            'work_note' => $request ->work_note,
    	]);
        Session::flash('message','Leave edited successfully');

    	return redirect ('/leave-list');

    }

    public function leave_cancel(Request $request)
	{
        /*Check koneksi internet*/
        $connected = @fsockopen("www.mailgun.com", 80);  
        if ($connected == null){
            return redirect('/no-internet-connection');
            exit();
        }
		Leave::where('leaves.id',$request->id)-> update ([
            'status' => "cancelled",
    	]);

        //mail component
        $user = leave::join('users','users.id', '=', 'leaves.user_id')->where('leaves.id',$request->id)->first();
        $substitute = leave::join('users','users.id', '=', 'leaves.substitute_user_id')->where('leaves.id',$request->id)->first();
        $leave_type = leave_type::where('id', $user->leave_type_id)->first();
        
        $name = array();
        $name['name'] = Auth::user()->name;
        $name['substitute_name'] = $substitute->name;
        $name['leave_name'] = $leave_type->name;
        $name['leave_note'] = $user->leave_note;

        /*Mail To User*/
        Mail::to($user['email'])->send(new LeaveCancelledMail($name));
        /*Mail To Substitute*/
        Mail::to($substitute['email'])->send(new InfoLeaveCancelSubstituteMail($name));
        /*Mail To Admin*/
        $admin = user::where('access_type','admin')->get();
        foreach ($admin as $u) {
            $data = array();
            $data['name'] = $u['name'];
            $data['substitute_name'] = $substitute->name;
            $data['user_name'] = $user->name;
            $data['leave_name'] = $leave_type->name;
            $data['leave_note'] = $user->leave_note;

            Mail::to($u['email'])->send(new InfoLeaveCancelAdminMail($data));
        }

        Session::flash('message','Leave has been canceled');
    	return back();
    }

    public function leave_form($id)
    {
    	// mengambil data dari table leave_type
        $leave_types = Leave_type::where('leave_types.id',$id)->get();
        $employee = User::where('id', '!=', Auth::user()->id)->where('active', '=', 1)->get();

        return view('/leave/leave_form')
        ->with('leave_types', $leave_types)
        ->with('employee', $employee);

    }

    public function leave_create(LeaveRequest $request)
    {
        /*Check koneksi internet*/
        $connected = @fsockopen("www.mailgun.com", 80);  
        if ($connected == null){
            return redirect('/no-internet-connection');
            exit();
        }

        //memecah inputan tanggal string menjadi array
    	$dates = explode (",",$request->leave_dates);

        //mengubah array $dates string menjadi dates
        $req = array();
    	foreach ($dates as $key => $value) {
    		$req[] = date("Y-m-d",strtotime($value));
    	}

        //validasi tanggal in the future
        foreach ($req as $r) {
            if ($r <= date ("Y-m-d")) {
                return back()
                ->with('alert','Requested date should be in the future!');
            }
        }

        /*validasi tanggal sama*/
        //get tanggal yang telah di request
    	$current_dates = DB::table('leaves')
    	->leftjoin('leave_dates','leaves.id','=', 'leave_dates.leave_id')
    	->where('user_id', Auth::user()->id)
        ->whereYear('requested_date', '=', date("Y"))
    	->get('requested_date');
        
        //menghilangkan key dalam $current_dates
        $date = array();
    	foreach ($current_dates as $key => $value) {
    		$date[] = $value->requested_date;
    	}
    	
        //mencari persamaan array
    	$check =  array_intersect($date, $req);

        //validasi tanggal sama
    	if ($check != null) {
    		return back()
            ->with('alert','You have requested the same time-off date. Please choose another date!');
    	}


        /*validasi jumlah quota*/
        //mengambil jumlah quota
        $quota = DB::table('leave_types')
        ->where('id', $request->leave_type_id)
        ->get('max_available');
        
        //mengambil jumlah cuti yang telah diambil
        $used = DB::table('leaves')
        ->join('leave_dates', 'leave_dates.leave_id', '=', 'leaves.id')
        ->where('leave_type_id', $request->leave_type_id)
        ->where('user_id', Auth::user()->id)
        ->whereYear('requested_date', '=', date("Y"))
        ->get();

        $quota = $quota[0]->max_available;
        $used = count($used);     
        $requested = count($dates);

        //validasi jumlah quota
        if ($quota < ($used + $requested)) {
            return back()
            ->with('alert','quota is not available');
        }

        /*validasi memiliki cuti on process*/
        //get cuti on process
        $requested_leave = leave::where('leave_type_id', $request->leave_type_id)
        ->where('user_id', Auth::user()->id)
        ->whereIn('status', ['requested','accepted'])
        ->count();

        //validasi cuti on process
        if ($requested_leave != 0) {
            return back()
            ->with('alert','you have on proses requested leave');
        }

        //input cuti
    	Leave::create ([
    	'user_id' => $request->user_id,
    	'leave_type_id' => $request->leave_type_id,
    	'substitute_user_id' => $request->substitute_user_id,
    	'leave_note' => $request->leave_note,
    	'work_note' => $request->work_note,
    	]);

        //get newest Leave_id
    	$newestleave = DB::table('leaves')->orderBy('id', 'desc')->first();
        $max_id = $newestleave->id;

        foreach ($dates as $value) {
        	Leave_date::create ([
			'requested_date' => date("Y-m-d",strtotime($value)),
			'leave_id' => $max_id,
			]);
        }

        /* mail Request */
        $substitute = user::find($request->substitute_user_id);
        $user = user::find(Auth::user()->id);
        $subs_name=leave::join('users','users.id', '=', 'leaves.substitute_user_id')->where('leaves.substitute_user_id', $request->substitute_user_id)->first();
        $leave_type = leave_type::where('id', $request->leave_type_id)->first();

        $data = array();
        $data['user_name'] = Auth::user()->name;
        $data['substitute_name'] = $subs_name->name;
        $data['leave_name'] = $leave_type->name;
        $data['leave_note'] = $request->leave_note;
        
        //Mail to Substitute
        Mail::to($substitute['email'])->send(new LeaveRequestMail($data));
        create_notification('Leave Request', 'leave-list', $substitute['id']);

        /* mail Request to User */
        Mail::to($user['email'])->send(new YourLeaveRequestMail($data));
        
        /* mail Request to admin */
        $admin = user::where('access_type','admin')->get();

        foreach ($admin as $u) {
            $data = array();
            $data['user_name'] = Auth::user()->name;
            $data['substitute_name'] = $subs_name->name;
            $data['leave_name'] = $leave_type->name;
            $data['leave_note'] = $request->leave_note;

            Mail::to($u['email'])->send(new InfoLeaveRequestMail($data));
            create_notification('Leave Request', 'leave-list', $u['id']);
        }

        Session::flash('message','Your Leave has been requested');

    	return redirect('/leave-list');
    }

    public function leave_detail($id)
    {
        $leave_detail = leave::with('leave_types')->with('substitute')->with('leave_dates')
		->where('leaves.id',$id)
		->first();
		return view('leave/leave_detail',['leave_detail' => $leave_detail]);
    }

    public function leave_accept(Request $request)
	{
        /*Check koneksi internet*/
        $connected = @fsockopen("www.mailgun.com", 80);  
        if ($connected == null){
            return redirect('/no-internet-connection');
            exit();
        }

		leave::where('id',$request->id)-> update ([
            'status' => "accepted",
            'accepted_by' => Auth::user()->id,
            'accepted_at' => date("Y-m-d h:i:s")
    	]);

        //mail
        $user = leave::join('users','users.id', '=', 'leaves.user_id')->where('leaves.id',$request->id)->first();
        $leave_type = leave_type::where('id', $user->leave_type_id)->first();
        /* Mail */
        $substitute = user::find($request->substitute_user_id);
        $name = array();
        $name['substitute_name'] = Auth::user()->name;
        $name['name'] = $user->name;
        $name['leave_name'] = $leave_type->name;
        $name['leave_note'] = $user->leave_note;

        //to user
        Mail::to($user['email'])->send(new SubstituteAcceptMail($name));
        create_notification('Leave Accept', 'leave-list', $user['id']);

        /* Mail to Admin */
        $admin = user::where('access_type','admin')->get();
        foreach ($admin as $u) {
            $data = array();
            $data['name'] = $u['name'];
            $data['substitute_name'] = Auth::user()->name;
            $data['user_name'] = $user->name;
            $data['leave_name'] = $leave_type->name;
            $data['leave_note'] = $user->leave_note;

            Mail::to($u['email'])->send(new InfoAdminAcceptMail($data));
            create_notification('Leave Accept', 'leave-list', $u['id']);
        } 

        Session::flash('message','Leave has been accepted');
    	return back();
    }

    public function leave_approve(Request $request)
	{
        /*Check koneksi internet*/
        $connected = @fsockopen("www.mailgun.com", 80);  
        if ($connected == null){
            return redirect('/no-internet-connection');
            exit();
        }

		leave::where('id',$request->id)-> update ([
            'status' => "approved",
            'approved_by' => Auth::user()->id,
            'approved_at' => date("Y-m-d h:i:s")
    	]);

        //mail component
        $user = leave::join('users','users.id', '=', 'leaves.user_id')->where('leaves.id',$request->id)->first();
        $substitute = leave::join('users','users.id', '=', 'leaves.substitute_user_id')->where('leaves.id',$request->id)->first();
        $approved_by = leave::join('users','users.id', '=', 'leaves.approved_by')->where('leaves.id',$request->id)->first();
        $leave_type = leave_type::where('id', $user->leave_type_id)->first();

        $name = array();
        $name['admin'] = Auth::user()->name;
        $name['name'] = $user->name;
        $name['substitute_name'] = $substitute->name;
        $name['leave_name'] = $leave_type->name;
        $name['leave_note'] = $user->leave_note;

        /*Mail To User*/
        Mail::to($user['email'])->send(new LeaveApprovedMail($name));
        create_notification('Leave Approve', 'leave-list', $user['id']);
        /*Mail To Substitute*/
        Mail::to($substitute['email'])->send(new InfoLeaveApprovedSubstitute($name));
        create_notification('Leave Approve', 'leave-list', $substitute['id']);
        /*Mail To Admin*/
        $admin = user::where('access_type','admin')->get();
        foreach ($admin as $u) {
            $data = array();
            $data['name'] = $u['name'];
            $data['substitute_name'] = $substitute->name;
            $data['user_name'] = $user->name;
            $data['admin'] = $approved_by->name;
            $data['leave_name'] = $leave_type->name;
            $data['leave_note'] = $user->leave_note;

            Mail::to($u['email'])->send(new InfoLeaveApprovedAdmin($data));
            create_notification('Leave Approve', 'leave-list', $u['id']);
        } 


        //event create
        $dates = leave_date::with('leaves')->where('leave_id',$request->id)->get();
        foreach ($dates as $key => $value) {
        event::create ([
            'date' => $value->requested_date,
            'type' => "leave",
            'title' =>"leave",
            'note' => $value->leaves->leave_note,
            'user_id' => $value->leaves->substitute_user_id,
            'created_by' => $value->leaves->user_id,
            ]);
        }
        Session::flash('message','Leave has been approved');

    	return back();
    }

    public function leave_reject(Request $request)
	{
        /*Check koneksi internet*/
        $connected = @fsockopen("www.mailgun.com", 80);  
        if ($connected == null){
            return redirect('/no-internet-connection');
            exit();
        }
        
        //delete accepted_by and accepted at
        if (Auth::user()->access_type != "admin") {
            leave::where('id',$request ->id)-> update ([
                'accepted_by' => "",
                'accepted_at' => ""
            ]); 
        }
        
		leave::where('id',$request ->id)-> update ([
            'status' => "rejected",
            'rejected_by' => Auth::user()->id,
            'rejected_at' => date("Y-m-d h:i:s")
    	]);

        /*Mail Component*/
        $user = leave::join('users','users.id', '=', 'leaves.user_id')->where('leaves.id',$request->id)->first();
        $substitute = leave::join('users','users.id', '=', 'leaves.substitute_user_id')->where('leaves.id',$request->id)->first();
        $leave_type = leave_type::where('id', $user->leave_type_id)->first();

        $name = array();
        $name['rejected_by'] = Auth::user()->name;
        $name['name'] = $user->name;
        $name['substitute_name'] = $substitute->name;
        $name['leave_name'] = $leave_type->name;
        $name['leave_note'] = $user->leave_note;


        /*Mail To user*/
        Mail::to($user['email'])->send(new LeaveRejectedMail($name));
        create_notification('Leave Reject', 'leave-list', $user['id']);
        /*Mail To substitute*/
        Mail::to($substitute['email'])->send(new InfoLeaveRejectedSubtituteMail($name));
        create_notification('Leave Reject', 'leave-list', $substitute['id']);
        /*Mail To Admin*/
        $admin = user::where('access_type','admin')->get();
        foreach ($admin as $u) {
            $data = array();
            $data['name'] = $u['name'];
            $data['substitute_name'] = $substitute->name;
            $data['user_name'] = $user->name;
            $data['rejected_by'] = Auth::user()->name;
            $data['leave_name'] = $leave_type->name;
            $data['leave_note'] = $user->leave_note;

            Mail::to($u['email'])->send(new InfoLeaveRejectedAdminMail($data));
            create_notification('Reject', 'leave-list', $u['id']);
        } 

        Session::flash('message','Leave has been rejected');

    	return back();
    }
}
