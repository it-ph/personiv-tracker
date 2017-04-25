<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pause extends Model
{
	/**
     * Get the task record associated with the pause.
     */
    public function task()
    {
    	return $this->belongsTo('App\Task');
    }

    /**
     * Insert the ended_at and minutes spent of the pause record.
     */
    public function resume()
    {
    	$this->ended_at = Carbon::now();
        
        $this->minutes_spent = round(Carbon::parse($this->created_at)->diffInSeconds(Carbon::parse($this->ended_at)) / 60, 2);

        $this->save();
    }
}
