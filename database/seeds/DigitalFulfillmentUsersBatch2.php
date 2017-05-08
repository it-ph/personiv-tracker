<?php

use Illuminate\Database\Seeder;

use App\Department;
use App\User;

class DigitalFulfillmentUsersBatch2 extends Seeder
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
        			'employee_number' => '10070943',
		    		'name' => 'Teddy Boy Masaya',
		        	'email' => 'teddy.masaya@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => null,
		        	'remember_token' => null,
		    		'created_at' => Carbon\Carbon::now(),
		    		'updated_at' => Carbon\Carbon::now(),
        		],
        	]);

        	$teddyMasaya = User::where('name', 'Teddy Boy Masaya')->first()->id;

        	DB::table('user_roles')->insert([
        		'user_id' => $teddyMasaya,
        		'role_id' => 1,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	]);

        	DB::table('users')->insert([
        		[
        			'employee_number' => '10071355',
		    		'name' => 'Erise Galarosa Teodosio',
		        	'email' => 'erise.teodosio@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => $teddyMasaya,
		        	'remember_token' => null,
		    		'created_at' => Carbon\Carbon::now(),
		    		'updated_at' => Carbon\Carbon::now(),
        		],
        		[
        			'employee_number' => '10071076',
		    		'name' => 'Rommel Barachina',
		        	'email' => 'rommel.barachina@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => $teddyMasaya,
		        	'remember_token' => null,
		    		'created_at' => Carbon\Carbon::now(),
		    		'updated_at' => Carbon\Carbon::now(),
        		],
        		[
        			'employee_number' => '10070963',
		    		'name' => 'Mark Daniel U. Laygo',
		        	'email' => 'mark.laygo@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $digitalFulfillment,
		        	'immediate_supervisor_id' => $teddyMasaya,
		        	'remember_token' => null,
		    		'created_at' => Carbon\Carbon::now(),
		    		'updated_at' => Carbon\Carbon::now(),
        		],
        	]);
        });
    }
}
