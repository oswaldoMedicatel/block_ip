<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Ips;
use Illuminate\Support\Facades\RateLimiter;

class RestrictIpAddressMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $ips = Ips::all();
        foreach ($ips as $ip) {
            if ($ip->ip == $request->ip()) {
                return response()->json(['message' => "You are not allowed to access this site."]);
            }
        }
        return $next($request);
    }

    public static function reset($key)
    {
        RateLimiter::clear($key);
    }
}
