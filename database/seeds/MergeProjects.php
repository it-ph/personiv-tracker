<?php

use Illuminate\Database\Seeder;

class MergeProjects extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MergeAllisonLamar::class);
        $this->call(MergefDOSold::class);
        $this->call(MergefDOSpec::class);
    }
}
