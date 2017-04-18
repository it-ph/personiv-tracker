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
}
