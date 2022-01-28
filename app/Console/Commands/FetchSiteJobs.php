<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Goutte\Client;
use App\Models\Scrap;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class FetchSiteJobs extends Command
{
    public $country = 1;

    public $site_url = 'https://www.bayt.com/en/uae/jobs';
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
        $bar = $this->output->createProgressBar(5);

        $bar->start();

        $this->baytJobs($bar);

        $bar->finish();


        $this->info('Job Fetched Successfully');
    }

    protected function baytJobs($bar)
    {
        $dataCollection = collect();

        $client = new Client();

        $url = $this->site_url;

        $crawler = $client->request('GET', $url);

        for ($i = 1; $i < 5; $i++) {
            if ($i != 0) {
                $crawler = $client->request('GET', $url . '/?page=' . $i);
            }

            $bar->advance();

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
                return Arr::only($row, [
                    'job_title',
                    'country_id',
                    'job_short_description',
                    'job_description',
                    'job_company',
                    'job_state',
                    'job_type',
                    'job_posted',
                    'site_name'
                ]);
            })
                ->chunk(100)
                ->each(function ($chunk) {
                    Scrap::upsert($chunk->all(), 'job_title');
                });
        }
    }
}
