<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		 'date', 'type', 'title', 'note', 'user_id', 'created_by'
	];

	public function users()
    {
        return $this->belongsTo('App\user','created_by');
    }

    public function substitute()
    {
        return $this->belongsTo('App\user','user_id');
    }

}
