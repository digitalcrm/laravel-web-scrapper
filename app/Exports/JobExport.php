<?php

namespace App\Exports;

use App\Models\Scrap;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithMapping;

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
            $data = Scrap::with('country')
                ->whereNotNull('job_short_description')
                ->whereNotNull('job_description')
                ->select($this->selectedColumn())
                ->latest()
                ->take(1000)
                ->get();
            return $data;
        } catch (\Throwable $th) {
            dd('error '. $th->getMessage());
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
                $job->job_posted,
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
        } else {
            return [
                'job_title', 'country_id', 'job_state', 'job_short_description', 'job_description', 'job_type', 'job_posted'
            ];
        }
    }

    protected function customHeading()
    {
        if ($this->type == 'ejobsite') {
            return [
                'job_title', 'job_country', 'job_short_description', 'job_description', 'job_type', 'inserted'
            ];
        } else {
            return [
                'job_title', 'job_country', 'job_city', 'job_short_description', 'job_description', 'job_type', 'job_posted'
            ];
        }
    }
}
