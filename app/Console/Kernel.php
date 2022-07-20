<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\FetchSiteJobs::class,
        Commands\RemoveJobs::class,
        Commands\ScrapPeople::class,
    ];
    
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('job:wrapping canada --gov-uk')->everyMinute();
        
        // // linkedin jobs for some few countries
        // $schedule->command('job:wrapping canada --linkedin')->everyMinute();
        // $schedule->command('job:wrapping ind --linkedin')->everyMinute();
        // $schedule->command('job:wrapping usa --linkedin')->everyMinute();
        // $schedule->command('job:wrapping uk --linkedin')->everyMinute();
        // $schedule->command('job:wrapping uae --linkedin')->everyMinute();
        // $schedule->command('job:wrapping sa --linkedin')->everyMinute();
        // $schedule->command('job:wrapping liberia --linkedin')->everyMinute();

        // // bayt jobs for uae and usa
        // $schedule->command('job:wrapping uae --bayt')->everyMinute();
        // $schedule->command('job:wrapping sa --bayt')->everyMinute();
        
        // // Jobbank jobs for canada only
        // $schedule->command('job:wrapping canada --jobank')->everyMinute();

        // // job fetch based on keywords and country for linkedin
        // $schedule->command('job:wrapping usa "Medical Doctor" --linkedin');

        // // indeed jobs only for usa inside "" use keyword for search
        // $schedule->command('job:wrapping usa "" "New York, Ny" --indeed');

        // gov.uk jobs
        // $schedule->command('job:wrapping london --gov-uk')->everyMinute();

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
