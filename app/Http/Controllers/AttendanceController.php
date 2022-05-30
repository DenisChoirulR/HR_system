<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\attendance;
use DB;
use Auth;
use App\Http\Requests\AttendanceRequest;

class AttendanceController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  
	public function index()
	{ 
    /*Filter pada menu attendance*/
    $id = Auth::user()->id;   
    $month = '';
    $year = '';
    
    if(isset($_GET['month'])) {
      $month = $_GET['month'];
    }

    if(isset($_GET['year'])) {
      $year = $_GET['year'];
    }

    /*select tahun attendance*/
    $year_select = Attendance::orderBy('date')->get();

    /*Menampilkan data attendance pada level user*/
    $attendance = Attendance::where('user_id', $id)->whereMonth('date', 'like', '%'.$month.'%')
    ->whereYear('date', 'like', '%'.$year.'%')->orderBy('date', 'desc')->get();

    /*Menampilkan data attendance pada level admin*/
    if(Auth::user()->access_type == "admin"){
      $attendance = Attendance::with('users')->whereMonth('date', 'like', '%'.$month.'%') 
    ->whereYear('date', 'like', '%'.$year.'%')->orderBy('date', 'desc')->get();
    }

    return view('attendance/attendance_list')
        ->with('attendance',$attendance)
        ->with('year_select',$year_select)
        ->with('year',$year)
        ->with('month',$month);
	}

  public function import_attendance()
  {   
    return view('attendance/import_attendance');
  }

	public function uploadFile(AttendanceRequest $request){

    if ($request->input('submit') != null ){

      $file = $request->file('file');

      // File Details 
      $filename = $file->getClientOriginalName();
      $extension = $file->getClientOriginalExtension();
      $tempPath = $file->getRealPath();
      $fileSize = $file->getSize();
      $mimeType = $file->getMimeType();

      // Valid File Extensions
      $valid_extension = array("csv");

      // 2MB in Bytes
      $maxFileSize = 2097152; 

      // Check file extension
      if(in_array(strtolower($extension),$valid_extension)){

        // Check file size
        if($fileSize <= $maxFileSize){

          // File upload location
          $location = 'uploads';

          // Upload file
          $file->move($location,$filename);

          /*Import CSV to Database*/
          // Cari filepath
          $filepath = public_path($location."/".$filename);

          // Reading file
          $file = fopen($filepath,"r");

          $importData_arr = array();
          $i = 0;

          while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
             $the_big_Array[] = $filedata;

             $num = count($filedata );
             
             if($i == 0){
                $i++;
                continue;
             }
             for ($c=0; $c < $num; $c++) {
                $importData_arr[$i][] = $filedata [$c];
             }
             $i++;
          }
          fclose($file);

          /*Membuat array memiliki key dan index*/
          $csv = array();
          $n = 0;
          foreach ($importData_arr as $key => $value) {
            $csv[$n][($the_big_Array[0][0])] = $value[0];
            $csv[$n][($the_big_Array[0][1])] = $value[1];
            $csv[$n][($the_big_Array[0][2])] = $value[2];
            $csv[$n][($the_big_Array[0][3])] = $value[3];
            $csv[$n][($the_big_Array[0][4])] = $value[4];
            $n++;
          }

          //format validation for check_in || check_out
          foreach ($csv as $c) {
            $id = $c['id'];
            if ($id == 0) {
              Session::flash('message','Invalid data format (id)');
              return redirect()->action('AttendanceController@index');
            }
            
            $in = $c['check in'];
            if (strtotime($in) == null) {
              Session::flash('message','Invalid data format (check in)');
              return redirect()->action('AttendanceController@index');
            }

            $out = $c['check out'];
            if (strtotime($out) == null) {
              Session::flash('message','Invalid data format (check out)');
              return redirect()->action('AttendanceController@index');
            }

            $date = str_replace('/', '-', $c['date']);
            if (date("Y-m-d",strtotime($date)) == "1970-01-01") {
              Session::flash('message','Invalid data format (date)');
              return redirect()->action('AttendanceController@index');
            }
          }

          //breakdown
          $added = 0;
          $updated = 0;
          $failed = 0;

          //insert ke database
          foreach ($csv as $value) {
            $data = array(
              "date"=>str_replace('/', '-', $value['date']),
              "user_id"=>$value['id'],
              "check_in"=>$value['check in'],
              "check_out"=>$value['check out']);

            //Mengambil data kehadiran dengan user_id dan tanggal saama dengan request
            $value=Attendance::where('date', $data['date'])->where('user_id', $data['user_id'])->get();

            //breakdown status create
            if($value->count() == 0){
               Attendance::create($data);
               $added++;
            }

            //Breakdown status update
            else{
              Attendance::where('date', $data['date'])
                ->where('user_id', $data['user_id'])
                ->update([
                  "check_in"=>$data['check_in'],
                  "check_out"=>$data['check_out']
                ]);
              $updated++;
            }
          }  

          //breakdiwn status failed
          $failed = count($csv)-($added + $updated);

          Session::flash('added','Added   :'.$added);
          Session::flash('updated','Updated :'.$updated);
          Session::flash('failed','Failed  :'.$failed);
        }else{
          Session::flash('message','File too large. File must be less than 2MB.');
        }

      }else{
         Session::flash('message','Invalid File Extension.');
      }

    }

    // Redirect to index
    return redirect()->action('AttendanceController@index');
  }

}
