<?php

namespace App\Http\Traits;

use Carbon\Carbon;
use Goutte\Client;
use App\Models\Scrap;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait JobSiteTrait
{
    public $bayt_url = 'https://www.bayt.com/en/uae/jobs';
    public $linkedin_url = 'https://www.linkedin.com/jobs/search?keywords=&location=ind';
    public $jobbank_url = 'https://www.jobbank.gc.ca/jobsearch/jobsearch';

    public $country = 1;

    public function baytJobs($bar = null, int $pages = 50)
    {
        $dataCollection = collect();

        $url = $this->bayt_url;

        $client = new Client();

        $crawler = $client->request('GET', $url);

        for ($i = 1; $i < $pages; $i++) {
            if ($i != 0) {
                $crawler = $client->request('GET', $url . '/?page=' . $i);
            }

            // for command line progress bar
            $bar->advance();
            if ($bar) {
            }

            $crawler->filter('.has-pointer-d')->each(function ($node) use ($client, $dataCollection) {

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

                $dataCollection->push(
                    [
                        'job_title'             => $title,
                        'country_id'            => $this->country, // country id store
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

                // Scrap::updateOrCreate(
                //     ['job_title' => $title],
                //     [
                //         'job_title'             => $title,
                //         'country_id'            => $this->country, // country id store
                //         'job_short_description' => $job_short_description,
                //         'job_description'       => $job_description,
                //         'job_company'           => $job_company,
                //         'job_state'             => $job_state,
                //         'job_type'              => $job_type,
                //         'job_posted'            => $job_posted,
                //         'site_name'             => Scrap::SITE_BAYT,
                //     ]
                // );
            });
            $dataCollection->map(function (array $row) {
                return Arr::only(
                    $row,
                    [
                        'job_title', 'country_id', 'job_site_url' ,'job_short_description', 'job_description', 'job_company', 'job_state', 'job_type', 'job_posted', 'site_name'
                    ]
                );
            })->chunk(100)->each(function ($chunk) {
                Scrap::upsert($chunk->all(), 'job_title');
            });
        }
    }

    public function linkedInJobs($bar = null, int $pages = 50)
    {
        $dataCollection = collect();

        $url = $this->linkedin_url;

        $client = new Client();

        $crawler = $client->request('GET', $url);
        for ($i = 1; $i < $pages; $i++) {
            if ($i != 0) {
                $crawler = $client->request('GET', $url . '&position=' . $i . '&pageNum=0');
            }

            // for command line progress bar

            if ($bar) {
                $bar->advance();
            }

            $crawler->filter('.jobs-search__results-list > li')->each(function ($node) use ($client, $dataCollection) {
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
                    $employment_type = $crawler_detail->filter('.decorated-job-posting__details > .description > .core-section-container__content > .description__job-criteria-list > li')->eq(0)->text();
                    if (Str::contains($employment_type, 'Employment type')) {
                        $job_type = Str::remove('Employment type', $employment_type);
                    } else {
                        $job_type = null;
                    }
                } else {
                    $job_type = null;
                }

                $dataCollection->push(
                    [
                        'job_title' => $title,
                        'country_id' => $this->country, // country id store
                        'job_site_url' => $job_detail_link,
                        'job_short_description' => Str::limit($description, 55),
                        'job_description' => $description,
                        'job_company' => $company,
                        'job_state' => $location,
                        'job_type' => $job_type,
                        'job_posted' => $job_posted,
                        'site_name' => Scrap::SITE_LINKEDIN
                    ]
                );
            });
            $dataCollection->map(function (array $row) {
                return Arr::only(
                    $row,
                    [
                        'job_title', 'country_id', 'job_site_url' ,'job_short_description', 'job_description', 'job_company', 'job_state', 'job_type', 'job_posted', 'site_name'
                    ]
                );
            })->chunk(100)->each(function ($chunk) {
                Scrap::upsert($chunk->all(), 'job_title');
            });
        }
    }

    public function jobbankJobs($bar = null, int $pages = 50)
    {
        $dataCollection = collect();

        $url = $this->jobbank_url;

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

            $crawler->filter('article')->each(function ($node) use ($client, $dataCollection) {
                
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
                    if ($crawler_detail->filter('.job-posting-brief > li')->count() > 0){
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

                $dataCollection->push(
                    [
                        'job_title' => $title,
                        'country_id' => $this->country, // country id store
                        'job_site_url' => $job_detail_link,
                        'job_short_description' => $short_description,
                        'job_description' => $description,
                        'job_company' => $business,
                        'job_state' => $city,
                        'job_type' => $job_type,
                        'job_salary_range' => $salary,
                        'job_posted' => $job_posted,
                        'site_name' => Scrap::SITE_JOBBANK,
                    ]
                );
            });
            $dataCollection->map(function (array $row) {
                return Arr::only(
                    $row,
                    [
                        'job_title', 'country_id', 'job_site_url' ,'job_short_description', 'job_description', 'job_company', 'job_state', 'job_type', 'job_posted', 'site_name'
                    ]
                );
            })->chunk(100)->each(function ($chunk) {
                Scrap::upsert($chunk->all(), 'job_title');
            });
        }
    }

}
