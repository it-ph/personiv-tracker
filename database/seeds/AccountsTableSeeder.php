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
        DB::table('accounts')->insert([
        	[
        		'name' => 'Lamar-Allison',
        		'department_id' => Department::where('name', 'OOH')->first()->id,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        	[
        		'name' => 'fDO Sold',
        		'department_id' => Department::where('name', 'DexMedia AP')->first()->id,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
            [
                'name' => 'fDO Spec',
                'department_id' => Department::where('name', 'DexMedia AP')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'fDO Awareness',
                'department_id' => Department::where('name', 'DexMedia AP')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'fSM Display Spec',
                'department_id' => Department::where('name', 'DexMedia AP')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'fSM Incolumn Spec',
                'department_id' => Department::where('name', 'DexMedia AP')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'fSM Display Sold',
                'department_id' => Department::where('name', 'DexMedia AP')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'fSM Incolumn Sold',
                'department_id' => Department::where('name', 'DexMedia AP')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'fSM AWARENESS',
                'department_id' => Department::where('name', 'DexMedia AP')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'VAR',
                'department_id' => Department::where('name', 'DexMedia AP')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'New Sites',
                'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Modifications',
                'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Legacy (New)',
                'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'SMR- Scheduling',
                'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'SMR- Tips Ordering',
                'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Expiring Domains- Closing',
                'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Expiring Domains- Migration Cases',
                'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Expiring Domains- V1/V2',
                'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Expiring Domains- V3',
                'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Web Admin- Assigning',
                'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Web Admin- Scheduling',
                'department_id' => Department::where('name', 'DexMedia Web')->first()->id,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
        ]);
    }
}
