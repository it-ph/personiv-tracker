<?php

use Illuminate\Database\Seeder;
use App\Department;
use App\User;

class RevolveUsersBatchTwo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
            $revolve = Department::where('name', 'Revolve')->first()->id;
            $adrian = User::where('name', 'Adrian Bonito')->first()->id;

            DB::table('users')->insert([
              [
                'employee_number' => '10071891',
                'name' => 'Joseph Urbano',
                'email' => 'joseph.urbano@personiv.com',
                'password' => bcrypt('!welcome10'),
                'super_user' => false,
                'department_id' => $revolve,
                'immediate_supervisor_id' => $adrian,
                'remember_token' => null,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
              ],
            ]);
        });
    }
}
