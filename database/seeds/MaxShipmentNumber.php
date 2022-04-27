<?php

use Illuminate\Database\Seeder;

class MaxShipmentNumber extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('max_shipment_numbers')->insert(array(
            array(
                'max_number' => 10,


            ),
        ));
    }
}
