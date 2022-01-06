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

    public function exportJobs()
    {
        return (new JobExport)->download('jobs.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function render()
    {
        $scrapper = Scrap::latest()->paginate(Scrap::PAGINATE_VALUE);

        return view('livewire.scrap.list-jobs', compact('scrapper'));
    }
}
