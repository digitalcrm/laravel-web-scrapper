<?php

namespace App\Http\Livewire\Search;

use App\Models\Scrap;
use App\Models\Country;
use Livewire\Component;
use App\Models\JobFunction;
use App\Models\JobIndustry;
use Illuminate\Support\Arr;

class JobSearch extends Component
{
    public $filter;
    public $isRequest;
    
    protected $rules = [
        'filter.job_title'      => 'nullable|string|max:255',
        'filter.job_state'      => 'nullable|string|max:100',
        'filter.job_function'   => 'nullable|string|max:255',
        'filter.industries'     => 'nullable|string|max:255',
        'filter.job_type'       => 'nullable|string|max:100',
        'filter.job_company'    => 'nullable|string|max:100',
        'filter.country_id'     => 'nullable|exists:countries,id',
        'filter.site_name'      => 'nullable|in:linkedin,bayt,jobbank',
    ];


    protected $messages = [
        'filter.*.max' => 'The input field must not be greater than :max characters.',
    ];

    // public function updatedFilter()
    // {
    //     if(Arr::exists($this->filter, 'job_title')) {
    //         $this->filter['search_text'] = $this->filter['job_title'];
    //     }
    // }

    public function mount()
    {
        if (request('by') == 'keyword') {
            $this->isRequest = true;
        } else {
            $this->isRequest = false;
        }
    }

    public function applyFilter()
    {
        $validatedData = $this->validate();

        if ($validatedData) {
            return redirect()->route('search.list', Arr::query($validatedData));
        }
    }

    public function search_job_by_keyword()
    {
        $validatedData = $this->validate([
            'filter.search_text'    => 'required|string',
        ],[
            'filter.*.required' => 'The keyword field is required',
        ]);

        if ($validatedData) {
            return redirect()->route('search.list', Arr::query($validatedData));
        }
    }

    public function render()
    {
        $countries = Country::select('id', 'name', 'slug')->get();
        $job_function = JobFunction::select('id', 'name')->get();
        $job_industry = JobIndustry::select('id', 'name')->get();
        $sites = Scrap::site_names();

        return view('livewire.search.job-search', compact('countries', 'job_function', 'job_industry', 'sites'));
    }
}
