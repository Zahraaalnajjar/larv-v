<?php

namespace App\Http\Middleware;

use App\Models\Share;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
class TwoUserAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the list of currently authenticated user IDs from the session
        $authenticatedUserIds = Session::get('authenticated_users', []);

        // Count the number of authenticated users
        $authenticatedUsersCount = count($authenticatedUserIds);

        // Check if there are already 2 authenticated users
        if ($authenticatedUsersCount >= 2) {
            // If there are 2 or more authenticated users, allow access to the route
            return $next($request);
        } else {
            // If there are less than 2 authenticated users, deny access with a 403 Forbidden response
            return response()->json(['message' => 'Insufficient users'], 403);
        }

    }
}
