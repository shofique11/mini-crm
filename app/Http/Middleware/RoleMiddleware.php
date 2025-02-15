<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
       
        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
       
        if (Auth::user()->role !== $role) {
            return response()->json(['error' => 'Access denied'], 403);
        }
        Log::info('User Role:', ['role' => Auth::user()->role]);
        return $next($request);
       
        // if (Auth::user()->role !== $role) {
        //     return response()->json(['error' => 'Access denied'], 403);
        // }
    //     if (!Auth::check()) {
    //         return response()->json(['message' => 'Unauthorized'], 401);
    //     }
    // dd($request->user()->hasRole($role));
    //     if (!$request->user()->hasRole($role)) {  // Check user's role
    //         return response()->json(['message' => 'Forbidden'], 403);
    //     }
    //     Log::info('User Role:', ['role' => Auth::user()->role]);
    //     return $next($request);
    }
}
