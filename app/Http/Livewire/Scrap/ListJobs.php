<?php

namespace App\Http\Livewire\Scrap;

use App\Exports\JobExport;
use App\Models\Scrap;
use Livewire\Component;
use Livewire\WithPagination;

class ListJobs extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function exportJobs($value = null)
    {
        return (new JobExport($value))->download('jobs.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function render()
    {
        if (request('site') == 'jobbank') {
            $scrapper = Scrap::where('country_id', 3)->latest()->paginate(Scrap::PAGINATE_VALUE)->WithQueryString();
        } else {
            $scrapper = Scrap::where('country_id', '!=' ,3)->latest()->paginate(Scrap::PAGINATE_VALUE)->WithQueryString();
        }

        return view('livewire.scrap.list-jobs', compact('scrapper'));
    }
}
