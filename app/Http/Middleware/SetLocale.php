<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        } else {
            // Default fallback is Indonesian if no session is set, or English depending on app config.
            // Let's set default fallback to 'id' or default app locale.
            App::setLocale(config('app.locale', 'id'));
        }

        return $next($request);
    }
}
