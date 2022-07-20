<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            [
                'sortname' => 'uae',
                'name' => 'uae',
            ],
            [
                'sortname' => 'ind',
                'name' => 'india'
            ],
            [
                'sortname' => 'canada',
                'name' => 'canada'
            ],
            [
                'sortname' => 'usa',
                'name' => 'United States'
            ],
            [
                'sortname' => 'uk',
                'name' => 'United Kingdom'
            ],
            [
                'sortname' => 'sa',
                'name' => 'Saudi Arabia'
            ],
            [
                'sortname' => 'liberia',
                'name' => 'Liberia'
            ],
            [
                'sortname' => 'london',
                'name' => 'London'
            ],
        ];

        collect($countries)->each(function ($country) {
            Country::updateOrCreate(
                ['sortname' => $country['sortname']],
                $country
            );
        });
    }
}
