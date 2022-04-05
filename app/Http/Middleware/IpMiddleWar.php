<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Torann\GeoIP\Facades\GeoIP;

class IpMiddleWar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('geoip_location')) {
            if (isset($_SERVER['HTTP_X_REAL_IP'])) {
                $location = GeoIP::getLocation($_SERVER['HTTP_X_REAL_IP']);
                $request->session()->put('geoip_location', $location->toArray());
            }
        }
        return $next($request);
    }
}
