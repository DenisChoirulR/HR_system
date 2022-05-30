<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		 'user_id', 'leave_type_id', 'status', 'cancelled_at', 'substitute_user_id', 'leave_note', 'work_note', 'accepted_at', 'accepted_by', 'rejected_at', 'rejected_by', 'approved_at', 'approved_by'
	];

	public function leave_types()
    {
        return $this->belongsTo('App\leave_type','leave_type_id');
    }

    public function users()
    {
        return $this->belongsTo('App\user','user_id');
    }

    public function substitute()
    {
        return $this->belongsTo('App\user','substitute_user_id');
    }

	public function leave_dates()
    {
        return $this->hasMany('App\leave_date','leave_id');
    }    

}
