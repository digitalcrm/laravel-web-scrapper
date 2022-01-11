<?php

namespace App\Http\Livewire\Scrap;

use App\Exports\JobExport;
use App\Models\Scrap;
use Livewire\Component;
use Livewire\WithPagination;

class ListJobs extends Component
{
    use WithPagination;

    public $queryType = null;

    protected $paginationTheme = 'bootstrap';

    public function exportJobs($value = null)
    {
        return (new JobExport($value))->download('jobs.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function mount()
    {
        if (request('site')) {
            $this->queryType = request('site');
        } else {
            $this->queryType = Scrap::SITE_BAYT;
        }
    }

    public function render()
    {
        $scrapper = Scrap::where('site_name', $this->queryType)->latest()->paginate(Scrap::PAGINATE_VALUE)->withQueryString();

        return view('livewire.scrap.list-jobs', compact('scrapper'));
    }
}
