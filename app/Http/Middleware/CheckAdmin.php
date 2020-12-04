<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CheckAdmin
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
        $user = User::findOrFail(session('dashboard'));
        if (session()->exists('dashboard')) {
            if ($user->u_role != 'ADMIN') {
                session()->forget('dashboard');
                session()->save();
                return redirect()->back()->withErrors(['email' => 'Permissions denied']);
            }
            if ($user->u_state == 0) {
                session()->forget('dashboard');
                session()->save();
                return redirect()->back()->withErrors(['admin' => 'Unverified account']);
            }
            if ($user->u_state == 2) {
                session()->forget('dashboard');
                session()->save();
                return redirect()->back()->withErrors(['admin' => 'Disabled account']);
            }
            view()->share('dashboard_admin', $user);
            return $next($request);
        }
    }
}
