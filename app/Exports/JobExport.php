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

class JobExport implements FromCollection, WithHeadings, WithEvents
{
    use Exportable, RegistersEventListeners;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Scrap::select('job_title', 'job_description', 'job_company', 'job_state', 'job_type')->get();
    }

    public function headings(): array
    {
        return [
            'job_title',
            'job_description',
            'job_company',
            'job_state',
            'job_type',
        ];
    }

    public static function afterSheet(AfterSheet $event)
    {
        $event->sheet->getDelegate()->getStyle('A1:E1')
            ->getFont()
            ->setBold(true);
    }
}
