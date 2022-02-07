<?php

namespace App\Http\Livewire\Scrap;

use App\Models\Scrap;
use Livewire\Component;
use App\Exports\JobExport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Livewire\WithPagination;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ListJobs extends Component
{
    use WithPagination;

    public $site_name = null;
    public $country_name = null;

    protected $paginationTheme = 'bootstrap';

    public function exportJobs(string $value = null)
    {
        return (new JobExport($value))->download('jobs.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function mount()
    {
        $filter = request()->query('filter');
        if ($filter && Arr::exists($filter, 'site_name') && Arr::exists($filter, 'country.sortname')) {
            $this->site_name = $filter['site_name'];
            $this->country_name = $filter['country.sortname'];
        }
    }

    public function render()
    {
        // $scrapper = Scrap::query()
        //     ->whereHas('country', function (Builder $query) {
        //         $query->where('sortname', $this->country_name);
        //     })
        //     ->where('site_name', $this->site_name)
        //     ->latest()
        //     ->paginate(Scrap::PAGINATE_VALUE);

        if ($this->site_name && $this->country_name) {
            $scrapper = QueryBuilder::for(Scrap::class)
                ->allowedFilters(['job_title', 'site_name', 'job_company', 'job_state', 'country_id', 'job_type', AllowedFilter::partial('country.sortname')])
                ->allowedIncludes(['country'])
                ->whereHas('country', function (Builder $query) {
                    $query->where('sortname', $this->country_name);
                })
                ->where('site_name', $this->site_name)
                ->latest('job_posted')
                ->paginate(5)
                ->appends(request()->query())
                ->withQueryString();

            return view('livewire.scrap.list-jobs', compact('scrapper'));
        }
    }
}
