<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Softdeletes;

class User extends Authenticatable
{
    use Notifiable, Softdeletes;

    protected static $whiteListExperience = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'super_user', 'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the role records associated with the user.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_roles')->withTimestamps();
    }

    /**
     * Get the exeperience records associated with the user.
     */
    public function experiences()
    {
      return $this->hasMany('App\Experience');
    }

    /**
     * Get the immediate supervisor record associated with the user.
     */
    public function immediateSupervisor()
    {
        return $this->belongsTo('App\User', 'immediate_supervisor_id');
    }

    /**
     * Get the subordinates record associated with the user.
     */
    public function subordinates()
    {
        return $this->hasMany('App\User', 'immediate_supervisor_id');
    }

    /**
     * Get the tasks record associated with the user.
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    /**
     * Get the department record associated with the user.
     */
    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    /**
     * Get the department record associated with the user.
     */
    public function shift_schedule()
    {
        return $this->hasOne('App\ShiftSchedule');
    }

    /**
     * Determines the authenticated user is a super user.
     */
    public function isSuperUser()
    {
        return $this->super_user ? true : false;
    }

    public function isDepartmentHead()
    {
        $this->load(['roles' => function($query){
            $query->where('name', 'Department Head');
        }]);

        return count($this->roles) ? true : false;
    }

    public function prepare()
    {
      $this->name = request()->name;
      $this->employee_number = request()->employee_number;
      $this->email = request()->email;
      $this->password = $this->id ? $this->password : bcrypt('!welcome10');
      $this->department_id = $this->id ? $this->department_id : request()->user()->department_id;
      $this->immediate_supervisor_id = $this->id ? $this->immediate_supervisor_id : request()->user()->id;
    }

    public function checkDuplicate()
    {
      $user = User::query();

      if(request()->has('id')) {
        $user->whereNotIn('id', [request()->id]);
      }

      $duplicate = $user->withTrashed()->where(function($query){
        $query->where('employee_number', request()->employee_number);
        $query->orWhere('email', request()->email);
      })->first();

      if($duplicate) {
        abort(403, 'Duplicate entry.');
      }
    }

    public function prepareExperiences()
    {
      $experiences = [];

      for ($i=0; $i < count(request()->experiences); $i++) {
        $hasRecord = request()->has("experiences.{$i}.id") ? true : false;

        $experience = $hasRecord ? Experience::find(request()->input("experiences.{$i}.id")) : new Experience;
        $experience->validateRequest($i);
        $experience->prepare($i);

        if(! $hasRecord) {
          array_push($experiences, $experience);
        }
        else {
          $experience->user_id = $this->id;
          $experience->save();
        }

        array_push(static::$whiteListExperience, $experience->id);
      }

      return $experiences;
    }

    public function deleteExperiences()
    {
      Experience::whereNotIn('id', static::$whiteListExperience)->where('user_id', $this->id)->doesntHave('tasks')->delete();
    }
}
