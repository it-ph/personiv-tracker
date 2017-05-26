<?php

use Illuminate\Database\Seeder;
use App\Department;
use App\Position;

class DepartmentPositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
          $ooh = Department::where('name', 'OOH')->first()->id;
          $dexmediaAP = Department::where('name', 'DexMedia AP')->first()->id;
          $digitalFulfillment = Department::where('name', 'Digital Fulfillment')->first()->id;
          $revolve = Department::where('name', 'Revolve')->first()->id;

          $artist = Position::where('name', 'Artist')->first()->id;
          $proofer = Position::where('name', 'Proofer')->first()->id;
          $sme = Position::where('name', 'SME')->first()->id;
          $qualityAuditor = Position::where('name', 'Quality Auditor')->first()->id;
          $designProofer = Position::where('name', 'Design Proofer')->first()->id;
          $qc = Position::where('name', 'QC')->first()->id;
          $csr = Position::where('name', 'CSR')->first()->id;
          $webAdmin = Position::where('name', 'Web Admin')->first()->id;
          $designer = Position::where('name', 'Designer')->first()->id;
          $editor = Position::where('name', 'Editor')->first()->id;

          DB::table('department_positions')->insert([
            // DexMedia AP
            [
              'department_id' => $dexmediaAP,
              'position_id' => $artist
            ],
            [
              'department_id' => $dexmediaAP,
              'position_id' => $proofer,
            ],
            [
              'department_id' => $dexmediaAP,
              'position_id' => $sme,
            ],
            // OOH
            [
              'department_id' => $ooh,
              'position_id' => $artist,
            ],
            [
              'department_id' => $ooh,
              'position_id' => $proofer,
            ],
            [
              'department_id' => $ooh,
              'position_id' => $qualityAuditor,
            ],
            [
              'department_id' => $ooh,
              'position_id' => $designProofer,
            ],
            // Digital Fulfillment
            [
              'department_id' => $digitalFulfillment,
              'position_id' => $artist,
            ],
            [
              'department_id' => $digitalFulfillment,
              'position_id' => $proofer,
            ],
            [
              'department_id' => $digitalFulfillment,
              'position_id' => $qc,
            ],
            [
              'department_id' => $digitalFulfillment,
              'position_id' => $csr,
            ],
            [
              'department_id' => $digitalFulfillment,
              'position_id' => $webAdmin,
            ],
            [
              'department_id' => $digitalFulfillment,
              'position_id' => $designer,
            ],
            // Revolve
            [
              'department_id' => $revolve,
              'position_id' => $editor,
            ],
            [
              'department_id' => $revolve,
              'position_id' => $qc,
            ],
          ]);
        });
    }
}
