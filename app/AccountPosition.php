<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountPosition extends Model
{
  use SoftDeletes;

  /**
   * The attributes casted as date.
   *
   * @var array
   */
   protected $dates = ['deleted_at'];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
   protected $guarded = [];
}
