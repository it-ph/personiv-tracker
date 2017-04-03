<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['ended_at' ,'deleted_at'];

    /**
     * Get the user record associated with the task.
     */
    public function user()
    {
    	return $this->belongsTo('App\Task');
    }
}
