<?php

namespace App\Http\Middleware;

use Closure;

class CheckVerify
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
        if ($request->user()->u_state == 0)
        return response()->json([
            'message' => 'Unverified',
            'errors' => [
                'account' => 'Unverified account'
            ],
        ], 401);
    if ($request->user()->u_state == 2)
        return response()->json([
            'message' => 'Disabled',
            'errors' => [
                'account' => 'Disabled account'
            ],
        ], 401);
    return $next($request);
    }
}
