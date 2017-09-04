<?php

use Illuminate\Database\Seeder;
use App\Task;
use App\Account;
use App\Experience;

class RevolveAllianceTasks extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
          $revolve = Account::where('name', 'Revolve')->firstOrFail();
          $alliance = Account::where('name', 'Alliance')->firstOrFail();

          $tasks = Task::where('account_id', $revolve->id)->where('title', 'like', '%alliance%')->get();

          $tasks->each(function($task) use($alliance){
            $task->account_id = $alliance->id;
            $task->experience_id = Experience::where('user_id', $task->user_id)->where('account_id', $alliance->id)->first()->id;
            $task->save();
          });
        });
    }
}
