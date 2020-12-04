<?php

namespace App\Http\Middleware;

use App\Admin;
use Closure;
use Illuminate\Support\Facades\Route;

class hasAccess
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
        $admin = Admin::where('a_user',session('dashboard'))->first();
        $route = getCurrentRoute(Route::currentRouteName());
        if(in_array($route,json_decode($admin->a_access))){
            
            return $next($request);
        }
        return redirect()->route('dashboard.not');
        
    }
}
