<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserOnline
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(3); // keep online for 1 min
            Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
            // last seen
            User::where('id', Auth::user()->id)->update(['time' => (new \DateTime())->format("Y-m-d H:i:s")]);
            //Device
            Device::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                'user_id'   => Auth::user()->id,
            ], [
                'os'     => Device::getOS(),
                'device'     => Device::getDevices(),
                'browser'     => Device::getBrowser(),
                'more_info'     => Device::getUserAgent(),
                'last_login'     => Carbon::now('Asia/Ho_Chi_Minh'),
            ]);
        }
        return $next($request);
    }
}
