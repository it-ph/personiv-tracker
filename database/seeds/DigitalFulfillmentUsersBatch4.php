<?php

use Illuminate\Database\Seeder;

use App\Department;
use App\User;

class DigitalFulfillmentUsersBatch4 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
        	$digitalFulfillment = Department::where('name', 'Digital Fulfillment')->first()->id;
        	$viobertDumaliang = User::where('name', 'Viobert Dumaliang')->first()->id;

        	DB::table('users')->insert([
        		[
        			'employee_number' => '10071125',
		    		'name' => 'Mawel Abellana',
		        	'email' => 'mawel.abellana@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => $viobertDumaliang,
		        	'remember_token' => null,
		    		'created_at' => Carbon\Carbon::now(),
		    		'updated_at' => Carbon\Carbon::now(),
        		],
        		[
        			'employee_number' => '10071358',
		    		'name' => 'Eloisa Batayon',
		        	'email' => 'eloisa.batoyan@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => $viobertDumaliang,
		        	'remember_token' => null,
		    		'created_at' => Carbon\Carbon::now(),
		    		'updated_at' => Carbon\Carbon::now(),
        		],
        		[
        			'employee_number' => '10071296',
		    		'name' => 'Allan Rodriguez',
		        	'email' => 'allan.rodriguez@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => $viobertDumaliang,
		        	'remember_token' => null,
		    		'created_at' => Carbon\Carbon::now(),
		    		'updated_at' => Carbon\Carbon::now(),
        		],
        	]);
        });
    }
}
