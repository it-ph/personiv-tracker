<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	[
	        	'employee_number' => '10071128',
	        	'first_name' => 'Marco',
	        	'middle_name' => 'Santillan',
	        	'last_name' => 'Paco',
	        	'suffix' => null,
	        	'email' => 'marco.paco@personiv.com',
	        	'password' => bcrypt('somerandomstring'),
	        	'super_user' => true,
	        	'department_id' => \App\Department::where('name', 'IT')->first()->id,
	        	'account_id' => null,
	        	'immediate_supervisor_id' => 2,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        	[
	        	'employee_number' => '123456789',
	        	'first_name' => 'John',
	        	'middle_name' => null,
	        	'last_name' => 'Doe',
	        	'suffix' => null,
	        	'email' => 'john.doe@example.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => \App\Department::where('name', 'DexMedia')->first()->id,
	        	'account_id' => \App\Account::where('name', 'VAR')->first()->id,
	        	'immediate_supervisor_id' => 2,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        ]);
    }
}
