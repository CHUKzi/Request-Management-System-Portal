<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SanctumAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!Auth::guard('sanctum')->user()) {
            throw new AuthenticationException('Unauthenticated.', ['Invalid token. Authentication token is required.']);
        }

        return $response;
    }
}
