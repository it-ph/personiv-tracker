<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
     * Get the user records associated with the department.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Get the account records associated with the department.
     */
    public function accounts()
    {
    	return $this->hasMany('App\Account');
    }

    /**
     * Get the position records associated with the department.
     */
    public function positions()
    {
    	return $this->belongsToMany('App\Position', 'department_positions');
    }
}
