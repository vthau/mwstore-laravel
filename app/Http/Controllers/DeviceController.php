<?php

namespace App\Http\Controllers;

use App\Models\Device;

class DeviceController extends Controller
{
    public function admin_device()
    {
        $device = Device::getDevices();
        $browser = Device::getBrowser();
        $os = Device::getOS();
        return view('admin.device.admin')->with(['device' => $device, 'browser' => $browser, 'os' => $os]);
    }

    public function user_device($id)
    {
        $device = Device::with(['user'])->where('user_id', $id)->first();
        return view('admin.device.user')->with(['device' => $device]);
    }
}
