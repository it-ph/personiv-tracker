<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * Get the user records associated with the account.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
