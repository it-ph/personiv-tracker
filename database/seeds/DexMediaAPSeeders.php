<?php

use Illuminate\Database\Seeder;

use App\Department;
use App\User;

class DexMediaAPSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dexMediaAP = Department::where('name', 'DexMedia AP')->first()->id;

        $alexAtos = User::where('name', 'Alexander Umali Atos')->first()->id;
        $alexisMarca = User::where('name', 'Alexis John Marca')->first()->id;
        $romeoEnriquez = User::where('name', 'Romeo T. Enriquez')->first()->id;

         DB::table('users')->insert([
        	/* DexMedia AP */
        	[
        		'employee_number' => '10071454',
        		'name' => 'Kristine Danielle Pamilar',
	        	'email' => 'kristine.pamilar@personive.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => $dexMediaAP,
	        	'immediate_supervisor_id' => $alexAtos,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        	[
        		'employee_number' => '10071399',
        		'name' => 'Rachel Sabino',
	        	'email' => 'rachel.aranar@personive.com',
	        	'password' => bcrypt('!welcome10'),
	        	'super_user' => false,
	        	'department_id' => $dexMediaAP,
	        	'immediate_supervisor_id' => $alexAtos,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
            [
                'employee_number' => '07010285',
                'name' => 'Roselyn Levantino',
                'email' => 'roselyn.levantino@personive.com',
                'password' => bcrypt('!welcome10'),
                'super_user' => false,
                'department_id' => $dexMediaAP,
                'immediate_supervisor_id' => $romeoEnriquez,
                'remember_token' => null,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
        ]);
    }
}
