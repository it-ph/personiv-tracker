<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Carbon\Carbon;

class Experience extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date_started'];
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

    public function validateRequest($i)
    {
      Validator::make(request()->all(), [
        "experiences.{$i}.id" => 'required',
        "experiences.{$i}.date_started" => 'required',
      ])->validate();
    }

    public function prepare($i)
    {
      $this->user_id = request()->id;
      $this->position_id = request()->input("{$i}.position_id");
      $this->date_started = Carbon::parse(request()->input("{$i}.date_started"));
    }
}
