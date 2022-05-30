<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title', 'note', 'user_id', 'expired_at'
	];

	public function users()
    {
        return $this->belongsTo('App\user','user_id');
    }
}
