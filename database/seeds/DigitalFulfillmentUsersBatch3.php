<?php

use Illuminate\Database\Seeder;

use App\Department;
use App\User;

class DigitalFulfillmentUsersBatch3 extends Seeder
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

        	DB::table('users')->insert([
        		[
        			'employee_number' => '10070541',
		    		'name' => 'Lester John Somosa',
		        	'email' => 'lester.somosa@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => null,
		        	'remember_token' => null,
		    		'created_at' => Carbon\Carbon::now(),
		    		'updated_at' => Carbon\Carbon::now(),
        		],
        		[
        			'employee_number' => '07010980',
		    		'name' => 'Jayrald Buenavente',
		        	'email' => 'jay.buenavente@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => null,
		        	'remember_token' => null,
		    		'created_at' => Carbon\Carbon::now(),
		    		'updated_at' => Carbon\Carbon::now(),
        		],
        		[
        			'employee_number' => '10071156',
		    		'name' => 'Viobert Dumaliang',
		        	'email' => 'viobert.dumaliang@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => null,
		        	'remember_token' => null,
		    		'created_at' => Carbon\Carbon::now(),
		    		'updated_at' => Carbon\Carbon::now(),
        		],
        	]);

        	$lesterSomosa = User::where('name', 'Lester John Somosa')->first()->id;
        	$jayraldBuenavente = User::where('name', 'Jayrald Buenavente')->first()->id;
        	$viobertDumaliang = User::where('name', 'Viobert Dumaliang')->first()->id;

        	DB::table('user_roles')->insert([
        		[
	        		'user_id' => $lesterSomosa,
	        		'role_id' => 1,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
        		],
        		[
	        		'user_id' => $jayraldBuenavente,
	        		'role_id' => 1,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
        		],
        		[
	        		'user_id' => $viobertDumaliang,
	        		'role_id' => 1,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
        		],
        	]);

        	DB::table('users')->insert([
        		[
        			'employee_number' => '10071244',
		    		'name' => 'Jone Filip Franco',
		        	'email' => 'jone.franco@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => $lesterSomosa,
		        	'remember_token' => null,
		    		'created_at' => Carbon\Carbon::now(),
		    		'updated_at' => Carbon\Carbon::now(),
        		],
        		[
        			'employee_number' => '10071795',
		    		'name' => 'Jean Claude Uriarte',
		        	'email' => 'jeanclaude.uriarte@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => $lesterSomosa,
		        	'remember_token' => null,
		    		'created_at' => Carbon\Carbon::now(),
		    		'updated_at' => Carbon\Carbon::now(),
        		],
        		[
        			'employee_number' => '10071598',
		    		'name' => 'Ellis Opano',
		        	'email' => 'ellis.opano@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => $lesterSomosa,
		        	'remember_token' => null,
		    		'created_at' => Carbon\Carbon::now(),
		    		'updated_at' => Carbon\Carbon::now(),
        		],
        		[
        			'employee_number' => '10071416',
		    		'name' => 'Jomar A. Diamse',
		        	'email' => 'jomar.diamse@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => $jayraldBuenavente,
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
        		[
        			'employee_number' => '10071284',
		    		'name' => 'Lance Bolivar Leoncito',
		        	'email' => 'lanceleoncito@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => $jayraldBuenavente,
		        	'remember_token' => null,
		    		'created_at' => Carbon\Carbon::now(),
		    		'updated_at' => Carbon\Carbon::now(),
        		],
        		[
        			'employee_number' => '10071285',
		    		'name' => 'Sherwin Jay Suva',
		        	'email' => 'sherwin.suva@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => $viobertDumaliang,
		        	'remember_token' => null,
		    		'created_at' => Carbon\Carbon::now(),
		    		'updated_at' => Carbon\Carbon::now(),
        		],
        		[
        			'employee_number' => '10071275',
		    		'name' => 'Noriel Bernard Lugo',
		        	'email' => 'noriel.lugo@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => $viobertDumaliang,
		        	'remember_token' => null,
		    		'created_at' => Carbon\Carbon::now(),
		    		'updated_at' => Carbon\Carbon::now(),
        		],
        		[
        			'employee_number' => '10071751',
		    		'name' => 'Gerald John Gales',
		        	'email' => 'geraldjohn.gales@personive.com',
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
