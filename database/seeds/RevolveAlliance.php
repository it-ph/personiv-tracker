<?php

use Illuminate\Database\Seeder;

class RevolveAlliance extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RevolveAllianceProject::class);
        $this->call(RevolveAllianceTasks::class);
    }
}
