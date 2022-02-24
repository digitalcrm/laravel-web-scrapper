<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\FetchSiteJobs::class,
        Commands\RemoveJobs::class,
    ];
    
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // linkedin jobs for some few countries
        $schedule->command('job:wrapping canada --linkedin')->everyMinute();
        $schedule->command('job:wrapping ind --linkedin')->everyMinute();
        $schedule->command('job:wrapping usa --linkedin')->everyMinute();
        $schedule->command('job:wrapping uk --linkedin')->everyMinute();
        $schedule->command('job:wrapping uae --linkedin')->everyMinute();

        // bayt jobs for uae and usa
        $schedule->command('job:wrapping uae --bayt')->everyMinute();
        $schedule->command('job:wrapping usa --bayt')->everyMinute();
        
        // Jobbank jobs for canada only
        $schedule->command('job:wrapping canada --jobank')->everyMinute();
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
