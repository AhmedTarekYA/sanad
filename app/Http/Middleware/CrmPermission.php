<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CrmPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $page = ''): Response
    {
        $user = Auth::guard('crm')->user();

        if ($user === null) {
            abort(403);
        }

        if ($page === '') {
            $segments = explode('.', (string) $request->route()?->getName());
            $page = $segments[1] ?? '';

            if ($page === 'contact_tags') {
                $page = 'whatsapp_contacts';
            }

            if (in_array($page, ['', 'dashboard', 'logout'], true)) {
                return $next($request);
            }
        }

        if ($page === 'users') {
            abort_unless($user->role === 'admin', 403);

            return $next($request);
        }

        if (! $user->canAccess($page)) {
            if ($request->expectsJson()) {
                abort(403);
            }

            return redirect()->route('crm.dashboard')->with('error', __('auth.an error occurred'));
        }

        return $next($request);
    }
}
