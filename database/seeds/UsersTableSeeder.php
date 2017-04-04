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
	        	'password' => bcrypt('1234'),
	        	'super_user' => true,
	        	'department_id' => \App\Department::where('name', 'IT')->first()->id,
	        	'account_id' => null,
	        	'immediate_supervisor_id' => 2,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        	[
	        	'employee_number' => '05090030',
	        	'first_name' => 'Jaime',
	        	'middle_name' => null,
	        	'last_name' => 'Talingdan',
	        	'suffix' => 'Jr.',
	        	'email' => 'jhai.talingdan@personiv.com',
	        	'password' => bcrypt('1234'),
	        	'super_user' => true,
	        	'department_id' => \App\Department::where('name', 'IT')->first()->id,
	        	'account_id' => null,
	        	'immediate_supervisor_id' => 2,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        ]);
    }
}
