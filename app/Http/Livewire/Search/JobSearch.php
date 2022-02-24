<?php

namespace App\Http\Livewire\Search;

use App\Models\Country;
use Livewire\Component;
use Illuminate\Support\Arr;

class JobSearch extends Component
{
    public $filter;

    protected $rules = [
        'filter.job_title'      => 'nullable|string|max:255',
        'filter.job_state'      => 'nullable|string|max:100',
        'filter.job_function'   => 'nullable|string|max:255',
        'filter.industries'     => 'nullable|string|max:255',
        'filter.job_type'       => 'nullable|string|max:100',
        'filter.job_company'    => 'nullable|string|max:100',
        'filter.country_id'     => 'nullable|exists:countries,id',
    ];

    protected $messages = [
        'filter.*.max' => 'The input field must not be greater than :max characters.',
    ];

    public function applyFilter()
    {
        $validatedData = $this->validate();
        
        if ($validatedData) {
            return redirect()->route('search.list', Arr::query($validatedData));
        }
    }

    public function render()
    {
        $countries = Country::select('id', 'name', 'slug')->get();

        return view('livewire.search.job-search', compact('countries'));
    }
}
