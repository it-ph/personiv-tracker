<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
	/**
     * Get the department record associated with the account.
     */
	public function department()
	{
		return $this->belongsTo('App\Department');
	}

    /**
     * Get the task records associated with the account.
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}
