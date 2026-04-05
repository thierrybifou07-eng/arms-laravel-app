<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'User not authenticated');
        }
        $userStatus = strtolower(trim(optional($user->userStatus)->code));

        if ($userStatus === 'pending') {
            abort(403, 'Your account is pending approval. Please wait for the administrator to activate your account.');
        }
        if ($userStatus === 'disabled') {
            abort(403, 'Your account has been disabled. Please contact the administrator for more information.');
        }
        if ($userStatus !== 'active') {
            abort(403, 'Your account is not active. Please contact the administrator.');
        }

        return $next($request);
    }
}
