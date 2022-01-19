<?php

namespace App\Http\Livewire\Scrap;

use Goutte\Client;
use App\Models\Scrap;
use App\Models\Country;
use Livewire\Component;
use Illuminate\Support\Str;

class FetchData extends Component
{
    public $country = 1;

    public $site_url = 'https://www.bayt.com/en/uae/jobs';

    public function updatedCountry()
    {
        if ($this->country) {
            $countryName = Country::findOrFail($this->country);
            $this->site_url = 'https://www.bayt.com/en/'.$countryName->slug.'/jobs/';
        }
    }

    public function fetch()
    {
        $validateData = $this->validate([
            'site_url' => ['required', 'url'],
        ]);

        try {
            $client = new Client();

            $url = $validateData['site_url'];

            $crawler = $client->request('GET', $url);

            $pages = ($crawler->filter('#sectionPagination ul li')->count() > 0)
                ? $crawler->filter('#sectionPagination #pagination li:nth-last-child(2)')->text()
                : 0;
            for ($i = 1; $i < 5; $i++) {
                if ($i != 0) {
                    $crawler = $client->request('GET', $url . '/?page=' . $i);
                }
                $crawler->filter('.has-pointer-d')->each(function ($node) use($client) {

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
                            $job_posted = $crawler_detail->filter('.t-left > .list > .t-mute > span')->text();
                        }
                    } else {
                        $job_posted = null;
                    }
                    
                    if ($crawler_detail->filter('#job_card > .is-spaced')->count() > 0) {
                        $text = $crawler_detail->filter('#job_card > .is-spaced')->text();
                        if(Str::contains($text, 'Job Description')){
                            $job_description = $crawler_detail->filter('#job_card > .is-spaced > div')->text();
                        }
                    } else {
                        $job_description = $job_short_description;
                    }

                    Scrap::updateOrCreate(
                        ['job_title' => $title],
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
                });
            }
            return redirect()->route('scrapper.index')->with('message', 'data successfully imported');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'something went wrong! ' . $th->getMessage());
        }
    }

    public function render()
    {
        $countries = Country::select('id', 'name', 'slug')->get();
        
        return view('livewire.scrap.fetch-data', compact('countries'));
    }
}
