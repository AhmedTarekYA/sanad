<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        // Skip dashboard, API, and AJAX requests
        if ($request->is('dashboard*') || $request->is('api/*') || $request->ajax()) {
            return $next($request);
        }

        $agent = new Agent;
        $agent->setUserAgent($request->userAgent() ?? '');

        // Skip bots and crawlers
        if ($agent->isRobot()) {
            return $next($request);
        }

        $sessionKey = 'visited_'.today()->toDateString();
        $isUnique = ! $request->session()->has($sessionKey);

        if ($isUnique) {
            $request->session()->put($sessionKey, true);
        }

        $country = null;
        $countryCode = null;

        try {
            $position = Location::get($request->ip());
            if ($position) {
                $country = $position->countryName;
                $countryCode = strtolower($position->countryCode);
            }
        } catch (\Throwable) {
            // Geolocation is best-effort; never block the request
        }

        Visit::create([
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device' => $agent->isTablet() ? 'tablet' : ($agent->isMobile() ? 'mobile' : 'desktop'),
            'browser' => $agent->browser() ?: null,
            'os' => $agent->platform() ?: null,
            'country' => $country,
            'country_code' => $countryCode,
            'url' => $request->fullUrl(),
            'referer' => $request->header('referer'),
            'session_id' => $request->session()->getId(),
            'is_unique' => $isUnique,
        ]);

        return $next($request);
    }
}
