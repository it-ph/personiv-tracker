<?php

namespace App\Policies;

use App\User;
use App\Experience;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExperiencePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperUser()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the experience.
     *
     * @param  \App\User  $user
     * @param  \App\Experience  $experience
     * @return mixed
     */
    public function view(User $user, Experience $experience)
    {
        //
    }

    /**
     * Determine whether the user can create experiences.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
      $user->load(['roles' => function($query){
          $query->where('name', 'Supervisor');
      }]);

      return count($user->roles) ? true : false;
    }

    /**
     * Determine whether the user can update the experience.
     *
     * @param  \App\User  $user
     * @param  \App\Experience  $experience
     * @return mixed
     */
    public function update(User $user, Experience $experience)
    {
        $subordinate = User::find($experience->user_id);

        return $user->id === $subordinate->immediate_supervisor_id;
    }

    /**
     * Determine whether the user can delete the experience.
     *
     * @param  \App\User  $user
     * @param  \App\Experience  $experience
     * @return mixed
     */
    public function delete(User $user, Experience $experience)
    {
      $subordinate = User::find($experience->user_id);

      return $user->id === $subordinate->immediate_supervisor_id;
    }
}
