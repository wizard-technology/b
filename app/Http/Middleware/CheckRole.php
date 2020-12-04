<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
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
        if ($request->user()->u_state != 1)
            return response()->json([
                'message' => 'Bad Data',
                'errors' => [
                    'code' => 'Verification failed'
                ],
            ], 401);
        return $next($request);
    }
}
