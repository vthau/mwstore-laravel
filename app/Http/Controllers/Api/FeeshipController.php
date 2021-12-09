<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feeship;

class FeeshipController extends Controller
{
    public function new_feeship(Request $req)
    {
        Feeship::updateOrCreate([
            'city_code'   =>   $req->city_code,
            'province_code'   =>   $req->province_code,
            'village_code'   =>   $req->village_code,
        ], ['feeship' => $req->feeship]);

        return response()->json([
            'status' => "SUCCESS",
        ]);
    }

    public function all_feeship()
    {
        $feeships = Feeship::with(["city", "province", "village"])->get();
        return response()->json([
            'status' => "SUCCESS",
            "feeships" => $feeships,
        ]);
    }

    public function delete_feeship(Request $req)
    {
        Feeship::find($req->id)->delete();
        return response()->json([
            'status' => "SUCCESS",
        ]);
    }
}
