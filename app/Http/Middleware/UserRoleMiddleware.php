<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $user_role): Response
    {
        // 1. Check if user is logged in
        // if (!Auth::check()) {
        //     return redirect()->route('login');
        // }

        // 2. Check if the user's 'type' matches the required role
        // (Admin is 1, User is 0 based on your previous code)
        if (Auth::user()->type != $user_role) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
