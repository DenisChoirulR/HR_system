<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class attendance extends Model
{

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'date', 'user_id', 'check_in', 'check_out', 
    ];

    public function users()
    {
        return $this->belongsTo('App\user','user_id');
    }
} 
