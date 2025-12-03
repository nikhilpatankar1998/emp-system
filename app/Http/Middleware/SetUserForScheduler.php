<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Artisan;

class SetUserForScheduler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // ✅ Cache me current user ka ID store karein
            // Cache::put('current_logged_in_user', Auth::id(), now()->addMinutes(10));
            Cache::forever('current_logged_in_user', Auth::id());

            // ✅ Scheduler start kare (agar chal nahi raha)
            // Artisan::call('schedule:work');
        }
        return $next($request);
    }
}
