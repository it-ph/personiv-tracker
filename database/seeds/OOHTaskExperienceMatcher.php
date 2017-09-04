<?php

use Illuminate\Database\Seeder;
use App\Account;
use App\Department;
use App\Experience;
use App\Task;
use App\User;

class OOHTaskExperienceMatcher extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::transaction(function(){
        $department = Department::where('name', 'OOH')->first();
        $accounts = Account::with('positions')->where('department_id', $department->id)->get();

        $accounts->each(function($account){
          $account->positions->each(function($position) use($account){
            $users = User::with('experiences')->whereHas('experiences', function($query) use($account, $position){
              $query->where('account_id', $account->id)->where('position_id', $position->id);
            })->get();

            $tasks = Task::with('user.experiences')->whereIn('user_id', $users->pluck('id'))->where('account_id', $account->id)->get();

            $tasks->each(function($task) use($position){
              if($experience = $task->user->experiences->where('position_id', $position->id)->first())
              {
                $task->experience_id = $experience->id;
                $task->save();
              }
            });
          });
        });
      });
    }
}
