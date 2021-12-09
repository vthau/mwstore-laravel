<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Province;
use App\Models\Village;
use App\Models\City;
use App\Models\Feeship;

class CheckoutController extends Controller
{

    public function index()
    {
        $carts = Auth::user()->carts;
        $citys = City::all();
        $provinces = Province::all();
        $villages = Village::all();

        return view('user.checkout.checkout')->with(compact(['carts', 'citys', 'provinces', 'villages']));
    }

    private function get_address($req)
    {
        $city = City::where('city_code', $req->city_code)->first();
        $province = Province::where('province_code', $req->province_code)->first();
        $village = Village::where('village_code', $req->village_code)->first();
        return $city->name . ", " . $province->name . ", " . $village->name;
    }

    public function calc_feeship(Request $req)
    {
        $address = $this->get_address($req);
        $feeship = Feeship::where($req->all())->first();

        session(['feeship' => '25000', 'feeship_id' =>  'NO', 'address' => $address]);
        if ($feeship) {
            session(['feeship' => $feeship->feeship, 'feeship_id' =>  $feeship->id]);
        }
    }
}
