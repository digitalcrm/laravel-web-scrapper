<?php

namespace App\Console\Commands;

use App\Http\Traits\JobSiteTrait;
use App\Models\Scrap;
use Illuminate\Console\Command;

class FetchSiteJobs extends Command
{
    use JobSiteTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:wrapping {pages=50}
                            {--bayt : bayt jobs fetch}
                            {--jobbank : jobbank jobs fetch}
                            {--linkedin : linkedin jobs fetch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest jobs from different sites';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pages = $this->ask('How many pages do you want to scroll? [10, 20, 50 etc...]');

        if ($this->confirm('Do you wish to continue? [pages: ' . $pages . ']', true)) {
            $bar = $this->output->createProgressBar($pages);

            $bar->start();

            if ($this->option('bayt')) {
                $this->baytJobs($bar, $pages);
            } elseif ($this->option('linkedin')) {
                $this->linkedInJobs($bar, $pages);
            } elseif ($this->option('jobbank')) {
                $this->jobbankJobs($bar, $pages);
            } else {
                $this->baytJobs($bar, $pages);
                /*
                    $siteName = $this->ask('Enter Site Name such as [bayt, linkedin, jobbank]');
                    $pages = $this->ask('Wrap Data up to pages [10, 20, 50 etc...]');
                    if ($this->confirm('Do you wish to continue?[ Site: '.$siteName.', Pages: '.$pages.']')) {
                        $this->jobsFor($bar, $siteName, $pages);
                    }
                */
            }

            $bar->finish();

            $this->newLine();

            $this->info('Job Fetched Successfully');
        }
    }

    /*
        protected function jobsFor($bar, $name, $pages)
        {
            switch ($name) {
                case 'bayt':
                    return $this->baytJobs($bar, $pages);
                    break;

                case 'linkedin':
                    return $this->linkedInJobs($bar, $pages);
                    break;

                case 'jobbank':
                    return $this->jobbankJobs($bar, $pages);
                    break;
            }
        }
    */
}