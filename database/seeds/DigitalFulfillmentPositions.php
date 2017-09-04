<?php

use Illuminate\Database\Seeder;
use App\Account;
use App\Position;
use App\User;

class DigitalFulfillmentPositions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::transaction(function(){
        // create
        Position::create([
          'name' => 'Web Designer',
        ]);

        Position::create([
          'name' => 'URL Migration and Expiring Domain',
        ]);

        Position::create([
          'name' => 'Web QC',
        ]);

        Position::create([
          'name' => 'VAR Agents',
        ]);

        Position::create([
          'name' => 'Proofreader',
        ]);

        // update positions
        $logoDesigner = Position::where('name', 'Designer')->first();
        $logoDesigner->name = 'Logo Designer';
        $logoDesigner->save();

        $smrAgents = Position::where('name', 'CSR')->first();
        $smrAgents->name = 'SMR Agents';
        $smrAgents->save();
      });
    }
}
