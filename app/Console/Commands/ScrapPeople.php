<?php

namespace App\Console\Commands;

use App\Http\Traits\ScrapPeopleTrait;
use Illuminate\Console\Command;

class ScrapPeople extends Command
{
    use ScrapPeopleTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:people {firstName?} {lastName?} {--linkedin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'scrap people';

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
        if ($this->option('linkedin')) {
            $this->scrap_linkedin_people_data($this->argument('firstName'), $this->argument('lastName'));
        } else {
            $this->info('select option also such as linkedin');
        }
    }
}
