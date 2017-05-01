<?php

use Illuminate\Database\Seeder;

use App\Department;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ooh = Department::where('name', 'OOH')->first()->id;
        $dexMediaAP = Department::where('name', 'DexMedia AP')->first()->id;
        $digitalFulfillment = Department::where('name', 'Digital Fulfillment')->first()->id;

        DB::table('accounts')->insert([
            [
        		'name' => 'Allison',
        		'department_id' => $ooh,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
            [
                'name' => 'Lamar',
                'department_id' => $ooh,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
        	// [
        	// 	'name' => 'fDO Sold',
        	// 	'department_id' => $dexMediaAP,
        	// 	'created_at' => Carbon\Carbon::now(),
        	// 	'updated_at' => Carbon\Carbon::now(),
        	// ],
         //    [
         //        'name' => 'fDO Spec',
         //        'department_id' => $dexMediaAP,
         //        'created_at' => Carbon\Carbon::now(),
         //        'updated_at' => Carbon\Carbon::now(),
         //    ],
            [
                'name' => 'fDO Sold Incolumn',
                'department_id' => $dexMediaAP,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'fDO Sold Display',
                'department_id' => $dexMediaAP,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'fDO Spec Incolumn',
                'department_id' => $dexMediaAP,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'fDO Spec Display',
                'department_id' => $dexMediaAP,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'fDO Awareness',
                'department_id' => $dexMediaAP,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'fSM Display Spec',
                'department_id' => $dexMediaAP,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'fSM Incolumn Spec',
                'department_id' => $dexMediaAP,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'fSM Display Sold',
                'department_id' => $dexMediaAP,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'fSM Incolumn Sold',
                'department_id' => $dexMediaAP,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'fSM AWARENESS',
                'department_id' => $dexMediaAP,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'VAR',
                'department_id' => $dexMediaAP,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'BAU',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Pre-Launch Mods',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Post-Launch Mods',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Scheduling',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Boosting',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Setup',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Ordering',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'URL Migration',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Expiring Domain',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Web Admin',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Legacy Revision',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Logistic Executives',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Logo Design',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Web QC',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'VAR1',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'VAR2',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'VAR3',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Proofreading',
                'department_id' => $digitalFulfillment,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],

            // [
            //     'name' => 'New Sites',
            //     'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
            //     'created_at' => Carbon\Carbon::now(),
            //     'updated_at' => Carbon\Carbon::now(),
            // ],
            // [
            //     'name' => 'Modifications',
            //     'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
            //     'created_at' => Carbon\Carbon::now(),
            //     'updated_at' => Carbon\Carbon::now(),
            // ],
            // [
            //     'name' => 'Legacy (New)',
            //     'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
            //     'created_at' => Carbon\Carbon::now(),
            //     'updated_at' => Carbon\Carbon::now(),
            // ],
            // [
            //     'name' => 'SMR- Scheduling',
            //     'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
            //     'created_at' => Carbon\Carbon::now(),
            //     'updated_at' => Carbon\Carbon::now(),
            // ],
            // [
            //     'name' => 'SMR- Tips Ordering',
            //     'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
            //     'created_at' => Carbon\Carbon::now(),
            //     'updated_at' => Carbon\Carbon::now(),
            // ],
            // [
            //     'name' => 'Expiring Domains- Closing',
            //     'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
            //     'created_at' => Carbon\Carbon::now(),
            //     'updated_at' => Carbon\Carbon::now(),
            // ],
            // [
            //     'name' => 'Expiring Domains- Migration Cases',
            //     'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
            //     'created_at' => Carbon\Carbon::now(),
            //     'updated_at' => Carbon\Carbon::now(),
            // ],
            // [
            //     'name' => 'Expiring Domains- V1/V2',
            //     'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
            //     'created_at' => Carbon\Carbon::now(),
            //     'updated_at' => Carbon\Carbon::now(),
            // ],
            // [
            //     'name' => 'Expiring Domains- V3',
            //     'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
            //     'created_at' => Carbon\Carbon::now(),
            //     'updated_at' => Carbon\Carbon::now(),
            // ],
            // [
            //     'name' => 'Web Admin- Assigning',
            //     'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
            //     'created_at' => Carbon\Carbon::now(),
            //     'updated_at' => Carbon\Carbon::now(),
            // ],
            // [
            //     'name' => 'Web Admin- Scheduling',
            //     'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
            //     'created_at' => Carbon\Carbon::now(),
            //     'updated_at' => Carbon\Carbon::now(),
            // ],


        ]);
    }
}
