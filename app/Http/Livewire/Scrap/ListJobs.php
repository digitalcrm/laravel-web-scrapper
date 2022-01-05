<?php

namespace App\Http\Livewire\Scrap;

use App\Models\Scrap;
use Livewire\Component;

class ListJobs extends Component
{
    public function render()
    {
        $scrapper = Scrap::latest()->paginate(Scrap::PAGINATE_VALUE);

        return view('livewire.scrap.list-jobs', compact('scrapper'));
    }
}
