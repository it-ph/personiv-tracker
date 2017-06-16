<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'batchable' => 'boolean',
    ];

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

    /**
     * Get the experience records associated with the account.
     */
    public function experiences()
    {
        return $this->hasMany('App\Experience');
    }

    /**
     * Get the position records associated with the account.
     */
    public function positions()
    {
    	return $this->belongsToMany('App\Position', 'account_positions');
    }

    public function checkDuplicate()
    {
      $account = Account::query();

      $account->where('name', request()->name);

      if(request()->has('department_id'))
      {
        $account->where('department_id', request()->department_id);
      }
      else
      {
        $account->where('department_id', request()->user()->department_id);
      }

      if(request()->has('id'))
      {
        $account->whereNotIn('id', [request()->id]);
      }

      $duplicate = $account->first();

      if($duplicate)
      {
        abort(403, 'Duplicate entry.');
      }
    }

    public function prepare()
    {
      $this->name = request()->name;
      $this->batchable = request()->batchable;
      $this->department_id = request()->has('department_id') ? request()->department_id : request()->user()->department_id;
    }
}
