<?php

namespace App\Http\Livewire\Scrap;

use Goutte\Client;
use App\Models\Scrap;
use App\Models\Country;
use Livewire\Component;

class FetchData extends Component
{
    public $country = 1;

    public $site_url = 'https://www.bayt.com/en/uae/jobs';
    
    private $results = [
        'job_title',
        'job_description',
        'job_company',
        'job_state',
        'job_type',
        // 'job_salary_range',
    ];

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
            for ($i = 0; $i < 5; $i++) {
                if ($i != 0) {
                    $crawler = $client->request('GET', $url . '/?page=' . $i);
                }
                $crawler->filter('.has-pointer-d')->each(function ($node) {

                    $this->results[0] = $node->filter('h2')->text(); // title

                    if (!empty($node->filter('.t-small p'))) {
                        $this->results[1] = $node->filter('.t-small p')->text();
                    } else {
                        $this->results[1] = null;
                    }

                    if (!empty($node->filter('p10r'))) {
                        $this->results[2] = explode('-', $node->filter('.p10r')->text())[0];
                        $this->results[3] = explode('-', $node->filter('.p10r')->text())[1];
                    } else {
                        $this->results[2] = null;
                        $this->results[3] = null;
                    }

                    if (($node->filter('div.t-small > ul')->count()) > 0) {
                        $this->results[4] = $node->filter('div.t-small > ul > li')->text();
                    } else {
                        $this->results[4] = null;
                        // $this->results[5] = null;
                    }

                    Scrap::updateOrCreate(
                        ['job_title' => $this->results[0]],
                        [
                            'job_title' => $this->results[0],
                            'country_id' => $this->country, // country id store
                            'job_short_description' => $this->results[1],
                            'job_description' => $this->results[1],
                            'job_company' => $this->results[2],
                            'job_state' => $this->results[3],
                            'job_type' => $this->results[4],
                            'site_name' => Scrap::SITE_BAYT,
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
