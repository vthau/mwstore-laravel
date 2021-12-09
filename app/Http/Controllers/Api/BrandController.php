<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Exports\ExportExcelBrand;
use App\Imports\ImportExcelBrand;
use Excel;
use Carbon\Carbon;

class BrandController extends Controller
{
    public function get_all_brand()
    {
        $brands = Brand::all();
        return response()->json([
            'status' => "SUCCESS",
            'brands' => $brands,
        ]);
    }

    public function update_brand(Request $req)
    {
        Brand::updateOrCreate([
            'id'   =>   $req->id,
        ], ['description' => $req->description, 'name' =>  $req->name]);
        return response()->json([
            'status' => "SUCCESS",
        ]);
    }

    public function delete_brand(Request $req)
    {
        Brand::destroy($req->id);
        return response()->json([
            "status" => "SUCCESS",
        ]);
    }

    public function import_excel(Request $req)
    {
        $file = $req->file('file');
        if (Excel::import(new ImportExcelBrand, $file)) {
            return response()->json(["status" => "SUCCESS"]);
        }

        return response()->json(["status" => "FAIL"]);
    }

    public function export_excel()
    {
        $time = Carbon::now('Asia/Ho_Chi_Minh')->format('Hisddmmyy');
        return Excel::download(new ExportExcelBrand, 'brand_' . $time . '.xlsx');
    }
}
