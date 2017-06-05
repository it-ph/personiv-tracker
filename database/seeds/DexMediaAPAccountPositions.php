<?php

use Illuminate\Database\Seeder;
use App\Account;
use App\Position;
use App\AccountPosition;

class DexMediaAPAccountPositions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::transaction(function(){
        $accounts = Account::with('positions')->where('department_id', 1)->get();
        $artist = Position::where('name', 'Artist')->firstOrFail()->id;
        $proofer = Position::where('name', 'Proofer')->firstOrFail()->id;
        $sme = Position::where('name', 'SME')->firstOrFail()->id;

        $accounts->each(function($account) use($artist, $proofer, $sme){
          // artist
          AccountPosition::firstOrCreate([
            'account_id' => $account->id,
            'position_id' => $artist,
          ]);
          // proofer
          AccountPosition::firstOrCreate([
            'account_id' => $account->id,
            'position_id' => $proofer,
          ]);
          // sme
          AccountPosition::firstOrCreate([
            'account_id' => $account->id,
            'position_id' => $sme,
          ]);
        });
      });
    }
}
