<?php

use Illuminate\Database\Seeder;
use App\Account;
use App\AccountPosition;
use App\Department;
use App\Experience;
use App\Task;
use App\Position;

class MergeAllisonLamar extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
            $allison = Account::where('name', 'Allison')->first();
            $lamar = Account::where('name', 'Lamar')->first();
            
            $artist = Position::where('name', 'Artist')->first();
            $proofer = Position::where('name', 'Proofer')->first();
            $quality_auditor = Position::where('name', 'Quality Auditor')->first();
            $design_proofer = Position::where('name', 'Design Proofer')->first();

            // Create Allison/Lamar account
            $allisonLamar = Account::create([
                'name' => 'Allison/Lamar',
                'batchable' => false,
                'department_id' => Department::where('name', 'OOH')->first()->id                     
            ]);

            // Attach positions to Allison/Lamar account
            $allisonLamar->positions()->attach([
                $artist->id,
                $proofer->id,
                $quality_auditor->id,
                $design_proofer->id
            ]);

            // Migrate Allison experiences to Allison/Lamar
            $allisonExperiences = Experience::where('account_id', $allison->id)->get();
            $allisonExperiences->each(function($experience) use($allisonLamar){
                Experience::updateOrCreate([
                    'user_id' => $experience->user_id,
                    'position_id' => $experience->position_id,
                    'account_id' => $allisonLamar->id,
                    'date_started' => $experience->date_started,
                ]);
            });
            
            // Migrate Lamar experiences to Allison/Lamar
            $lamarExperiences = Experience::where('account_id', $lamar->id)->get();
            $lamarExperiences->each(function($experience) use($allisonLamar) {
                Experience::updateOrCreate([
                    'user_id' => $experience->user_id,
                    'position_id' => $experience->position_id,
                    'account_id' => $allisonLamar->id,
                    'date_started' => $experience->date_started,
                ]);
            });

            // Migrate Allison tasks to Allison/Lamar
            $allisonTasks = Task::with('experience')->where('account_id', $allison->id)->get();
            $allisonTasks->each(function($task) use($allisonLamar){
                $task->account_id = $allisonLamar->id;
                $task->experience_id = Experience::where('user_id', $task->user_id)->where('position_id', $task->experience->position_id)->where('account_id', $allisonLamar->id)->first()->id;
                $task->save();
            });

            // Migrate Lamar tasks to Allison/Lamar
            $allisonTasks = Task::with('experience')->where('account_id', $lamar->id)->get();
            $allisonTasks->each(function($task) use($allisonLamar){
                $task->account_id = $allisonLamar->id;
                $task->experience_id = Experience::where('user_id', $task->user_id)->where('position_id', $task->experience->position_id)->where('account_id', $allisonLamar->id)->first()->id;
                $task->save();
            });

            // Delete allison and lamar experiences
            Experience::where('account_id', $allison->id)->delete();
            Experience::where('account_id', $lamar->id)->delete();
            // Delete pivot data for allison and lamar positions
            AccountPosition::where('account_id', $allison->id)->delete();
            AccountPosition::where('account_id', $lamar->id)->delete();
            // Delete allison and lamar accounts
            $allison->delete();
            $lamar->delete();
        });
    }
}
