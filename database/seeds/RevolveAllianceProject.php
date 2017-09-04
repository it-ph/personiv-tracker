<?php

use Illuminate\Database\Seeder;
use App\Account;
use App\Department;
use App\Experience;
use App\Position;
use App\User;

class RevolveAllianceProject extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
          $revolveDepartment = Department::where('name', 'Revolve')->firstOrFail();
          $revolveAccount = Account::where('name', 'Revolve')->firstOrFail();
          $editor = Position::where('name', 'Editor')->first();
          $qc = Position::where('name', 'QC')->first();

          $alliance = new Account;

          $alliance->name = 'Alliance';
          $alliance->department_id = $revolveDepartment->id;
          $alliance->batchable = true;

          $alliance->save();

          $alliance->positions()->attach($editor);
          $alliance->positions()->attach($qc);

          $users = User::whereHas('experiences', function($query) use($revolveAccount){
            $query->where('account_id', $revolveAccount->id);
          })->with(['experiences' => function($query) use($revolveAccount){
            $query->where('account_id', $revolveAccount->id);
          }]);

          $users->each(function($user) use($alliance){
            Experience::create([
              'user_id' => $user->id,
              'position_id' => $user->experiences->first()->position_id,
              'date_started' => $user->experiences->first()->date_started,
              'account_id' => $alliance->id,
            ]);
          });
        });
    }
}
