<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Import Auth facade

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  // Accept one or more roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Check if user has one of the required roles
        foreach ($roles as $role) {
            // Assumes User model has a 'role' string attribute or an isAdmin()/isStaff() method
            // Adjust the check based on your User model implementation
            if ($user->role === $role) { // Simple check for string role column
            // if (method_exists($user, 'hasRole') && $user->hasRole($role)) { // If using a role package/relationship
            // if (($role === 'admin' && $user->isAdmin()) || ($role === 'staff' && $user->isStaff())) { // Using helper methods
                return $next($request); // User has the required role, continue
            }
        }

        // User does not have any of the required roles
        // Redirect to a relevant page or abort
         // return redirect('/dashboard')->with('error', 'You do not have permission to access this page.'); // Redirect to their own dashboard
         abort(403, 'Unauthorized action.'); // Or show a forbidden error
    }
}