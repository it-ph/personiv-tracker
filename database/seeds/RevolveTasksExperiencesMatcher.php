<?php

use Illuminate\Database\Seeder;

use App\Task;
use App\Account;
use App\Department;
use App\User;

class RevolveTasksExperiencesMatcher extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
          $revolve = Account::where('name', 'Revolve')->first();

          $users = User::with('experiences')->whereHas('experiences', function($query) use($revolve){
            $query->where('account_id', $revolve->id);
          })->get();

          $tasks = Task::with('user.experiences')->whereIn('user_id', $users->pluck('id'))->where('account_id', $revolve->id)->get();

          $tasks->each(function($task){
            $task->experience_id = $task->user->experiences->first()->id;
            $task->save();
          });
        });
    }
}
