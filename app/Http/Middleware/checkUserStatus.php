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
            return response()->view('errors.pending', [], 403);
        }
        if ($userStatus === 'disabled') {
            return response()->view('errors.disabled', [], 403);
        }
        if ($userStatus !== 'active') {
            abort(403, 'Your account is not active. Please contact the administrator.');
        }

        return $next($request);
    }
}
