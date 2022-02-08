<?php

namespace App\Http\Livewire\Scrap;

use App\Models\Scrap;
use App\Models\Country;
use Livewire\Component;
use App\Imports\JobsImport;
use Livewire\WithFileUploads;

class ImportJob extends Component
{
    use WithFileUploads;

    public $site_name = Scrap::SITE_BAYT;
    public $file;
    public $country;
    public $sites = [Scrap::SITE_BAYT, Scrap::SITE_LINKEDIN, Scrap::SITE_JOBBANK];

    private $country_name;

    public function updatedCountry()
    {
        $data = Country::findOrFail($this->country);
        if ($data) {
            $this->country_name = $data->sortname;
        }
    }

    public function importSiteJob()
    {
        $validatedData = $this->validate([
            'country' => 'required|exists:countries,id',
            'site_name' => 'required|in:linkedin,bayt,jobbank',
            'file' => 'required|file|mimes:xls,csv,txt|max:1024'
        ]);
        try {
            if ($this->file) {
                $importJob = new JobsImport($this->country, $this->site_name);

                $importJob->import($this->file);

                if ($importJob->failures()->isNotEmpty()) {
                    return redirect()->route('scrapper.index')->with('error', $importJob->failures());
                }

                return redirect()->route('scrapper.index', [
                    'filter[site_name]' => $validatedData['site_name'],
                    'filter[country.sortname]' => $validatedData['country'],
                ])->with('message', 'Successfully Imported');
            }
        } catch (\Throwable $e) {
            return redirect()->route('scrapper.import')->with('error', 'error ' . $e->getMessage() . ' In your csv file add those headings => job_title, job_city, job_company, job_short_description, job_description, job_type');
        }
    }

    public function render()
    {
        $countries = Country::select('id', 'name', 'slug')->get();

        return view('livewire.scrap.import-job', compact('countries'));
    }
}
