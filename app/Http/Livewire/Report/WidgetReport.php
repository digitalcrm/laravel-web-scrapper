<?php

namespace App\Http\Livewire\Report;

use App\Models\Scrap;
use Livewire\Component;
use Illuminate\Support\Carbon;

class WidgetReport extends Component
{
    public $totalJobs;
    public $baytJobs;

    public $date_type = '';

    protected function countTotalJobsOf(string $value = null)
    {
        switch ($value) {
            case Scrap::SITE_BAYT:
                $jobs = Scrap::where('site_name', $value)->dateType($this->date_type)->count();
                return $jobs;
                break;

            case Scrap::SITE_LINKEDIN:
                $jobs = Scrap::where('site_name', $value)->dateType($this->date_type)->count();
                return $jobs;
                break;

            case Scrap::SITE_JOBBANK:
                $jobs = Scrap::where('site_name', $value)->dateType($this->date_type)->count();
                return $jobs;
                break;

            default:
                $jobs = Scrap::count();
                return $jobs;
                break;
        }
    }

    protected function job_filter_based_on_date()
    {
    }

    public function render()
    {
        // $this->totalJobs = $this->countTotalJobsOf();
        // $this->baytJobs = $this->countTotalJobsOf(Scrap::SITE_BAYT);
        // $this->linkedinJobs = $this->countTotalJobsOf(Scrap::SITE_LINKEDIN);
        // $this->jobbankJobs = $this->countTotalJobsOf(Scrap::SITE_JOBBANK);

        $total_jobs_for_each_site = Scrap::get_list_of_site($this->date_type);
        $filtered_jobs = Scrap::query()->dateType($this->date_type)->count();

        return view('livewire.report.widget-report', compact('total_jobs_for_each_site', 'filtered_jobs'));
    }
}
