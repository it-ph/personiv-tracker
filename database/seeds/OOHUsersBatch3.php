<?php

use Illuminate\Database\Seeder;

use App\Department;
use App\User;

class OOHUsersBatch3 extends Seeder
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
	        		'employee_number' => '10071401',
	        		'name' => 'Lesther John Mendador',
		        	'email' => 'lesther.mendador@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $ooh,
		        	'immediate_supervisor_id' => $johnBulaclac,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071021',
	        		'name' => 'Reeza Rose Lorica',
		        	'email' => 'reeza.lorica@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $ooh,
		        	'immediate_supervisor_id' => $johnBulaclac,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071141',
	        		'name' => 'Joyce Hibo',
		        	'email' => 'joyce.hibo@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $ooh,
		        	'immediate_supervisor_id' => $johnBulaclac,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071135',
	        		'name' => 'Niki Roselle Tendencia',
		        	'email' => 'niki.tendecia@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $ooh,
		        	'immediate_supervisor_id' => $johnBulaclac,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071184',
	        		'name' => 'Jacob Bariata',
		        	'email' => 'jacob.bariata@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $ooh,
		        	'immediate_supervisor_id' => $johnBulaclac,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071022',
	        		'name' => 'Joel Soterana',
		        	'email' => 'joel.soterana@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $ooh,
		        	'immediate_supervisor_id' => $johnBulaclac,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071509',
	        		'name' => 'Chestine Estremos',
		        	'email' => 'chestine.estremos@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $ooh,
		        	'immediate_supervisor_id' => $johnBulaclac,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071502',
	        		'name' => 'Francis Joseph Garcia',
		        	'email' => 'fracis.garcia@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $ooh,
		        	'immediate_supervisor_id' => $johnBulaclac,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071508',
	        		'name' => 'Jessica Espineda',
		        	'email' => 'jessica.espineda@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $ooh,
		        	'immediate_supervisor_id' => $johnBulaclac,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071878',
	        		'name' => 'Alvin Yambao',
		        	'email' => 'alvin.yambao@personiv.com',
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
