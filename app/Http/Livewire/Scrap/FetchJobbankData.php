<?php

namespace App\Http\Livewire\Scrap;

use Goutte\Client;
use App\Models\Scrap;
use App\Models\Country;
use Livewire\Component;

class FetchJobbankData extends Component
{
    public $country = '';

    public $site_url = 'https://www.jobbank.gc.ca/jobsearch/jobsearch';

    public function fetch()
    {
        $validateData = $this->validate([
            'site_url' => ['required', 'url'],
        ]);

        try {
            $client = new Client();

            $url = $validateData['site_url'];

            $crawler = $client->request('GET', $url);

            for ($i = 0; $i < 2; $i++) {
                if ($i != 0) {
                    $crawler = $client->request('GET', $url . '/?page=' . $i);
                }
                $crawler->filter('article')->each(function ($node) {
                    $titleText = $node->filter('.resultJobItem > .title > .noctitle')->text();
                    $business = $node->filter('.resultJobItem > .list-unstyled > .business')->text();
                    $cityText = $node->filter('.resultJobItem > .list-unstyled > .location')->text();
                    $salary = $node->filter('.resultJobItem > .list-unstyled > .salary')->text();

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

                    Scrap::updateOrCreate(
                        ['job_title' => $title],
                        [
                            'job_title' => $title,
                            'country_id' => $this->country, // country id store
                            'job_short_description' => null,
                            'job_description' => null,
                            'job_company' => $business,
                            'job_state' => $city,
                            'job_type' => null,
                            'job_salary_range' => $salary,
                            'site_name' => Scrap::SITE_JOBBANK,
                        ]
                    );
                });
            }
            return redirect()->route('scrapper.index', ['filter[site_name]' => Scrap::SITE_JOBBANK])->with('message', 'data successfully imported');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'something went wrong! ' . $th->getMessage());
        }
    }

    public function mount()
    {
        try {
            $countries = Country::select('id', 'name', 'slug')->where('name', '=', 'canada')->first();
            $this->country = $countries->id;
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'something went wrong! ' . $th->getMessage());
        }
    }

    public function render()
    {
        $countries = Country::select('id', 'name', 'slug')->where('name', '=', 'canada')->get();

        return view('livewire.scrap.fetch-jobbank-data', compact('countries'));
    }
}
