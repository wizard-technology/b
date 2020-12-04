<?php

namespace App\Http\Middleware;

use App\Setting;
use Closure;

class CheckApp
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
        $setting = Setting::first();
       
        if ($setting->state_app) {
            return $next($request);
        }
        return response()->json([
            'errors' => [
                 "Application Under Construction"
            ],
        ], 401);
    }
}
