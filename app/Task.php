<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
     * Get the user record associated with the task.
     */
    public function user()
    {
    	return $this->belongsTo('App\Task');
    }
}
