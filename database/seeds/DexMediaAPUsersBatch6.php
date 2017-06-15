<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Department;
use App\Role;

class DexMediaAPUsersBatch6 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
          $dexMediaAP = Department::where('name', 'DexMedia AP')->first();
          $settings = Role::where('name', 'Settings')->first();
          $supervisor = Role::where('name', 'Supervisor')->first();

          $joseph = new User;

          $joseph->employee_number = '06030376';
          $joseph->name = 'Joseph Juntilla';
          $joseph->email = 'jos.juntilla@personiv.com';
          $joseph->password = bcrypt('!welcome10');
          $joseph->department_id = $dexMediaAP->id;

          $joseph->save();
          $joseph->roles()->attach($settings->id);
          $joseph->roles()->attach($supervisor->id);

          $noel = new User;

          $noel->employee_number = '10071309';
          $noel->name = 'Noel Cruz';
          $noel->email = 'noel.cruz@personiv.com';
          $noel->password = bcrypt('!welcome10');
          $noel->department_id = $dexMediaAP->id;

          $noel->save();
          $noel->roles()->attach($settings->id);
          $noel->roles()->attach($supervisor->id);
        });
    }
}
