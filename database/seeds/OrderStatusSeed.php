<?php

use Illuminate\Database\Seeder;

class OrderStatusSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_statuses')->insert(array(
            array(
                'name' => 'NEW_ORDER',
                'class' => 'success',
            ),
            array(
                'name' => 'ASSIGNED_TO_DRIVER',
                'class' => 'info',
            ),
            array(
                'name' => 'DRIVER_ACCEPTED',
                'class' => 'primary',
            ),
            array(
                'name' => 'DRIVER_REJECTED',
                'class' => 'warning',
            ),
            array(
                'name' => 'FAILED_TO_RETURN',
                'class' => 'danger',
            ),
            array(
                'name' => 'TO_BE_PICKED_UP',
                'class' => 'secondary',
            ),
            array(
                'name' => 'PICKED_UP',
                'class' => 'info',
            ),
            array(
                'name' => 'TO_BE_DELIVERED',
                'class' => 'secondary',
            ),
            array(
                'name' => 'DELIVERED',
                'class' => 'success',
            ),
            array(
                'name' => 'RETURNED',
                'class' => 'danger',
            ),
            array(
                'name' => 'CANCELED',
                'class' => 'danger',
            ),

        ));
    }
}
