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
        ];

        collect($countries)->each(function ($country) {
            Country::create($country);
        });
    }
}
