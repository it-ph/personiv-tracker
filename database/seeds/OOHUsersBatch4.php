<?php

use Illuminate\Database\Seeder;

use App\Department;
use App\User;

class OOHUsersBatch4 extends Seeder
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
			$johnBulaclac = User::where('name', 'Ray John Bulaclac')->first()->id;

			DB::table('users')->insert([
	        	[
	        		'employee_number' => '10071495',
	        		'name' => 'Leah Gangan',
		        	'email' => 'leah.gangan@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $ooh,
		        	'immediate_supervisor_id' => $johnBulaclac,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        ]);
	    });
    }
}
