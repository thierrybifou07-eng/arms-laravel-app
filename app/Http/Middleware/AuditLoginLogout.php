<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuditLoginLogout
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     */
    public function terminate(Request $request, Response $response): void
    {
        // Log login
        if ($request->routeIs('login') && $request->method() === 'POST' && $response->getStatusCode() === 302) {
            $userId = auth()->id();
            if ($userId) {
                AuditLog::log(
                    action: 'LOGIN',
                    userId: $userId,
                    modelType: 'App\Models\User',
                    modelId: $userId,
                    details: 'User login',
                );
            }
        }

        // Log logout
        if ($request->routeIs('logout') && $response->getStatusCode() === 302) {
            $userId = session('_previous')['_previous']['user_id'] ?? auth()->id();

            if ($userId) {
                AuditLog::log(
                    action: 'LOGOUT',
                    userId: $userId,
                    modelType: 'App\Models\User',
                    modelId: $userId,
                    details: 'User logout',
                );
            }
        }
    }
}
