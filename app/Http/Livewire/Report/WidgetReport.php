<?php

namespace App\Http\Livewire\Report;

use App\Models\Scrap;
use Livewire\Component;

class WidgetReport extends Component
{
    public $totalJobs;
    public $baytJobs;

    protected function countTotalJobsOf(string $value = null)
    {
        switch ($value) {
            case Scrap::SITE_BAYT:
                $jobs = Scrap::where('site_name', $value)->count();
                return $jobs;
                break;

            case Scrap::SITE_LINKEDIN:
                $jobs = Scrap::where('site_name', $value)->count();
                return $jobs;
                break;

            case Scrap::SITE_JOBBANK:
                $jobs = Scrap::where('site_name', $value)->count();
                return $jobs;
                break;

            default:
                $jobs = Scrap::count();
                return $jobs;
                break;
        }
    }

    public function render()
    {
        $this->totalJobs = $this->countTotalJobsOf();
        $this->baytJobs = $this->countTotalJobsOf(Scrap::SITE_BAYT);
        $this->linkedinJobs = $this->countTotalJobsOf(Scrap::SITE_LINKEDIN);
        $this->jobbankJobs = $this->countTotalJobsOf(Scrap::SITE_JOBBANK);

        return view('livewire.report.widget-report');
    }
}
