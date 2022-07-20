<?php

namespace App\Console\Commands;

use App\Models\Country;
use Illuminate\Console\Command;
use App\Http\Traits\JobSiteTrait;
use Illuminate\Support\Facades\Log;

class FetchSiteJobs extends Command
{
    use JobSiteTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:wrapping {country?} {keyword_value?} {city_for_indeed?}
                            {--bayt} 
                            {--jobbank} 
                            {--indeed} 
                            {--linkedin}
                            {--gov-uk}
                            {--people}';

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
        $total_no_of_page = 50;

        if ($this->argument('country')) {
            $countryName = $this->argument('country');
            $countryId = $this->fetchCountryData($countryName);

            if ($countryId) {
                // fetch indeed jobs required fields are city name and option indeed
                if ($this->argument('city_for_indeed') && $this->option('indeed')) {
                    $this->indeed_jobs('', $total_no_of_page, $countryId, $countryName, $this->argument('city_for_indeed'), $this->argument('keyword_value'));
                }

                // fetch linkedin jobs required fields keyword and option linkdedin
                if ($this->option('linkedin')) {
                    $this->linked_fetch_job_using_api('', $total_no_of_page, $countryId, $countryName, $this->argument('keyword_value'));
                }

                // fetch bayt jobs
                if ($this->option('bayt')) {
                    $this->baytJobs('', $total_no_of_page, $countryId, $countryName);
                }

                // fetch jobbank jobs
                if ($this->option('jobbank') && ($this->argument('country') == 'canada')) {
                    $this->jobbankJobs('', $total_no_of_page, $countryId, $countryName);
                }

                // fetch job of gov.uk https://www.findapprenticeship.service.gov.uk/
                if ($this->option('gov-uk')) {
                    $this->job_list_for_gov_uk('', $total_no_of_page, $countryId, $countryName, $this->argument('keyword_value'));
                }

            } else {
                // if country id not found
                Log::error('country id not found');
                $this->error('something went wrong. check your log file');
            }
        }

        // if no arguments and options provided
        if (!($this->argument('country'))) {
            $this->fetch_job_based_on_choices();
        }
    }

    /**
     * fetch job based on command
     *
     */
    protected function fetch_job_based_on_choices()
    {
        $siteName = $this->choice(
            'Which sites jobs do you want to fetch?',
            ['bayt', 'linkedin', 'jobbank'],
            0,
        );

        $pages = $this->ask('How many pages do you want to scroll? [10, 20, 50 etc...]');

        $countryData = $this->get_selected_country_id_and_name($siteName)->first();

        if ($this->confirm('Do you wish to continue? [site: ' . $siteName . ', country: ' . $countryData['country_name'] . ' and pages: ' . $pages . ']', true)) {
            $bar = $this->output->createProgressBar($pages);

            $bar->start();

            switch ($siteName) {
                case 'bayt':
                    $this->baytJobs($bar, $pages, $countryData['country_id'], $countryData['country_name']);
                    break;
                case 'linkedin':
                    $this->linked_fetch_job_using_api($bar, $pages, $countryData['country_id'], $countryData['country_name']);
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
                ['uae', 'ind', 'canada', 'usa', 'uk', 'sa'],
                0,
            );
            $countryId = $this->fetchCountryData($countryName);
            $countryName = ($countryName == 'ind') ? 'india' : $countryName;
        } else {
            $countryName = $this->choice(
                'select country',
                ['uae', 'ind', 'canada', 'usa', 'uk', 'sa'],
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

        if ($country) {
            return $country->id;
        } else {
            return false;
        }
    }

}
