<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user=$request->user();
        if (!$user) {
            abort(403, 'User not authenticated');
        }
        if ($user->status !== 'active') {
            abort(403, 'Your account is not active. Please contact the administrator.');
        }
        if ($user->status === 'pending') {
            abort(403, 'Your account is pending approval. Please wait for the administrator to activate your account.');
        }
        if ($user->status === 'disabled') {
            abort(403, 'Your account has been disabled. Please contact the administrator for more information.');
        }
        return $next($request);

    }
}
