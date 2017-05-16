<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Department;
use Carbon\Carbon;

class ProcessAnalystAccount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::transaction(function(){
    		$revolve = Department::where('name', 'Revolve')->first()->id;

	        DB::table('users')->insert([
	        	[
		        	'employee_number' => '10070622',
		        	'name' => 'Sherryl Sanchez',
		        	'email' => 'sherryl.sanchez@personiv.com',
		        	'password' => bcrypt('somerandomstring'),
		        	'super_user' => true,
		        	'department_id' => null,
		        	'immediate_supervisor_id' => null,
		        	'remember_token' => null,
	        		'created_at' => Carbon::now(),
	        		'updated_at' => Carbon::now(),
	        	],
	        	[
		        	'employee_number' => '07010937',
		        	'name' => 'Adrian Bonito',
		        	'email' => 'ryan.bonito@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $revolve,
		        	'immediate_supervisor_id' => null,
		        	'remember_token' => null,
	        		'created_at' => Carbon::now(),
	        		'updated_at' => Carbon::now(),
	        	],
	        ]);

	        $sherryl = User::where('name', 'Sherryl Sanchez')->first()->id;
	        $adrian = User::where('name', 'Adrian Bonito')->first()->id;

	        DB::table('user_roles')->insert([
	        	[
	        		'user_id' => $sherryl,
	        		'role_id' => 1,
	        		'created_at' => Carbon::now(),
	        		'updated_at' => Carbon::now(),
	        	],
	        	[
	        		'user_id' => $adrian,
	        		'role_id' => 1,
	        		'created_at' => Carbon::now(),
	        		'updated_at' => Carbon::now(),
	        	],
	        	[
	        		'user_id' => $adrian,
	        		'role_id' => 2,
	        		'created_at' => Carbon::now(),
	        		'updated_at' => Carbon::now(),
	        	],
	        ]);
    	});
    }
}
