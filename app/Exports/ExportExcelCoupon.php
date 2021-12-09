<?php

namespace App\Exports;

use App\Models\Coupon;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportExcelCoupon implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'Name', 'Code',  'Quantity', 'Percent', 'Start Coupon', 'End Coupon'
        ];
    }

    public function collection()
    {
        return Coupon::select('name', 'code',  'quantity', 'percent', 'start_coupon', 'end_coupon')->get();
    }
}
