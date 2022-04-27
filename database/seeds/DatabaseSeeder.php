<?php

use Illuminate\Database\Seeder;
//use database\seeds\NotesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call('MaxShipmentNumber');
        $this->call('ExampleSeeder');
       $this->call('Moneytableseed');
       $this->call('ApplicationStatusSeeder');
       $this->call('OrderStatusSeed');
       $this->call('UsersAndNotesSeeder');
       $this->call('UserStausSeeder');
       $this->call('MenusTableSeeder');

    }
}
