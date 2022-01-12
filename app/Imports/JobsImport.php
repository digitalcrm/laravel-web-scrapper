<?php

namespace App\Imports;

use App\Models\Scrap;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JobsImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public $country_id;
    public $site_name;
    public $arrayList = ['job_title', 'job_city', 'job_company', 'job_short_description', 'job_description', 'job_type'];

    public function __construct(int $country_id, string $site_name)
    {
        $this->country_id = $country_id;
        $this->site_name = $site_name;
    }
    public function model(array $row)
    {
        // if (!(Arr::has($row, $this->arrayList))) {
        //     return 'false';
        // }
        return new Scrap([
            'job_title'             => $row['job_title'],
            'country_id'            => $this->country_id,
            'job_state'             => $row['job_city'],
            'job_company'           => $row['job_company'],
            'job_short_description' => $row['job_short_description'],
            'job_description'       => $row['job_description'],
            'job_type'              => $row['job_type'],
            'job_posted'            => now(),
            'site_name'             => $this->site_name,
        ]);
    }
}
