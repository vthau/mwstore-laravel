<?php

namespace App\Exports;

use App\Models\Visitor;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportExcelVisitor implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'Ip', 'Visit', 'Os', 'Browser', 'Device', 'More Info', 'Time'
        ];
    }

    public function collection()
    {
        return Visitor::select('ip', 'visit',  'os', 'browser', 'device', 'more_info', 'time')->get();
    }
}
