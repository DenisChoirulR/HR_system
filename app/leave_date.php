<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave_date extends Model
{
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		 'leave_id', 'requested_date'
	];

	public function leaves()
    {
        return $this->belongsTo('App\leave','leave_id');
    }
}
