<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('auth/login');
// });


Route::get('/', ['middleware' => 'auth', function () {
	return redirect('/dashboard');
}]);

Auth::routes();
Route::get('/not-yet-activated', 'DashboardController@not_yet_activated');
Route::get('/no-internet-connection', 'DashboardController@no_internet_connection');

Route::group(['middleware'=> ['active_check']], function()
{
	Route::get('/dashboard', 'DashboardController@index')->name('home');

	Route::get('/leave-list', 'LeaveController@index');
	Route::get('/leave-form/{id}', 'LeaveController@leave_form');
	Route::post('/leave-create', 'LeaveController@leave_create');
	Route::get('/leave-edit/{id}', 'LeaveController@leave_edit');
	Route::post('/leave-update', 'LeaveController@leave_update');
	Route::get('/leave-detail/{id}', 'LeaveController@leave_detail');

	Route::get('/leave-cancel/{id}', 'LeaveController@leave_cancel');
	Route::get('/leave-accept/{id}', 'LeaveController@leave_accept');
	Route::get('/leave-approve/{id}', 'LeaveController@leave_approve');
	Route::get('/leave-reject/{id}', 'LeaveController@leave_reject');

	Route::get('/leave-type-add', 'LeaveController@add_leave_type');
	Route::post('/leave-type-create', 'LeaveController@leave_type_create');
	Route::get('/leave-type-edit/{id}', 'LeaveController@leave_type_edit');
	Route::post('/leave-type-update', 'LeaveController@leave_type_update');
	Route::get('/leave-type-delete/{id}', 'LeaveController@leave_type_delete');

	Route::get('/list-employee', 'EmployeeController@index');
	Route::get('/detail-employee/{id}', 'EmployeeController@detail_employee');
	Route::get('/employee-edit/{id}', 'EmployeeController@edit');
	Route::post('/employee-update', 'EmployeeController@update');
	Route::post('/update-status', 'EmployeeController@update_status');
	Route::get('/employee-delete/{id}', 'EmployeeController@delete');

	Route::get('/calendar', 'CalendarController@index');

	Route::get('/profile', 'ProfileController@index');
	Route::post('/user-update', 'ProfileController@user_update');
	Route::get('/ava-edit', 'ProfileController@ava_edit');
	Route::post('/ava-update', 'ProfileController@ava_update');

	Route::get('/event', 'EventController@index');
	Route::get('/event-add', 'EventController@add');
	Route::post('/event-form', 'EventController@create');
	Route::get('/event-edit/{id}', 'EventController@edit');
	Route::post('/event-update', 'EventController@update');
	Route::get('/event-delete/{id}', 'EventController@delete');

	Route::get('/announcement', 'AnnouncementController@index');
	Route::get('/announcement-add', 'AnnouncementController@add');
	Route::post('/announcement-form', 'AnnouncementController@create');
	Route::get('/announcement-edit/{id}', 'AnnouncementController@edit');
	Route::post('/announcement-update', 'AnnouncementController@update');
	Route::get('/announcement-delete/{id}', 'AnnouncementController@delete');

	Route::get('/list-substitute', 'LeaveController@leave_substitute');

	Route::get('/attendance', 'AttendanceController@index');
	Route::get('/attendance-import', 'AttendanceController@import_attendance');
	Route::post('/uploadFile', 'AttendanceController@uploadFile');

	Route::post('/update-notification-statuss', function() {
	    update_notification_status();
	});

	Route::post('/update-notification-status', 'DashboardController@update_notification_status');

    
});

