<?php

use Illuminate\Database\Seeder;

use App\Department;
use App\User;

class OOHUsersBatch2 extends Seeder
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
	        $digitalFulfillment = Department::where('name', 'Digital Fulfillment')->first()->id;
	        $johnBulaclac = User::where('name', 'Ray John Bulaclac')->first()->id;
	        $jayraldBuenavente = User::where('name', 'Jayrald Buenavente')->first()->id;
    		
	        DB::table('users')->insert([
	        	[
	        		'employee_number' => '10070925',
	        		'name' => 'Dan Reinier S. Dela Torre',
		        	'email' => 'dan.delatorre@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $ooh,
		        	'immediate_supervisor_id' => $johnBulaclac,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071441',
	        		'name' => 'James Paul Pacardo',
		        	'email' => 'james.pacardo@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => $jayraldBuenavente,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
        	]);
    	});
    }
}
