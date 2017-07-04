<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Department;
use App\Role;

class RevolveNewTeamLeader extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adrian = User::where('name', 'Adrian Bonito')->first();

        $subordinates = User::where('immediate_supervisor_id', $adrian->id)->get();

        $revolve = Department::where('name', 'Revolve')->first();

        $edward = User::create([
            'employee_number' => '10071936',
            'name' => 'Edward Pintoy',
            'email' => 'edward.pintoy@personiv.com',
            'password' => bcrypt('!welcome10'),
            'department_id' => $revolve->id,
            'immediate_supervisor_id' => null,
        ]);

        $settings = Role::where('name', 'Settings')->first();
        $supervisor = Role::where('name', 'Supervisor')->first();

        $edward->roles()->attach([
            $settings->id,
            $supervisor->id,
        ]);

        $subordinates->each(function($subordinate) use($edward) {
            $subordinate->immediate_supervisor_id = $edward->id;
            $subordinate->save();
        });
    }
}
