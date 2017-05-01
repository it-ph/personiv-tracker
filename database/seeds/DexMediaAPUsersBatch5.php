<?php

use Illuminate\Database\Seeder;

use App\Department;
use App\User;

class DexMediaAPUsersBatch5 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
        	$dexMediaAP = Department::where('name', 'DexMedia AP')->first()->id;

	        $alexAtos = User::where('name', 'Alexander Umali Atos')->first()->id;
	        $alexisMarca = User::where('name', 'Alexis John Marca')->first()->id;
	        $romeoEnriquez = User::where('name', 'Romeo T. Enriquez')->first()->id;
			$dennisCrispo = User::where('name', 'Dennis Crispo')->first()->id;
	        $amielBeltran = User::where('name', 'Amiel Beltran')->first()->id;
	        $daisyMartinez = User::where('name', 'Daisy Martinez')->first()->id;
	        $bryanDelPrado = User::where('name', 'Bryan Del Prado')->first()->id;
	        $joelBonete = User::where('name', 'Joel Bonete')->first()->id;
	        $ibrahimTangonan = User::where('name', 'Ibrahim Tangonan')->first()->id;

	        DB::table('users')->insert([
	        	[
	        		'employee_number' => '10071664',
	        		'name' => 'Carl Noe Camposano',
		        	'email' => 'carl.camposano@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => $bryanDelPrado,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        ]);
        });
    }
}
