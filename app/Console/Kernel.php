<?php

namespace App\Console;

use App\Console\Commands\AssignOrder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AssignOrder::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //'/usr/bin/php8.0' 'artisan' assign > '/dev/null' 2>&1
//        /home/asmaa/itstellar/pudo
//        * * * * * php /home/asmaa/itstellar/pudo/artisan schedule:run 1>> /dev/null 2>&1

         $schedule->command('command:assign')
                  ->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
