<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Village;
use App\Models\City;
use App\Models\Feeship;

class AddressController extends Controller
{
    public function get_address()
    {
        $cites = City::with('provinces.villages')->get();

        return response()->json([
            "status" => "SUCCESS",
            "cites" => $cites,
        ]);
    }

    private function get_detail_address($req)
    {
        $city = City::where('city_code', $req->city_code)->first();
        $province = Province::where('province_code', $req->province_code)->first();
        $village = Village::where('village_code', $req->village_code)->first();
        return $city->name . ", " . $province->name . ", " . $village->name;
    }

    public function calc_feeship(Request $req)
    {
        $feeship = Feeship::where($req->all())->first();
        $address = $this->get_detail_address($req);

        if (!$feeship) {
            return response()->json(["status" => "SUCCESS", 'feeship' => '25000', 'feeship_id' =>  'NO', 'address' => $address]);
        }
        return response()->json(["status" => "SUCCESS", 'feeship' => $feeship->feeship, 'feeship_id' =>  $feeship->id, 'address' => $address]);
    }
}
