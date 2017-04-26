<?php

use Illuminate\Database\Seeder;

use App\Department;
use App\User;

class OOHUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$ooh = Department::where('name', 'OOH')->first()->id;

        DB::table('users')->insert([
        	[
        		'employee_number' => '07010221',
        		'name' => 'Ray John Bulaclac',
	        	'email' => 'john.bulaclac@personiv.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => $ooh,
	        	'immediate_supervisor_id' => null,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        ]);

		$johnBulaclac = User::where('name', 'Ray John Bulaclac')->first()->id;

        DB::table('users')->insert([
        	[
        		'employee_number' => '10071490',
        		'name' => 'Marife Estrada',
	        	'email' => 'marife.estrada@personiv.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => $ooh,
	        	'immediate_supervisor_id' => $johnBulaclac,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        	[
        		'employee_number' => '10071307',
        		'name' => 'Marlon Rance Estrada',
	        	'email' => 'marlon.estrada@personiv.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => $ooh,
	        	'immediate_supervisor_id' => $johnBulaclac,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        	[
        		'employee_number' => '10071402',
        		'name' => 'Gerard Golosinda',
	        	'email' => 'gerard.golosinda@personiv.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => $ooh,
	        	'immediate_supervisor_id' => $johnBulaclac,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        ]);

        DB::table('user_roles')->insert([
        	/* DexMedia AP */
        	[
        		'user_id' => User::where('name', 'Ray John Bulaclac')->first()->id,
        		'role_id' => 1,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        ]);
    }
}
