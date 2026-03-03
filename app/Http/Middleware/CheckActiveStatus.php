<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckActiveStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if user is a customer and is not active
        if ($user && $user->isCustomer() && !$user->isActive()) {
            // Logout user
            Auth::logout();

            // Regenerate session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect to login with error message
            return redirect()->route('login')->with('error', 'Your account has been deactivated. Please contact support.');
        }

        return $next($request);
    }
}
