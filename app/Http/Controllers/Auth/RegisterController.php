<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use App\Mail\RegisterMail;
use App\Mail\GreetingsNewMemberMail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'gender' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'religion' => ['required', 'string', 'max:255'],
            'job_title' => ['required', 'string', 'max:255'],
            'employee_type' => ['required', 'string', 'max:255'],
            'placement_location' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'marital_status' => ['required', 'string', 'max:255'],
            'identity_card_no' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        /*Check koneksi internet*/
        $connected = @fsockopen("www.mailgun.com", 80);  
        if ($connected == null){
            return redirect('/no-internet-connection');
            exit();
        }
        
        /*Mengubah format tanggal dari blade menyesuaikan database*/

        /*Birthdate*/
        $birth_date = str_replace('/', '-', $data['birth_date']);
        $birth_date  = date("Y-m-d",strtotime($birth_date));
        //startdate
        $start_date = str_replace('/', '-', $data['start_date']);
        $start_date  = date("Y-m-d",strtotime($start_date));

        /*Menambahkan user ke tabel user*/
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'gender' => $data['gender'],
            'birth_date' => $birth_date,
            'phone' => $data['phone'],
            'religion' => $data['religion'],
            'job_title' => $data['job_title'],
            'employee_type' => $data['employee_type'],
            'placement_location' => $data['placement_location'],
            'start_date' => $start_date,
            'address' => $data['address'],
            'marital_status' => $data['marital_status'],
            'identity_card_no' => $data['identity_card_no']
        ]);

        /*Menambahkan birthdate ke tabel event*/
        Event::create([
            'date' => date("Y") . date("-m-d",strtotime($birth_date)),
            'type' => "birthday",
            'title' => "birthday",
            'note' => "Happy Birthday",
            'user_id' => $user->id,
            'created_by' => $user->id
        ]);
 
    /*Email Greetings New Member*/

        /*Mengambil data yang akan dikirim ke email*/
        $user = user::find($user->id);
        $data_user = array();
        $data_user['name'] = $data['name'];

        /*Mengirim email greetings new member*/
        Mail::to($user['email'])->send(new GreetingsNewMemberMail($data_user));

    /*Email New Member Info*/

        /*Mengambil user admin*/
        $admin = user::where('access_type','admin')->get();

        /*Mengirimkan email new member info ke setiap admin*/
        foreach ($admin as $u) {
            $data_admin = array();
            $data_admin['name'] = $u->name;
            $data_admin['user_name'] = $data['name'];

            Mail::to($u['email'])->send(new RegisterMail($data_admin));
        }

        return $user;
    }
} 
