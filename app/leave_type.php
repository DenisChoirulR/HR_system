<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave_type extends Model
{
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		 'code', 'name', 'max_available', 'policy_note'
	];

	public function leaves()
    {
        return $this->hasMany('App\leave','leave_type_id');
    }
}
