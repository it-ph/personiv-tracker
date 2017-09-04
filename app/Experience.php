<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Validator;
use Carbon\Carbon;

class Experience extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date_started', 'deleted_at'];
    /**
     * Get the user record associated with the experience.
     */
    public function user()
    {
      return $this->belongsTo('App\User');
    }

    /**
    * Get the position record associated with the experience.
    */
    public function position()
    {
      return $this->belongsTo('App\Position');
    }

    /**
    * Get the account record associated with the experience.
    */
    public function account()
    {
      return $this->belongsTo('App\Account');
    }

    /**
    * Get the tasks record associated with the experience.
    */
    public function tasks()
    {
      return $this->hasMany('App\Task');
    }

    public function validateRequest($i)
    {
      Validator::make(request()->all(), [
        "experiences.{$i}.account_id" => 'required',
        "experiences.{$i}.position_id" => 'required',
        "experiences.{$i}.date_started" => 'required',
      ])->validate();
    }

    public function prepare($i)
    {
      $this->account_id = request()->input("experiences.{$i}.account_id");
      $this->position_id = request()->input("experiences.{$i}.position_id");
      $this->date_started = Carbon::parse(request()->input("experiences.{$i}.date_started"));
    }
}
