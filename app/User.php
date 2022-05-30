<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		 'name', 'email', 'password', 'gender', 'birth_date', 'phone', 'religion' , 'job_title' , 'employee_type' , 'placement_location' , 'start_date' , 'address' , 'marital_status' , 'identity_card_no' , 'access_type',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

 // public function events()
 //    {
 //        return $this->hasMany('App\event','id','create_by');
 //    }
}
