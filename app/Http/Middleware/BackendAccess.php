<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BackendAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || ! Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Staff'])) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized Access.'], 403);
            }

            return redirect('/')->with('error', 'You do not have administrative access to the backend CMS.');
        }

        return $next($request);
    }
}
