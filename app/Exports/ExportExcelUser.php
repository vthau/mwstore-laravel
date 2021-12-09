<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportExcelUser implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'Name', 'Email', "Phone", "Address", "Status", "Image",
        ];
    }

    public function collection()
    {
        return User::select('name', 'email',  'phone', 'address', 'status', 'image')->get();
    }
}
