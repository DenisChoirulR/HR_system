<?php
use Auth as user;
use DB as DB; 
use App\Notification as notification;
use Illuminate\Http\Request as Request;

function greeting($name = 'user') {

	$time = date("H");
	$timezone = date("e");
	
	if ($time < "12") {
	    $greeting = "Good Morning";
	} elseif ($time >= "12" && $time < "17") {
	    $greeting = "Good Afternoon";
	} elseif ($time >= "17" && $time < "19") {
	    $greeting = "Good Evening";
	} elseif ($time >= "19") {
	    $greeting = "Good Night";
	}

	return $greeting . ", " .  $name . "!"; 
}
function generate_rand_material_color() {
	$hexArr = array("#54bc00");

	return $hexArr[array_rand($hexArr)];
}

function notification() {
	$user_id = Auth::user()->id;
	$notification = notification::where('user_id', $user_id)
	->where('read', 0)->get();

	return $notification;
}

function notification_count() {
	return notification()->count();
}

function create_notification($message = 'message', $link = 'link', $user_id = 'user_id') {
	notification::create([
		'user_id'		 => (int)$user_id,
		'message' 		 => $message,
		'target_link'	 => $link
	]);
}

// function update_notification_status($id) {	
// 	return notification::where('id', $id)->update([
// 		'read' => 1
// 	]);
// }

function mailgun_connection() {	
	$connected = @fsockopen("www.mailgun.com", 80); 
	//website, port  (try 80 or 443)
	if ($connected){
	    //
	}else{
		echo "string";
	    return redirect('/no-internet-connection');
	    exit();
	}
}