<?php

use Illuminate\Database\Seeder;

use App\Department;
use App\User;
use Carbon\Carbon;

class RevolveDepartment extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
        	DB::table('departments')->insert([
        		'name' => 'Revolve',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now(),
        	]);

        	$revolve = Department::where('name', 'Revolve')->first()->id;

        	DB::table('accounts')->insert([
        		'name' => 'Revolve',
        		'department_id' => $revolve,
        		'batchable' => true,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now(),
        	]);

        	DB::table('users')->insert([
        		[
		        	'employee_number' => '10071128',
		        	'name' => 'Marco Paco',
		        	'email' => 'marco.paco@personiv.com',
		        	'password' => bcrypt('somerandomstring'),
		        	'super_user' => true,
		        	'department_id' => $revolve,
		        	'immediate_supervisor_id' => null,
		        	'remember_token' => null,
	        		'created_at' => Carbon::now(),
	        		'updated_at' => Carbon::now(),
	        	],
	        	[
		        	'employee_number' => '123456789',
		        	'name' => 'John Doe',
		        	'email' => 'john.doe@example.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $revolve,
		        	'immediate_supervisor_id' => 1,
		        	'remember_token' => null,
	        		'created_at' => Carbon::now(),
	        		'updated_at' => Carbon::now(),
	        	],
	        	[
		        	'employee_number' => '123',
		        	'name' => 'Jane Doe',
		        	'email' => 'jane.doe@example.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $revolve,
		        	'immediate_supervisor_id' => 1,
		        	'remember_token' => null,
	        		'created_at' => Carbon::now(),
	        		'updated_at' => Carbon::now(),
	        	],
        	]);

        	$marco = User::where('name', 'Marco Paco')->first()->id;

        	DB::table('user_roles')->insert([
        		[
        			'user_id' => $marco,
        			'role_id' => 1,
        			'created_at' => Carbon::now(),
        			'updated_at' => Carbon::now(),
        		],
        		[
        			'user_id' => $marco,
        			'role_id' => 2,
        			'created_at' => Carbon::now(),
        			'updated_at' => Carbon::now(),
        		],
        	]);
        });
    }
}
