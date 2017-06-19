<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
   protected $fillable = ['name'];

  /**
   * Get the account records associated with the position.
   */
  public function accounts()
  {
    return $this->belongsToMany('App\Account', 'account_positions');
  }

  /**
   * Get the experience records associated with the position.
   */
  public function experiences()
  {
    return $this->hasMany('App\Experience');
  }

  public function checkDuplicate()
  {
    $position = Position::query();

    $position->where('name', request()->name)->whereHas('accounts', function($query){
      $query->where('account_id', request()->account_id);
    });

    if(request()->has('id'))
    {
      $position->whereNotIn('id', [request()->id]);
    }

    $duplicate = $position->first();

    if($duplicate){
      abort(403, 'Duplicate entry.');
    }
  }

  public function checkExistence()
  {
    return Position::updateOrCreate([
      'name' => request()->name,
    ]);
  }

  public function detachOldAccount()
  {
    $this->accounts()->detach([request()->account_id]);
  }

  public function syncAccount()
  {
    $this->accounts()->syncWithoutDetaching([request()->account_id]);
  }
}
