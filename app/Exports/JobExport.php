<?php

namespace App\Exports;

use App\Models\Scrap;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class JobExport implements FromCollection, WithHeadings, WithEvents, WithMapping
{
    use Exportable, RegistersEventListeners;

    protected $type;

    public function __construct(string $type = null)
    {
        $this->type = $type;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        try {
            $data = QueryBuilder::for(Scrap::class)
                ->allowedFilters([
                    'job_title',
                    'job_company',
                    'job_function',
                    'industries',
                    'seniority_level',
                    'job_state',
                    'country_id',
                    'job_type',
                    'site_name',
                    'search_text',
                    AllowedFilter::partial('country.name'),
                    AllowedFilter::partial('country.sortname')
                ])
                ->allowedFields($this->selectedColumn())
                ->allowedIncludes(['country'])
                ->latest('job_posted')->get();

            return $data;
        } catch (\Throwable $th) {
            dd('error ' . $th->getMessage());
        }
    }

    public function map($job): array
    {
        if ($this->type == 'ejobsite') {
            return [
                $job->job_title,
                $job->country->name,
                $job->job_short_description,
                $job->job_description,
                $job->job_type,
                $job->job_posted,
            ];
        } else {
            return [
                $job->job_title,
                $job->country->name,
                $job->job_state,
                $job->job_short_description,
                $job->job_description,
                $job->job_type,
                $job->job_function,
                $job->industries,
                $job->job_company,
                $job->job_posted,
                $job->annual_wage,
                $job->working_week,
                $job->expected_duration,
                $job->possible_start_date,
                $job->closing_date,
                $job->apprenticeship_level,
                $job->reference_number,
            ];
        }
    }

    public function headings(): array
    {
        return $this->customHeading();
    }

    public static function afterSheet(AfterSheet $event)
    {
        $event->sheet->getDelegate()->getStyle('A1:E1')
            ->getFont()
            ->setBold(true);
    }

    protected function selectedColumn()
    {
        if ($this->type == 'ejobsite') {
            return [
                'job_title', 'country_id', 'job_short_description', 'job_description', 'job_type', 'job_posted'
            ];
        }

        return [
            'job_title',
            'country_id',
            'job_short_description',
            'job_description',
            'job_type',
            'job_function',
            'industries',
            'job_company',
            'job_posted',
            'annual_wage',
            'working_week',
            'expected_duration',
            'possible_start_date',
            'closing_date',
            'apprenticeship_level',
            'reference_number',
        ];
    }

    protected function customHeading()
    {
        if ($this->type == 'ejobsite') {
            return [
                'job_title', 'job_country', 'job_short_description', 'job_description', 'job_type', 'inserted'
            ];
        }

        return [
            'job_title',
            'job_country',
            'state',
            'job_short_description',
            'job_description',
            'job_type',
            'job_function',
            'industries',
            'job_company',
            'job_posted',
            'annual_wage',
            'working_week',
            'expected_duration',
            'possible_start_date',
            'closing_date',
            'apprenticeship_level',
            'reference_number',
        ];
    }
}
