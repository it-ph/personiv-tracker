<?php

use Illuminate\Database\Seeder;
use App\Account;
use App\AccountPosition;
use App\Department;
use App\Experience;
use App\Task;
use App\Position;

class MergefDOSold extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
            $fDOSoldIncolumn = Account::where('name', 'fDO Sold Incolumn')->first();
            $fDOSoldDisplay = Account::where('name', 'fDO Sold Display')->first();

            $artist = Position::where('name', 'Artist')->first();
            $proofer = Position::where('name', 'Proofer')->first();
            $sme = Position::where('name', 'SME')->first();

            // Create fDO Sold account
            $fDOSold = Account::create([
                'name' => 'fDO Sold',
                'batchable' => false,
                'department_id' => Department::where('name', 'DexMedia AP')->first()->id                     
            ]);

            // Attach positions to fDO Sold account
            $fDOSold->positions()->attach([
                $artist->id,
                $proofer->id,
                $sme->id,
            ]);

            // Migrate fDO Sold Incolumn experiences to fDO Sold
            $fDOSoldIncolumnExperiences = Experience::where('account_id', $fDOSoldIncolumn->id)->get();
            $fDOSoldIncolumnExperiences->each(function($experience) use($fDOSold){
                Experience::updateOrCreate([
                    'user_id' => $experience->user_id,
                    'position_id' => $experience->position_id,
                    'account_id' => $fDOSold->id,
                    'date_started' => $experience->date_started,
                ]);
            });
            
            // Migrate fDO Sold Display experiences to fDO Sold
            $fDOSoldDisplayExperiences = Experience::where('account_id', $fDOSoldDisplay->id)->get();
            $fDOSoldDisplayExperiences->each(function($experience) use($fDOSold){
                Experience::updateOrCreate([
                    'user_id' => $experience->user_id,
                    'position_id' => $experience->position_id,
                    'account_id' => $fDOSold->id,
                    'date_started' => $experience->date_started,
                ]);
            });

            // Migrate fDO Sold Incolumn tasks to fDO Sold
            $fDOSoldIncolumnTasks = Task::with('experience')->where('account_id', $fDOSoldIncolumn->id)->get();
            $fDOSoldIncolumnTasks->each(function($task) use($fDOSold){
                if(isset($task->experience))
                {
                    $task->account_id = $fDOSold->id;
                    $task->experience_id = Experience::where('user_id', $task->user_id)->where('position_id', $task->experience->position_id)->where('account_id', $fDOSold->id)->first()->id;
                    $task->save();
                }
            });
            
            // Migrate fDO Sold Display tasks to fDO Sold
            $fDOSoldDisplayTasks = Task::with('experience')->where('account_id', $fDOSoldDisplay->id)->get();
            $fDOSoldDisplayTasks->each(function($task) use($fDOSold){
                if(isset($task->experience))
                {
                    $task->account_id = $fDOSold->id;
                    $task->experience_id = Experience::where('user_id', $task->user_id)->where('position_id', $task->experience->position_id)->where('account_id', $fDOSold->id)->first()->id;
                    $task->save();
                }
            });

            // Delete fDO Sold Display and fDO Sold Incolumn experiences
            Experience::where('account_id', $fDOSoldDisplay->id)->delete();
            Experience::where('account_id', $fDOSoldIncolumn->id)->delete();
            // Delete pivot data for fDO Sold Display and fDO Sold Incolumn positions
            AccountPosition::where('account_id', $fDOSoldDisplay->id)->delete();
            AccountPosition::where('account_id', $fDOSoldIncolumn->id)->delete();
            // Delete fDO Sold Display and fDO Sold Incolumn accounts
            $fDOSoldDisplay->delete();
            $fDOSoldIncolumn->delete();
        });
    }
}
