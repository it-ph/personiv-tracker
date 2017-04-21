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
}
