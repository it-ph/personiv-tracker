<?php

namespace App\Policies;

use App\User;
use App\Position;
use Illuminate\Auth\Access\HandlesAuthorization;

class PositionPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperUser()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the position.
     *
     * @param  \App\User  $user
     * @param  \App\Position  $position
     * @return mixed
     */
    public function view(User $user, Position $position)
    {
        //
    }

    /**
     * Determine whether the user can create positions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      $user->load(['roles' => function($query){
          $query->where('name', 'Settings');
      }]);

      return count($user->roles) ? true : false;
    }

    /**
     * Determine whether the user can update the position.
     *
     * @param  \App\User  $user
     * @param  \App\Position  $position
     * @return mixed
     */
    public function update(User $user, Position $position)
    {
      $position->load(['accounts' => function($query){
          $query->where('account_id', request()->account_id);
      }]);

      return count($position->accounts) && $position->accounts->first()->department_id === $user->department_id ? true : false;
    }

    /**
     * Determine whether the user can delete the position.
     *
     * @param  \App\User  $user
     * @param  \App\Position  $position
     * @return mixed
     */
    public function delete(User $user, Position $position)
    {
      //
    }

    /**
     * Determine whether the user can detach the position.
     *
     * @param  \App\User  $user
     * @param  \App\Position  $position
     * @return mixed
     */
    public function detach(User $user, Position $position)
    {
      $position->load(['accounts' => function($query){
          $query->where('account_id', request()->account_id);
      }]);

      return count($position->accounts) && $position->accounts->first()->department_id === $user->department_id ? true : false;
    }
}
