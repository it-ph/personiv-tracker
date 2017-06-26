<?php

use Illuminate\Database\Seeder;
use App\Account;
use App\AccountPosition;
use App\Department;
use App\Experience;
use App\Task;
use App\Position;

class MergefDOSpec extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
            $fDOSpecIncolumn = Account::where('name', 'fDO Spec Incolumn')->first();
            $fDOSpecDisplay = Account::where('name', 'fDO Spec Display')->first();

            $artist = Position::where('name', 'Artist')->first();
            $proofer = Position::where('name', 'Proofer')->first();
            $sme = Position::where('name', 'SME')->first();

            // Create fDO Spec account
            $fDOSpec = Account::create([
                'name' => 'fDO Spec',
                'batchable' => false,
                'department_id' => Department::where('name', 'DexMedia AP')->first()->id                     
            ]);

            // Attach positions to fDO Spec account
            $fDOSpec->positions()->attach([
                $artist->id,
                $proofer->id,
                $sme->id,
            ]);

            // Migrate fDO Spec Incolumn experiences to fDO Spec
            $fDOSpecIncolumnExperiences = Experience::where('account_id', $fDOSpecIncolumn->id)->get();
            $fDOSpecIncolumnExperiences->each(function($experience) use($fDOSpec){
                Experience::updateOrCreate([
                    'user_id' => $experience->user_id,
                    'position_id' => $experience->position_id,
                    'account_id' => $fDOSpec->id,
                    'date_started' => $experience->date_started,
                ]);
            });
            
            // Migrate fDO Spec Display experiences to fDO Spec
            $fDOSpecDisplayExperiences = Experience::where('account_id', $fDOSpecDisplay->id)->get();
            $fDOSpecDisplayExperiences->each(function($experience) use($fDOSpec){
                Experience::updateOrCreate([
                    'user_id' => $experience->user_id,
                    'position_id' => $experience->position_id,
                    'account_id' => $fDOSpec->id,
                    'date_started' => $experience->date_started,
                ]);
            });

            // Migrate fDO Spec Incolumn tasks to fDO Spec
            $fDOSpecIncolumnTasks = Task::with('experience')->where('account_id', $fDOSpecIncolumn->id)->get();
            $fDOSpecIncolumnTasks->each(function($task) use($fDOSpec){
                if(isset($task->experience))
                {
                    $task->account_id = $fDOSpec->id;
                    $task->experience_id = Experience::where('user_id', $task->user_id)->where('position_id', $task->experience->position_id)->where('account_id', $fDOSpec->id)->first()->id;
                    $task->save();
                }
            });
            
            // Migrate fDO Spec Display tasks to fDO Spec
            $fDOSpecDisplayTasks = Task::with('experience')->where('account_id', $fDOSpecDisplay->id)->get();
            $fDOSpecDisplayTasks->each(function($task) use($fDOSpec){
                if(isset($task->experience))
                {
                    $task->account_id = $fDOSpec->id;
                    $task->experience_id = Experience::where('user_id', $task->user_id)->where('position_id', $task->experience->position_id)->where('account_id', $fDOSpec->id)->first()->id;
                    $task->save();
                }
            });

            // Delete fDO Spec Display and fDO Spec Incolumn experiences
            Experience::where('account_id', $fDOSpecDisplay->id)->delete();
            Experience::where('account_id', $fDOSpecIncolumn->id)->delete();
            // Delete pivot data for fDO Spec Display and fDO Spec Incolumn positions
            AccountPosition::where('account_id', $fDOSpecDisplay->id)->delete();
            AccountPosition::where('account_id', $fDOSpecIncolumn->id)->delete();
            // Delete fDO Spec Display and fDO Spec Incolumn accounts
            $fDOSpecDisplay->delete();
            $fDOSpecIncolumn->delete();
        });
    }
}
