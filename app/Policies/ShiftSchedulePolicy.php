<?php

namespace App\Policies;

use App\User;
use App\ShiftSchedule;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShiftSchedulePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperUser()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the shiftSchedule.
     *
     * @param  \App\User  $user
     * @param  \App\ShiftSchedule  $shiftSchedule
     * @return mixed
     */
    public function view(User $user, ShiftSchedule $shiftSchedule)
    {
        //
    }

    /**
     * Determine whether the user can create shiftSchedules.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $user->load(['roles' => function($query){
            $query->where('name', 'Settings');
        }]);

        echo $user;

        return count($user->roles) ? true : false;
    }

    /**
     * Determine whether the user can update the shiftSchedule.
     *
     * @param  \App\User  $user
     * @param  \App\ShiftSchedule  $shiftSchedule
     * @return mixed
     */
    public function update(User $user, ShiftSchedule $shiftSchedule)
    {
        return $user->id === $shiftSchedule->user_id;
    }

    /**
     * Determine whether the user can delete the shiftSchedule.
     *
     * @param  \App\User  $user
     * @param  \App\ShiftSchedule  $shiftSchedule
     * @return mixed
     */
    public function delete(User $user, ShiftSchedule $shiftSchedule)
    {
        //
    }
}
