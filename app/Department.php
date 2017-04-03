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
}
