<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(AccountsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserRolesTableSeeder::class);
        $this->call(OOHUsersSeeder::class);
        $this->call(DexMediaAPSeeders::class);
        $this->call(DigitalFulFillmentUsersSeeder::class);
        $this->call(DexMediaAPUsersBatch3::class);
    }
}
