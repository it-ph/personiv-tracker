<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class ShiftSchedule extends Model
{
	/**
     * Get the user record associated with the shift schedule.
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function populate($request)
    {
        $this->from = Carbon::parse($request->from)->toTimeString();
        $this->to = Carbon::parse($request->to)->toTimeString();
    }
}
