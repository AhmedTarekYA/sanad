<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCrmLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('crm_locale');
        $supportedLocales = config('laravellocalization.supportedLocales', []);

        if (is_string($locale) && array_key_exists($locale, $supportedLocales)) {
            app()->setLocale($locale);
        } else {
            app()->setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
