<?php

namespace Database\Seeders;

use App\Models\JobFunction;
use Illuminate\Database\Seeder;

class JobFunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $job_functions = [
            [
                'name' => 'Accounting'
            ],
            [
                'name' => 'Administrative'
            ],
            [
                'name' => 'Arts and Design'
            ],
            [
                'name' => 'Business Development'
            ],
            [
                'name' => 'Community and Social Services'
            ],
            [
                'name' => 'Consulting'
            ],
            [
                'name' => 'Education'
            ],
            [
                'name' => 'Engineering'
            ],
            [
                'name' => 'Entrepreneurship'
            ],
            [
                'name' => 'Finance'
            ],
            [
                'name' => 'Healthcare Services'
            ],
            [
                'name' => 'Human Resources'
            ],
            [
                'name' => 'Information Technology'
            ],
            [
                'name' => 'Legal'
            ],
            [
                'name' => 'Marketing'
            ],
            [
                'name' => 'Media and Communication'
            ],
            [
                'name' => 'Military and Protective Services'
            ],
            [
                'name' => 'Operations'
            ],
            [
                'name' => 'Product Management'
            ],
            [
                'name' => 'Program and Project Management'
            ],
            [
                'name' => 'Purchasing'
            ],
            [
                'name' => 'Quality Assurance'
            ],
            [
                'name' => 'Real Estate'
            ],
            [
                'name' => 'Research'
            ],
            [
                'name' => 'Sales'
            ],
            [
                'name' => 'Support'
            ],
        ];

        collect($job_functions)->each(function ($value) {
            JobFunction::create($value);
        });
    }
}
