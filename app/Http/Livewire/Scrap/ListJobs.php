<?php

namespace App\Http\Livewire\Scrap;

use App\Models\Scrap;
use Livewire\Component;
use App\Exports\JobExport;
use Illuminate\Support\Arr;
use Livewire\WithPagination;
use Spatie\QueryBuilder\QueryBuilder;

class ListJobs extends Component
{
    use WithPagination;

    public $queryType = null;

    protected $paginationTheme = 'bootstrap';

    // public $filter;

    // protected $rules = [
    //     'filter.job_title' => 'nullable|string|max:55',
    //     'filter.job_state' => 'nullable|string|max:55',
    // ];

    // protected $messages = [
    //     'formFields.job_title.required' => 'The name field is required',
    //     'formFields.job_state.required' => 'The city field cannot be empty.',
    // ];

    public function exportJobs($value = null)
    {
        return (new JobExport($value))->download('jobs.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    // public function submitFilter()
    // {
    //     $validatedData = $this->validate();
        
    //     if ($validatedData) {
    //         $url = route('scrapper.index', ['filter[site_name]' => $validatedData['filter']['job_title']]);

    //         return redirect()->route('search.list', $validatedData);
    //     }
    // }

    public function mount()
    {
        $filter = request()->query('filter');
        if ($filter && Arr::exists($filter, 'site_name')) {
            $this->queryType = $filter['site_name'];
        } else {
            $this->queryType = Scrap::SITE_BAYT;
        }
    }

    public function render()
    {
        // $scrapper = Scrap::where('site_name', $this->queryType)
        //     ->whereNotNull('job_short_description')
        //     ->whereNotNull('job_description')
        //     ->latest()
        //     ->paginate(Scrap::PAGINATE_VALUE)
        //     ->withQueryString();

        $scrapper = QueryBuilder::for(Scrap::class)
            ->allowedFilters(['job_title', 'site_name', 'job_company', 'job_state', 'country_id', 'job_type'])
            ->latest()
            ->paginate(Scrap::PAGINATE_VALUE)
            ->appends(request()->query())
            ->withQueryString();

        return view('livewire.scrap.list-jobs', compact('scrapper'));
    }
}
