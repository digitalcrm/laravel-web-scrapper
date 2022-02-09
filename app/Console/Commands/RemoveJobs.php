<?php

namespace App\Console\Commands;

use App\Models\Scrap;
use Illuminate\Support\Arr;
use Illuminate\Console\Command;

class RemoveJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:remove-duplicate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete the duplicate jobs from the database table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $allJobs = Scrap::all();

        if ($allJobs) {
            $data = collect($allJobs)->duplicatesStrict('job_title');

            $total_jobs = count($allJobs);
            $total_duplicate_jobs = count($data);
            $message = $total_duplicate_jobs . ' duplicate jobs out of '. $total_jobs ;
            
            if (($total_duplicate_jobs > 0) && $this->confirm($message.' Are you sure want to delete the duplicate jobs?', true)) {
                $bar = $this->output->createProgressBar($total_duplicate_jobs);
                $bar->start();

                $data->each(function ($item) use ($bar) {
                    $job = Scrap::where('job_title', $item)->first();

                    $job->delete();

                    $bar->advance();
                });

                $bar->finish();

                $this->newLine();
                $this->info('duplicate jobs deleted');
            } else {
                $this->newLine();
                $this->info('No jobs found');
            }
        }
    }
}
