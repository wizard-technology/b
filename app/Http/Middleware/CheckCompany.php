<?php

namespace App\Http\Middleware;

use Closure;

class CheckCompany
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
        if ($request->user()->u_role != 'COMPANY')
        return response()->json([
            'message' => 'Disabled',
            'errors' => [
                'account' => 'Permissions denied'
            ],
        ], 401);
        return $next($request);
    }
}
