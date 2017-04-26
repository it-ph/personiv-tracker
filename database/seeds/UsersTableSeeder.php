<?php

use Illuminate\Database\Seeder;

use App\Department;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$dexMediaAP = Department::where('name', 'DexMedia AP')->first()->id;
    	$dexMediaWeb = Department::where('name', 'DexMedia Web')->first()->id;

        DB::table('users')->insert([
        	/* Test */
        	[
	        	'employee_number' => '10071128',
	        	'name' => 'Marco Paco',
	        	'email' => 'marco.paco@personiv.com',
	        	'password' => bcrypt('somerandomstring'),
	        	'super_user' => true,
	        	'department_id' => $dexMediaAP,
	        	'immediate_supervisor_id' => null,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        	[
	        	'employee_number' => '123456789',
	        	'name' => 'John Doe',
	        	'email' => 'john.doe@example.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => $dexMediaAP,
	        	'immediate_supervisor_id' => 1,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        	[
	        	'employee_number' => '123',
	        	'name' => 'Jane Doe',
	        	'email' => 'jane.doe@example.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => $dexMediaAP,
	        	'immediate_supervisor_id' => 1,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],

        	/* DexMedia AP TL */
        	[
        		'employee_number' => '07010250',
        		'name' => 'Romeo T. Enriquez',
	        	'email' => 'romy.enriquez@personiv.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => $dexMediaAP,
	        	'immediate_supervisor_id' => null,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        	[
        		'employee_number' => '07010785',
        		'name' => 'Alexander Umali Atos',
	        	'email' => 'alex.atos@personiv.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => $dexMediaAP,
	        	'immediate_supervisor_id' => null,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        	[
        		'employee_number' => '07010281',
        		'name' => 'Alexis John Marca',
	        	'email' => 'alexis.marca@personiv.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => $dexMediaAP,
	        	'immediate_supervisor_id' => null,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        ]);

        $alexAtos = User::where('name', 'Alexander Umali Atos')->first()->id;
    	$romeoEnriquez = User::where('name', 'Romeo T. Enriquez')->first()->id;
    	$alexisMarca = User::where('name', 'Alexis John Marca')->first()->id;

        DB::table('users')->insert([
        	/* DexMedia AP */
        	[
        		'employee_number' => '10071448',
        		'name' => 'Madelaine Abarquez',
	        	'email' => 'madeline.abarquez@personive.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => $dexMediaAP,
	        	'immediate_supervisor_id' => $alexAtos,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        	[
        		'employee_number' => '10070842',
        		'name' => 'Reynaldo Escobar',
	        	'email' => 'reynaldo.escobar@personive.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => $dexMediaAP,
	        	'immediate_supervisor_id' => $romeoEnriquez,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        	[
        		'employee_number' => '10071365',
        		'name' => 'Lorraine Anne Mateo',
	        	'email' => 'lorraine.mateo@personive.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => $dexMediaAP,
	        	'immediate_supervisor_id' => $alexisMarca,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        ]);
    }
}
