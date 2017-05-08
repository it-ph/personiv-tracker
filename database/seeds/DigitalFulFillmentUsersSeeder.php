<?php

use Illuminate\Database\Seeder;

use App\Department;
use App\User;

class DigitalFulFillmentUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$digitalFulfillment = Department::where('name', 'Digital Fulfillment')->first()->id;

        DB::table('users')->insert([
        	'employee_number' => '10070715',
    		'name' => 'Franklin Jayawon',
        	'email' => 'franklin.jayawon@personiv.com',
        	'password' => bcrypt('!welcome10'),
        	'super_user' => false,
        	'department_id' => $digitalFulfillment,
        	'immediate_supervisor_id' => null,
        	'remember_token' => null,
    		'created_at' => Carbon\Carbon::now(),
    		'updated_at' => Carbon\Carbon::now(),
        ]);

        $franklinJayawon = User::where('name', 'Franklin Jayawon')->first()->id;

        DB::table('user_roles')->insert([
        	'user_id' => $franklinJayawon,
    		'role_id' => 1,
    		'created_at' => Carbon\Carbon::now(),
    		'updated_at' => Carbon\Carbon::now(),
        ]);

        DB::table('users')->insert([
        	[
	        	'employee_number' => '10071192',
	    		'name' => 'Dizelle Vhan Cabugsa',
	        	'email' => 'dizelle.cabugsa@personiv.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => $digitalFulfillment,
	        	'immediate_supervisor_id' => $franklinJayawon,
	        	'remember_token' => null,
	    		'created_at' => Carbon\Carbon::now(),
	    		'updated_at' => Carbon\Carbon::now(),
        	],
        	[
	        	'employee_number' => '10071567',
	    		'name' => 'Marivic Aquino',
	        	'email' => 'marvin.aquino@personive.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => $digitalFulfillment,
	        	'immediate_supervisor_id' => $franklinJayawon,
	        	'remember_token' => null,
	    		'created_at' => Carbon\Carbon::now(),
	    		'updated_at' => Carbon\Carbon::now(),
        	],
        ]);
    }
}
