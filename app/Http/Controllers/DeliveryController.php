<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FeeshipRequest;
use App\Models\Province;
use App\Models\Village;
use App\Models\City;
use App\Models\Feeship;

class DeliveryController extends Controller
{
    public function index()
    {
        $citys = City::all();
        $provinces = Province::all();
        $villages = Village::all();
        return view('admin.delivery.delivery')->with(compact(['citys', 'provinces', 'villages']));
    }

    private function get_province($city_code)
    {
        $xhtml = '';
        $provinces = Province::where('city_code', $city_code)->oldest('province_code')->get();
        foreach ($provinces as $province) {
            $xhtml .= '<option value="' . $province->province_code . '">' . $province->name . '</option>';
        }
        return $xhtml;
    }

    private function get_village($province_code)
    {
        $xhtml = '';
        $villages = Village::where('province_code', $province_code)->oldest('village_code')->get();
        foreach ($villages as $village) {
            $xhtml .= '<option value="' . $village->village_code . '">' . $village->name . '</option>';
        }
        return $xhtml;
    }

    public function select_delivery(Request $req)
    {
        if ($req->action == 'city') {
            echo  $this->get_province($req->code);
        } else {
            echo  $this->get_village($req->code);
        }
    }

    public function show()
    {
        $res = Feeship::getFeeshipJson();
        return response()->json($res);
    }

    public function store(FeeshipRequest $req)
    {
        $feeship = new Feeship;
        $feeship->fill($req->all());
        $feeship->save();
    }

    public function delete(Request $req)
    {
        Feeship::destroy($req->id);
    }
}
