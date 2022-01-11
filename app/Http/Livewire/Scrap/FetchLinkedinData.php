<?php

namespace App\Http\Livewire\Scrap;

use Goutte\Client;
use App\Models\Scrap;
use App\Models\Country;
use Livewire\Component;
use Illuminate\Support\Str;

class FetchLinkedinData extends Component
{
    public $country = 2;

    public $site_url = 'https://www.linkedin.com/jobs/search?keywords=&location=ind';

    public function updatedCountry()
    {
        if ($this->country) {
            $countryName = Country::findOrFail($this->country);
            $this->site_url = 'https://www.linkedin.com/jobs/search?keywords=&location=' . $countryName->slug;
        }
    }

    public function fetchLinked()
    {
        $validateData = $this->validate([
            'site_url' => ['required', 'url'],
        ]);

        try {
            $client = new Client();

            $url = $validateData['site_url'];

            $crawler = $client->request('GET', $url);
            for ($i = 1; $i < 5; $i++) {
                if ($i != 0) {
                    $crawler = $client->request('GET', $url . '&position=' . $i . '&pageNum=0');
                }
                $crawler->filter('.jobs-search__results-list > li')->each(function ($node) use ($client) {
                    $title = $node->filter('.job-search-card > .base-search-card__info > h3')->text();
                    $company = $node->filter('.job-search-card > .base-search-card__info > h4')->text();
                    $location = $node->filter('.job-search-card > .base-search-card__info > .base-search-card__metadata > span')->text();
                    $dateTime = $node->filter('.job-search-card > .base-search-card__info > .base-search-card__metadata > time')->text();
                    if (Str::contains($dateTime, 'Just now')) {
                        $job_posted = now();
                    } else {
                        $job_posted = $dateTime;
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

                    Scrap::updateOrCreate(
                        ['job_title' => $title],
                        [
                            'job_title' => $title,
                            'country_id' => $this->country, // country id store
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
            }
            return redirect()->route('scrapper.index', ['site' => Scrap::SITE_LINKEDIN])->with('message', 'data successfully imported');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'something went wrong! ' . $th->getMessage());
        }
    }

    public function render()
    {
        $countries = Country::select('id', 'name', 'slug')->get();

        return view('livewire.scrap.fetch-linkedin-data', compact('countries'));
    }
}
