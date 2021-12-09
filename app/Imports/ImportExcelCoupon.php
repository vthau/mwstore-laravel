<?php

namespace App\Imports;

use App\Models\Coupon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportExcelCoupon implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Coupon([
            "name" => $row["name"],
            "code" => $row["code"],
            "quantity" => $row["quantity"],
            "percent" => $row["percent"],
            "start_coupon" => $row["start_coupon"],
            "end_coupon" => $row["end_coupon"],
        ]);
    }
}
