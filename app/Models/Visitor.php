<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Models\Device;

class Visitor extends Model
{
    protected $fillable = ['ip', 'os', 'device', 'browser', 'more_info', 'visit', 'time'];

    public static function visitor()
    {
        $ip = request()->ip();
        $visitor = Visitor::where('ip', $ip)->first();

        if ($visitor) {
            $visitor->visit =  $visitor->visit + 1;
        } else {
            $visitor = new Visitor;
            $visitor->ip = $ip;
            $visitor->visit =  1;
        }

        $visitor->time =  Carbon::now('Asia/Ho_Chi_Minh');
        $visitor->os = Device::getOS();
        $visitor->browser = Device::getBrowser();
        $visitor->device = Device::getDevices();
        $visitor->more_info = Device::getUserAgent();

        $visitor->save();
    }
}
