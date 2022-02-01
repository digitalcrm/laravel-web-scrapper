<?php

namespace App\Console\Commands;

use App\Http\Traits\JobSiteTrait;
use App\Models\Country;
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
    protected $signature = 'job:wrapping';

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
        $siteName = $this->choice(
            'Which sites jobs do you want to fetch?',
            ['bayt', 'linkedin', 'jobbank'],
            0,
        );

        $pages = $this->ask('How many pages do you want to scroll? [10, 20, 50 etc...]');

        if ($siteName == 'jobbank') {
            $countryId = $this->fetchCountry('canada');
            $countryName = 'canada';
        } elseif ($siteName == 'bayt') {
            $countryName = $this->choice(
                'select country',
                ['uae', 'ind', 'canada'],
                0,
            );
            $countryId = $this->fetchCountry($countryName);
            $countryName = ($countryName == 'ind') ? 'india' : $countryName;
        } else {
            $countryName = $this->choice(
                'select country',
                ['uae', 'ind', 'canada'],
                0,
            );
            $countryId = $this->fetchCountry($countryName);
        }

        if ($this->confirm('Do you wish to continue? [site: ' . $siteName . ', country: '.$countryName. ' and pages: ' . $pages . ']', true)) {
            $bar = $this->output->createProgressBar($pages);

            $bar->start();

            switch ($siteName) {
                case 'bayt':
                    $this->baytJobs($bar, $pages, $countryId, $countryName);
                    break;
                case 'linkedin':
                    $this->linkedInJobs($bar, $pages, $countryId, $countryName);
                    break;
                case 'jobbank':
                    $this->jobbankJobs($bar, $pages, $countryId, $countryName);
                    break;
            }

            $bar->finish();

            $this->newLine();

            $this->info('Job Fetched Successfully');
        }
    }

    protected function fetchCountry(string $country_name): int
    {
        $country = Country::where('sortname', $country_name)->first();

        return $country->id;
    }
}
