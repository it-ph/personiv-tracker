<?php

use Illuminate\Database\Seeder;

class AccountPositionsMatcher extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DigitalFulfillmentPositions::class);
        $this->call(DigitalFulfillmentAccountPositions::class);
        $this->call(DexMediaAPAccountPositions::class);
    }
}
