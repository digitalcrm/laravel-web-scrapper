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
        // $schedule->command('inspire')->hourly();

        // bayt jobs for uae and usa
        $schedule->command('job:wrapping uae --bayt')->everyThirtyMinutes();
        $schedule->command('job:wrapping usa --bayt')->everyThirtyMinutes();
        
        // Jobbank jobs for canada only
        $schedule->command('job:wrapping canada --jobank')->everyTwoHours();
        
        // linkedin jobs for some few countries
        $schedule->command('job:wrapping canada --linkedin')->everyThirtyMinutes();
        $schedule->command('job:wrapping india --linkedin')->everyThirtyMinutes();
        $schedule->command('job:wrapping usa --linkedin')->everyThirtyMinutes();
        $schedule->command('job:wrapping uk --linkedin')->everyThirtyMinutes();
        $schedule->command('job:wrapping uae --linkedin')->everyThirtyMinutes();
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
