<?php

use Illuminate\Database\Seeder;
use App\Task;
use App\Experience;

class TaskExperienceMatcher extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
          $deletedExperiences = Experience::onlyTrashed()->with('tasks');

          $deletedExperiences->each(function($experience){
            $experience->tasks->each(function($task) use($experience){
              $task->experience_id = Experience::where('user_id', $experience->user_id)->where('account_id', $experience->account_id)->where('position_id', $experience->position_id)->first()->id;
              $task->save();
            });
          });
        });
    }
}
