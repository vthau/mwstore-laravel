<?php

namespace App\Exports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportExcelBrand implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {
        return [
            'Name',
            "Description",
        ];
    }

    public function collection()
    {
        return Brand::select('name', 'description')->get();
    }
}
