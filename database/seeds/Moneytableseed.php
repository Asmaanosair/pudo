<?php

use Illuminate\Database\Seeder;

class Moneytableseed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('money')->insert(array(
            array(
                'max_money' => 100,
                'week' => 1,

            ),
        ));
    }
}
