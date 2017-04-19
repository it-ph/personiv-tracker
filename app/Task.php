<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Task extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['ended_at'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['ended_at'];  

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'revision' => 'boolean',
    ];

    /**
     * Get the user record associated with the task.
     */
    public function user()
    {
    	return $this->belongsTo('App\Task');
    }

    /**
     * Get the account record associated with the task.
     */
    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    /**
     * Get the pause records associated with the task.
     */
    public function pauses()
    {
        return $this->hasMany('App\Pause');
    }

    /**
     * Fill the task properties with user request.
     */
    public function populate($request)
    {
        $this->title = $request->title;
        $this->account_id = $request->account_id;
        $this->revision = $request->revision;
        $this->number_of_photos = $request->number_of_photos;
    }

    /**
     * Get pause records associated with the task where paused is unfinished.
     */
    public function loadUnfinishedPauses()
    {
        $this->load(['pauses' => function($query){
            $query->whereNull('ended_at')->orderBy('created_at', 'desc');
        }]);
    }

    /**
     * Calculate the overall time and subtract the idle time.
     */
    public function timeSpent()
    {
        $this->minutesIdle();
        $this->minutesSpent();
    }

    protected function minutesIdle()
    {
        // load all the pauses record of the task
        $this->load('pauses');

        $this->minutes_idle = 0;

        foreach ($this->pauses as $pause) {
            $this->minutes_idle += $pause->minutes_spent; 
        }
    }

    protected function minutesSpent()
    {
        // Difference in minutes of the time task created and end time.
        $overall = round(Carbon::parse($this->created_at)->diffInSeconds(Carbon::parse($this->ended_at)) / 60, 2);

        $this->minutes_spent = $overall - $this->minutes_idle;
    }
}
