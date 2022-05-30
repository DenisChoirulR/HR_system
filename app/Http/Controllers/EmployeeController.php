<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use DB;
use Session;

class EmployeeController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('admin_check');
	}
	
	public function index()
	{
		$employee = user::All();
		return view('employee/list_employee',['employee' => $employee]);
	}

	public function edit($id)
	{
		$employee = user::where('id', $id)->first();
		return view('employee/employee_edit',['employee' => $employee]);
	}

	public function update(Request $request)
	{
		$this->validate($request,[
			'name' => 'required',
			'email' => 'required',
			'gender' => 'required',
			'phone' => 'required',
			'address' => 'required',
			'marital_status' => 'required',
			'identity_card_no' => 'required',
		]);

		$birth_date = str_replace('/', '-', $request->date);
		$date = date("Y-m-d",strtotime($birth_date));
		
		$id = $request->id;
		$user = User::find($id);
		$user->name = $request->name;
		$user->email = $request->email;
		$user->gender = $request->gender;
		$user->birth_date = $date;
		$user->phone = $request->phone;
		$user->religion = $request->religion;
		$user->job_title = $request->job_title;
		$user->employee_type = $request->employee_type;
		$user->placement_location = $request->placement_location;
		$user->address = $request->address;
		$user->marital_status = $request->marital_status;
		$user->identity_card_no = $request->identity_card_no;
		$user->access_type = $request->access_type;
		$user->save();

		Session::flash('message','Employee data has been edited successfully');
		return redirect('/list-employee');
	}

	public function update_status(Request $request)
	{
		//console log (cmd)
		$out = new \Symfony\Component\Console\Output\ConsoleOutput();
		$out->writeln($request->post('active'));

		$id = $request->post('id');  
		$active = $request->post('active'); 

		// update database query
		DB::table('users')
			->where('id', $id)
			->update(['active' => $active]);

		// if success
		$response["status"] = 200;
		$response["active"] = $active;

		return json_encode($response); 
	}

	public function detail_employee($id)
	{
		$detail_employee = DB::table('users')->where('id',$id)->get();
		return view('employee/detail_employee',['detail_employee' => $detail_employee]);
	}

	public function delete($id)
	{
		try {
        	user::find($id)->delete();
        	Session::flash('message','Employee has been deleted');
        	return redirect('/list-employee');
        } catch (\Illuminate\Database\QueryException $e) {
        	Session::flash('error_message','Cant deleted the employee, there is any data from the employee');
        	return redirect('/list-employee');
        }
    }
}
