<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShiftSchedule extends Model
{
	/**
     * Get the user record associated with the shift schedule.
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
