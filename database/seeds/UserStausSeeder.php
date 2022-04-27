<?php

use Illuminate\Database\Seeder;

class UserStausSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_statuses')->insert(array(
            array(
                'name' => 'Active',
                'class' => 'success',
            ),
            array(
                'name' => 'Inactive',
                'class' => 'danger',
            ),
        ));
    }
}
