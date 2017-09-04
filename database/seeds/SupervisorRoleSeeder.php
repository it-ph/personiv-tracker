<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Carbon\Carbon;

class SupervisorRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::transaction(function(){
        DB::table('roles')->insert([
          'name' => 'Supervisor',
          'description' => 'user can manage user accounts.',
          'super_user_action' => false,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]);

        $users = User::whereDoesntHave('roles', function($query){
          $query->where('name', 'Department Head');
        })->has('roles')->get();

        $supervisor = Role::where('name', 'Supervisor')->first();

        $users->each(function ($user, $key) use($supervisor){
          $user->roles()->save($supervisor);
        });
      });
    }
}
