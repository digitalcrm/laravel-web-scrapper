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

    public function exportJobs(string $value = null)
    {
        return (new JobExport($value))->download('jobs.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

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
            ->latest('job_posted')
            ->paginate(Scrap::PAGINATE_VALUE)
            ->appends(request()->query())
            ->withQueryString();

        return view('livewire.scrap.list-jobs', compact('scrapper'));
    }
}
