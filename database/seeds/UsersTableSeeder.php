<?php

use Illuminate\Database\Seeder;

use App\Department;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	[
	        	'employee_number' => '10071128',
	        	'name' => 'Marco Paco',
	        	'email' => 'marco.paco@personiv.com',
	        	'password' => bcrypt('somerandomstring'),
	        	'super_user' => true,
	        	'department_id' => Department::where('name', 'DexMedia AP')->first()->id,
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
	        	'department_id' => Department::where('name', 'DexMedia AP')->first()->id,
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
	        	'department_id' => Department::where('name', 'DexMedia AP')->first()->id,
	        	'immediate_supervisor_id' => 1,
	        	'remember_token' => null,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        ]);
    }
}
