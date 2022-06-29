<?php

namespace App\Http\Traits;

use Carbon\Carbon;
use Goutte\Client;
use App\Models\Scrap;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait JobSiteTrait
{
    public $title = null;
    public $location = null;
    public $dateTime = null;
    public $company = null;
    public $job_posted = null;
    public $employment_type = null;
    public $seniority_level = null;
    public $job_function = null;
    public $industries = null;

    public function baytJobs($bar = null, int $pages = 50, int $countryId, string $countryName = 'uae')
    {
        $dataCollection = collect();

        if ($countryName == 'sa') {
            $countryName = 'saudi-arabia';
        }

        $url = 'https://www.bayt.com/en/' . $countryName . '/jobs';

        $client = new Client();

        $crawler = $client->request('GET', $url);

        for ($i = 1; $i < $pages; $i++) {
            if ($i != 0) {
                $crawler = $client->request('GET', $url . '/?page=' . $i);
            }

            // for command line progress bar
            if ($bar) {
                $bar->advance();
            }

            $crawler->filter('.has-pointer-d')->each(function ($node) use ($client, $dataCollection, $countryId) {

                $title = $node->filter('h2')->text(); // title

                $job_detail_link = $node->selectLink($title)->link()->getUri();

                if (!empty($node->filter('.t-small p'))) {
                    $job_short_description = $node->filter('.t-small p')->text();
                } else {
                    $job_short_description = null;
                }

                if (!empty($node->filter('p10r'))) {
                    $job_company = explode('-', $node->filter('.p10r')->text())[0];
                    $job_state = explode('-', $node->filter('.p10r')->text())[1];
                } else {
                    $job_company = null;
                    $job_state = null;
                }

                if (($node->filter('div.t-small > ul')->count()) > 0) {
                    $job_type = $node->filter('div.t-small > ul > li')->text();
                } else {
                    $job_type = null;
                }

                $crawler_detail = $client->request('GET', $job_detail_link);

                if ($crawler_detail->filter('.t-left > .list > li')->count() > 0) {
                    $date = $crawler_detail->filter('.t-left > .list > .t-mute')->text();
                    if (Str::contains($date, 'Date Posted:')) {
                        // $job_posted = $crawler_detail->filter('.t-left > .list > .t-mute > span')->text();
                        $date = $crawler_detail->filter('.t-left > .list > .t-mute > span')->text();
                        $job_posted = Carbon::parse($date);
                    }
                } else {
                    $job_posted = null;
                }

                if ($crawler_detail->filter('#job_card > .is-spaced')->count() > 0) {
                    $text = $crawler_detail->filter('#job_card > .is-spaced')->text();
                    if (Str::contains($text, 'Job Description')) {
                        $job_description = $crawler_detail->filter('#job_card > .is-spaced > div')->text();
                    }
                } else {
                    $job_description = $job_short_description;
                }

                // $dataCollection->push(
                //     [
                //         'job_title'             => $title,
                //         'country_id'            => $countryId, // country id store
                //         'job_site_url'          => $job_detail_link,
                //         'job_short_description' => $job_short_description,
                //         'job_description'       => $job_description,
                //         'job_company'           => $job_company,
                //         'job_state'             => $job_state,
                //         'job_type'              => $job_type,
                //         'job_posted'            => $job_posted,
                //         'site_name'             => Scrap::SITE_BAYT,
                //     ]
                // );

                Scrap::updateOrCreate(
                    ['job_title' => $title],
                    [
                        'job_title'             => $title,
                        'country_id'            => $countryId, // country id store
                        'job_site_url'          => $job_detail_link,
                        'job_short_description' => $job_short_description,
                        'job_description'       => $job_description,
                        'job_company'           => $job_company,
                        'job_state'             => $job_state,
                        'job_type'              => $job_type,
                        'job_posted'            => $job_posted,
                        'site_name'             => Scrap::SITE_BAYT,
                    ]
                );
            });

            // $dataCollection->map(function (array $row) {
            //     return Arr::only(
            //         $row,
            //         [
            //             'job_title', 'country_id', 'job_site_url' ,'job_short_description', 'job_description', 'job_company', 'job_state', 'job_type', 'job_posted', 'site_name'
            //         ]
            //     );
            // })->chunk(100)->each(function ($chunk) {
            //     Scrap::upsert($chunk->all(), 
            //     ['job_title', 'country_id', 'job_site_url' ,'job_short_description', 'job_description', 'job_company', 'job_state', 'job_type', 'job_posted', 'site_name'], 
            //     ['job_title', 'country_id', 'job_site_url' ,'job_short_description', 'job_description', 'job_company', 'job_state', 'job_type', 'job_posted', 'site_name']);
            // });
        }
    }

    public function linkedInJobs($bar = null, int $pages = 50, int $countryId, string $countryName = 'uae')
    {
        $dataCollection = collect();

        $url = $this->get_country_wise_linked_url_for_job_search($countryName);

        // $url = 'https://www.linkedin.com/jobs/search?location=' . $countryName . '&geoId=102713980&f_TPR=r86400&position=1&currentJobId=2930582116&pageNum=0';

        $client = new Client();

        $crawler = $client->request('GET', $url);

        for ($i = 1; $i < $pages; $i++) {
            if ($i != 0) {
                $crawler = $client->request('GET', $this->get_country_wise_linked_url_for_job_search($countryName, $i));
            }

            // for command line progress bar

            if ($bar) {
                $bar->advance();
            }

            $crawler->filter('.jobs-search__results-list > li')->each(function ($node) use (
                $client,
                $dataCollection,
                $countryId
            ) {
                $title = $node->filter('.job-search-card > .base-search-card__info > h3')->text();
                $company = $node->filter('.job-search-card > .base-search-card__info > h4')->text();
                $location = $node->filter('.job-search-card > .base-search-card__info > .base-search-card__metadata > span')->text();
                $dateTime = $node->filter('.job-search-card > .base-search-card__info > .base-search-card__metadata > time')->text();
                if (Str::contains($dateTime, 'Just now')) {
                    $job_posted = now();
                } else {
                    $job_posted = Carbon::parse($dateTime);
                }

                $job_detail_link = $node->selectLink($title)->link()->getUri();

                $crawler_detail = $client->request('GET', $job_detail_link);

                if ($crawler_detail->filter('.decorated-job-posting__details > .description')->count() > 0) {
                    $description = $crawler_detail->filter('.decorated-job-posting__details > .description')->text();
                } else {
                    $description = null;
                }

                if (($crawler_detail->filter('.decorated-job-posting__details > .description > .core-section-container__content > .description__job-criteria-list > .description__job-criteria-item')->count()) > 0) {
                    $crawler_detail->filter('.decorated-job-posting__details > .description > .core-section-container__content > .description__job-criteria-list > .description__job-criteria-item')->each(function ($query) {
                        $text = $query->filter('li')->text();
                        if (Str::contains($text, 'Employment type')) {
                            $this->employment_type = Str::remove('Employment type', $text);
                        }

                        if (Str::contains($text, 'Seniority level')) {
                            $this->seniority_level = Str::remove('Seniority level', $text);
                        }

                        if (Str::contains($text, 'Job function')) {
                            $this->job_function = Str::remove('Job function', $text);
                        }

                        if (Str::contains($text, 'Industries')) {
                            $this->industries = Str::remove('Industries', $text);
                        }
                    });
                }

                Scrap::updateOrCreate(
                    ['job_title' => $title],
                    [
                        'job_title'             => $title,
                        'country_id'            => $countryId, // country id store
                        'job_site_url'          => $job_detail_link,
                        'job_short_description' => Str::limit($description, 55),
                        'job_description'       => $description,
                        'job_company'           => $company,
                        'job_state'             => $location,
                        'job_type'              => $this->employment_type,
                        'job_posted'            => $job_posted,
                        'site_name'             => Scrap::SITE_LINKEDIN,
                        'seniority_level'       => $this->seniority_level,
                        'employment_type'       => $this->employment_type,
                        'job_function'          => $this->job_function,
                        'industries'            => $this->industries,
                    ]
                );
            });
        }
    }

    public function jobbankJobs($bar = null, int $pages = 50, int $countryId, string $countryName = 'canada')
    {
        $dataCollection = collect();

        $url = 'https://www.jobbank.gc.ca/jobsearch/jobsearch';

        $client = new Client();

        $crawler = $client->request('GET', $url);

        for ($i = 0; $i < $pages; $i++) {
            if ($i != 0) {
                $crawler = $client->request('GET', $url . '/?page=' . $i);
            }

            // for command line progress bar
            if ($bar) {
                $bar->advance();
            }

            $crawler->filter('article')->each(function ($node) use ($client, $dataCollection, $countryId) {

                $linkUrl = $node->filter('a')->text();

                $titleText = $node->filter('.resultJobItem > .title > .noctitle')->text();
                $date = $node->filter('.resultJobItem > .list-unstyled > .date')->text();
                $business = $node->filter('.resultJobItem > .list-unstyled > .business')->text();
                $cityText = $node->filter('.resultJobItem > .list-unstyled > .location')->text();
                $salary = $node->filter('.resultJobItem > .list-unstyled > .salary')->text();
                $job_type = null;

                $title = str_replace(
                    "Verified This job was posted directly by the employer on Job Bank.",
                    "",
                    $titleText
                );

                $city = str_replace(
                    "Location ",
                    "",
                    $cityText
                );

                if ($date) {
                    $job_posted = Carbon::parse($date);
                } else {
                    $job_posted = null;
                }

                $job_detail_link = $node->selectLink($linkUrl)->link()->getUri();

                $crawler_detail = $client->request('GET', $job_detail_link);

                if ($crawler_detail->filter('.job-posting-details-body')->count() > 0) {
                    if ($crawler_detail->filter('.job-posting-brief > li')->count() > 0) {
                        $employment_type_text = $crawler_detail->filter('.job-posting-brief > li')->eq(2)->text();
                        if (Str::contains($employment_type_text, 'Terms of employment')) {
                            $employment_type = $crawler_detail->filter('.job-posting-brief > li')->eq(2)->filter('.attribute-value')->text();
                            $job_type = $employment_type;
                        }
                    }

                    $description = $crawler_detail->filter('.job-posting-detail-requirements')->text();
                    $short_description = Str::limit($description, 155);
                } else {
                    $description = null;
                    $short_description = null;
                }

                // $dataCollection->push(
                //     [
                //         'job_title' => $title,
                //         'country_id' => $countryId, // country id store
                //         'job_site_url' => $job_detail_link,
                //         'job_short_description' => $short_description,
                //         'job_description' => $description,
                //         'job_company' => $business,
                //         'job_state' => $city,
                //         'job_type' => $job_type,
                //         'job_salary_range' => $salary,
                //         'job_posted' => $job_posted,
                //         'site_name' => Scrap::SITE_JOBBANK,
                //     ]
                // );

                Scrap::updateOrCreate(
                    ['job_title' => $title],
                    [
                        'job_title'             => $title,
                        'country_id'            => $countryId, // country id store
                        'job_site_url'          => $job_detail_link,
                        'job_short_description' => Str::limit($description, 55),
                        'job_description'       => $description,
                        'job_company'           => $business,
                        'job_state'             => $city,
                        'job_type'              => $job_type,
                        'job_salary_range' => $salary,
                        'job_posted'            => $job_posted,
                        'site_name'             => Scrap::SITE_JOBBANK,
                    ]
                );
            });
            // $dataCollection->map(function (array $row) {
            //     return Arr::only(
            //         $row,
            //         [
            //             'job_title', 'country_id', 'job_site_url', 'job_short_description', 'job_description', 'job_company', 'job_state', 'job_type', 'job_posted', 'site_name'
            //         ]
            //     );
            // })->chunk(100)->each(function ($chunk) {
            //     Scrap::upsert($chunk->all(), 'job_title');
            // });
        }
    }

    public function linked_fetch_job_using_api($bar = null, int $pages = 50, int $countryId, string $countryName = 'uae', string $keyword_value = null)
    {
        $dataCollection = collect();

        $url = $this->get_country_wise_linked_url_for_job_search($countryName, 0, $keyword_value);

        $client = new Client();
        $crawler = $client->request('GET', $url);

        for ($i = 0; $i <= $pages; $i++) {
            if ($i != 0) {
                $updatedUrl = $this->get_country_wise_linked_url_for_job_search($countryName, $i, $keyword_value);
                $crawler = $client->request('GET', $updatedUrl);
            }

            // for command line progress bar
            if ($bar) {
                $bar->advance();
            }

            $crawler->filter('li')->each(function ($node) use (
                $client,
                $dataCollection,
                $countryId,
                $keyword_value
            ) {

                $this->title = $node->filter('.job-search-card > .base-search-card__info > h3')->text();
                $this->company = $node->filter('.job-search-card > .base-search-card__info > h4')->text();
                $this->location = $node->filter('.job-search-card > .base-search-card__info > .base-search-card__metadata > span')->text();
                $this->dateTime = $node->filter('.job-search-card > .base-search-card__info > .base-search-card__metadata > time')->text();

                if (Str::contains($this->dateTime, 'Just now')) {
                    $this->job_posted = now();
                } else {
                    $this->job_posted = Carbon::parse($this->dateTime);
                }

                // get url for detail page
                $job_detail_link = $node->selectLink($this->title)->link()->getUri();
                // fetch detail url
                $crawler_detail = $client->request('GET', $job_detail_link);
                // get details
                if ($crawler_detail->filter('.decorated-job-posting__details > .description')->count() > 0) {
                    $description = $crawler_detail->filter('.decorated-job-posting__details > .description')->text();
                } else {
                    $description = null;
                }
                if (($crawler_detail->filter('.decorated-job-posting__details > .description > .core-section-container__content > .description__job-criteria-list > .description__job-criteria-item')->count()) > 0) {
                    $crawler_detail->filter('.decorated-job-posting__details > .description > .core-section-container__content > .description__job-criteria-list > .description__job-criteria-item')->each(function ($query) {
                        $text = $query->filter('li')->text();
                        if (Str::contains($text, 'Employment type')) {
                            $this->employment_type = Str::remove('Employment type', $text);
                        }

                        if (Str::contains($text, 'Seniority level')) {
                            $this->seniority_level = Str::remove('Seniority level', $text);
                        }

                        if (Str::contains($text, 'Job function')) {
                            $this->job_function = Str::remove('Job function', $text);
                        }

                        if (Str::contains($text, 'Industries')) {
                            $this->industries = Str::remove('Industries', $text);
                        }
                    });
                }

                Scrap::updateOrCreate(
                    ['job_title' => $this->title],
                    [
                        'job_title'             => $this->title,
                        'country_id'            => $countryId, // country id store
                        'job_site_url'          => $job_detail_link,
                        'job_short_description' => Str::limit($description, 55),
                        'job_description'       => $description,
                        'job_company'           => $this->company,
                        'job_state'             => $this->location,
                        'job_type'              => $this->employment_type,
                        'job_posted'            => $this->job_posted,
                        'site_name'             => Scrap::SITE_LINKEDIN,
                        'seniority_level'       => $this->seniority_level,
                        'employment_type'       => $this->employment_type,
                        'job_function'          => $this->job_function,
                        'industries'            => $this->industries,
                        'search_text'           => $keyword_value
                    ]
                );
            });
        }
    }

    protected function indeed_jobs($bar = null, int $pages = 2, int $countryId, string $countryName = 'usa', $cityName = "New York, NY", $keyword = null)
    {
        if ($keyword == "") {
            $keyword = null;
        }

        $url = $this->indeed_country_url($countryName, $cityName, $keyword);

        $client = new Client();

        $crawler = $client->request('GET', $url);
        for ($i = 0; $i < $pages; $i++) {
            if ($i != 0) {
                $crawler = $client->request('GET', $this->indeed_country_url($countryName, $cityName, $keyword, $i * 10));
            }
            // for command line progress bar
            if ($bar) {
                $bar->advance();
            }
            $crawler->filter('#mosaic-provider-jobcards > .sponTapItem')->each(function ($node) use ($client, $countryId) {

                $linkUrl = $node->filter('a')->text();
                $this->title = $node->filter('.jobTitle > span')->text();
                $this->company = $node->filter('.company_location > .companyName')->text();
                $this->location = $node->filter('.companyLocation')->text();
                
                if ($node->filter('.salaryOnly > .metadata')->count() > 0) {
                    $node->filter('.salaryOnly > .metadata > .attribute_snippet')->each(function($node) {
                        if (Str::contains('Job type', $node->children()->attr('aria-label'))) {
                            $this->employment_type = $node->text(); 
                        }
                    });
                }

                // get date
                $jobposted = $node->filter('.tapItem-gutter > .date')->text();
                $date = Str::substr($jobposted, 6);

                // convert Just posted string to current date
                if (Str::contains($date, 'Just posted') OR Str::contains($date, 'Ongoing')) {
                    $this->dateTime = now();
                } else {
                    $this->dateTime = Carbon::parse($date);
                }


                $job_detail_link = $node->selectLink($linkUrl)->link()->getUri();
                
                // job view page access
                $crawler_detail = $client->request('GET', $job_detail_link);
                if ($crawler_detail->filter('#jobDescriptionText')->count() > 0) {

                    // job description
                    $description = $crawler_detail->filter('#jobDescriptionText')->text();

                    // $stripHtml = strip_tags($crawler_detail->filter('#jobDescriptionText')->html(), '<p><ul><li><b><h1><h2><h3><h4><h5><h6>');
                    // $removeNewLine = preg_replace("(\n)", "", $stripHtml);

                    // $short_description = strip_tags(Str::limit($des1, 155));
                    // $description = trim($removeNewLine);
                } else {
                    $description = null;
                    $short_description = null;
                }
                
                Scrap::updateOrCreate(
                    ['job_title' => $this->title, 'job_state' => $this->location],
                    [
                        'job_title'             => $this->title,
                        'job_company'           => $this->company,
                        'country_id'            => $countryId, // country id store
                        'job_site_url'          => $job_detail_link,
                        'job_short_description' => Str::limit($description, 155),
                        'job_description'       => $description,
                        'job_state'             => $this->location,
                        'job_posted'            => $this->dateTime,
                        'job_type'              => $this->employment_type,
                        'site_name'             => Scrap::SITE_INDEED,
                    ]
                );
            });
        }
    }

    protected function indeed_country_url(string $countryName, string $location, string $keyword = null, $start = 0)
    {
        switch ($countryName) {
            case 'ind':
                return "https://in.indeed.com/jobs?q=$keyword&l=$location&fromage=1&start=$start";
                break;

            default:
                return "https://www.indeed.com/jobs?q=$keyword&l=$location&fromage=1&start=$start";
                break;
        }
    }

    /**
     * return url for each country
     *
     * @param string $countryName
     * @param integer $position
     * @param integer $pageNum
     * @return string
     */
    protected function get_country_wise_linked_url_for_job_search(string $countryName = 'usa', $start = 0, $keyword = null)
    {
        switch ($countryName) {
            case 'canada':
                return 'https://www.linkedin.com/jobs-guest/jobs/api/seeMoreJobPostings/search?keywords=' . $keyword . '&location=Canada&f_TPR=r86400&position=1&pageNum=0&start=' . $start * 25;
                break;

            case 'ind':
                return 'https://www.linkedin.com/jobs-guest/jobs/api/seeMoreJobPostings/search?keywords=' . $keyword . '&location=India&f_TPR=r86400&position=1&pageNum=0&start=' . $start * 25;
                break;

            case 'usa':
                return 'https://www.linkedin.com/jobs-guest/jobs/api/seeMoreJobPostings/search?keywords=' . $keyword . '&location=United%20States&f_TPR=r86400&position=1&pageNum=0&start=' . $start * 25;
                break;

            case 'uk':
                return 'https://www.linkedin.com/jobs-guest/jobs/api/seeMoreJobPostings/search?keywords=' . $keyword . '&location=United%20Kingdom&f_TPR=r86400&position=1&pageNum=0&start=' . $start * 25;
                break;

            case 'uae':
                return 'https://www.linkedin.com/jobs-guest/jobs/api/seeMoreJobPostings/search?keywords=' . $keyword . '&location=United%20Arab%20Emirates&f_TPR=r86400&position=1&pageNum=0&start=' . $start * 25;
                break;

            case 'sa':
                return 'https://www.linkedin.com/jobs-guest/jobs/api/seeMoreJobPostings/search?keywords=' . $keyword . '&location=Saudi+Arabia&f_TPR=r86400&position=1&pageNum=0&start=' . $start * 25;
                break;

            case 'liberia':
                // below for all jobs
                return 'https://www.linkedin.com/jobs-guest/jobs/api/seeMoreJobPostings/search?keywords=' . $keyword . '&location=Liberia&position=1&pageNum=0&start=' . $start * 25;
                
                // below for latest jobs
                // return 'https://www.linkedin.com/jobs-guest/jobs/api/seeMoreJobPostings/search?keywords=' . $keyword . '&location=Liberia&f_TPR=r86400&position=1&pageNum=0&start=' . $start * 25;
                break;
        }
    }
}
