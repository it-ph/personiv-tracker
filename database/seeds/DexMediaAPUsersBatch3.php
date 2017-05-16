<?php

use Illuminate\Database\Seeder;

use App\Department;
use App\User;

class DexMediaAPUsersBatch3 extends Seeder
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

	        DB::table('users')->insert([
	        	[
	        		'employee_number' => '07010443',
	        		'name' => 'Dennis Crispo',
		        	'email' => 'dennis.crispo@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => null,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10070276',
	        		'name' => 'Amiel Beltran',
		        	'email' => 'amiel.beltran@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => null,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '05100202',
	        		'name' => 'Daisy Martinez',
		        	'email' => 'daisy.martinez@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => null,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '07010987',
	        		'name' => 'Bryan Del Prado',
		        	'email' => 'ayan.delprado@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => null,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '07010028',
	        		'name' => 'Joel Bonete',
		        	'email' => 'joel.bonete@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => null,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '07010031',
	        		'name' => 'Ibrahim Tangonan',
		        	'email' => 'ib.tangonan@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => null,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        ]);

	        $dennisCrispo = User::where('name', 'Dennis Crispo')->first()->id;
	        $amielBeltran = User::where('name', 'Amiel Beltran')->first()->id;
	        $daisyMartinez = User::where('name', 'Daisy Martinez')->first()->id;
	        $bryanDelPrado = User::where('name', 'Bryan Del Prado')->first()->id;
	        $joelBonete = User::where('name', 'Joel Bonete')->first()->id;
	        $ibrahimTangonan = User::where('name', 'Ibrahim Tangonan')->first()->id;

	        DB::table('user_roles')->insert([
	        	[
	        		'user_id' => $dennisCrispo,
	        		'role_id' => 1,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'user_id' => $amielBeltran,
	        		'role_id' => 1,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'user_id' => $daisyMartinez,
	        		'role_id' => 1,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'user_id' => $bryanDelPrado,
	        		'role_id' => 1,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'user_id' => $joelBonete,
	        		'role_id' => 1,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'user_id' => $ibrahimTangonan,
	        		'role_id' => 1,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        ]);

	        DB::table('users')->insert([
	        	/* DexMedia AP */
	        	[
	        		'employee_number' => '10071058',
	        		'name' => 'Jojemahr R. Binaday',
		        	'email' => 'jojemahr.binaday@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => $alexisMarca,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071699',
	        		'name' => 'Ronilo M. Limcaoco',
		        	'email' => 'ronilo.limcaoco@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => $dennisCrispo,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071711',
	        		'name' => 'Geraldine G. Campano',
		        	'email' => 'geraldine.campano@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => $dennisCrispo,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10070863',
	        		'name' => 'Krizzane Picardal',
		        	'email' => 'krisanne.picardal@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => $ibrahimTangonan,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071447',
	        		'name' => 'Arlene Buan',
		        	'email' => 'arlene.buan@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => $ibrahimTangonan,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '05100084',
	        		'name' => 'Nazario Capuz',
		        	'email' => 'nazario.capuz@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => $ibrahimTangonan,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071222',
	        		'name' => 'Bernardo Primo',
		        	'email' => 'bernardo.primo@personiv.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => $joelBonete,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10070328',
	        		'name' => 'Julie Ann Martinez',
		        	'email' => 'julie.martinez@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => $joelBonete,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071364',
	        		'name' => 'Josiah Jon Rubio',
		        	'email' => 'josiah.rubio@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => $amielBeltran,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071029',
	        		'name' => 'Rustom Deonon',
		        	'email' => 'rustom.deonon@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => $bryanDelPrado,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '10071543',
	        		'name' => 'Kristine Panado',
		        	'email' => 'khristine.panado@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => $daisyMartinez,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        	[
	        		'employee_number' => '05100259',
	        		'name' => 'Russel Rivera',
		        	'email' => 'russel.rivera@personive.com',
		        	'password' => bcrypt('!welcome10'),
		        	'super_user' => false,
		        	'department_id' => $dexMediaAP,
		        	'immediate_supervisor_id' => $daisyMartinez,
		        	'remember_token' => null,
	        		'created_at' => Carbon\Carbon::now(),
	        		'updated_at' => Carbon\Carbon::now(),
	        	],
	        ]);
    	});
    }
}
