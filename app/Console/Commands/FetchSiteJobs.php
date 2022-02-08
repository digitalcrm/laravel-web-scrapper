<?php

namespace App\Console\Commands;

use App\Models\Scrap;
use App\Models\Country;
use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use App\Http\Traits\JobSiteTrait;

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

        $countryData = $this->get_selected_country_id_and_name($siteName)->first();

        if ($this->confirm('Do you wish to continue? [site: ' . $siteName . ', country: ' . $countryData['country_name'] . ' and pages: ' . $pages . ']',true)) 
        {
            $bar = $this->output->createProgressBar($pages);

            $bar->start();

            switch ($siteName) {
                case 'bayt':
                    $this->baytJobs($bar, $pages, $countryData['country_id'], $countryData['country_name']);
                    break;
                case 'linkedin':
                    $this->linkedInJobs($bar, $pages, $countryData['country_id'], $countryData['country_name']);
                    break;
                case 'jobbank':
                    $this->jobbankJobs($bar, $pages, $countryData['country_id'], $countryData['country_name']);
                    break;
            }

            $bar->finish();

            $this->newLine();

            $this->info('Job Fetched Successfully');
        }
    }

    /**
     * based on selected sitename get country data
     *
     * @param string $siteName
     */
    protected function get_selected_country_id_and_name($siteName)
    {
        $arrayData = collect();

        if ($siteName == 'jobbank') {
            $countryId = $this->fetchCountryData('canada');
            $countryName = 'canada';
        } elseif ($siteName == 'bayt') {
            $countryName = $this->choice(
                'select country',
                ['uae', 'ind', 'canada', 'usa', 'uk'],
                0,
            );
            $countryId = $this->fetchCountryData($countryName);
            $countryName = ($countryName == 'ind') ? 'india' : $countryName;
        } else {
            $countryName = $this->choice(
                'select country',
                ['uae', 'ind', 'canada', 'usa', 'uk'],
                0,
            );
            $countryId = $this->fetchCountryData($countryName);
        }

        $data = $arrayData->push([
            'country_id' => $countryId,
            'country_name' => $countryName,
        ]);

        return $data;
    }

    protected function fetchCountryData(string $country_name): int
    {
        $country = Country::where('sortname', $country_name)->first();

        return $country->id;
    }
}
