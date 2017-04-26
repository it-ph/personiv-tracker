<?php

use Illuminate\Database\Seeder;
use App\User;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
        	/* DexMedia AP */
        	[
        		'user_id' => User::where('name', 'Alexander Umali Atos')->first()->id,
        		'role_id' => 1,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        	[
        		'user_id' => User::where('name', 'Romeo T. Enriquez')->first()->id,
        		'role_id' => 1,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        	[
        		'user_id' => User::where('name', 'Alexis John Marca')->first()->id,
        		'role_id' => 1,
        		'created_at' => Carbon\Carbon::now(),
        		'updated_at' => Carbon\Carbon::now(),
        	],
        ]);
    }
}
