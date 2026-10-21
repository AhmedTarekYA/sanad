<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('admin')->user()->admin_type == \App\Enums\AdminTypeisEnum::Developer->value)
        {
            return $next($request);
        }

        $currentRouteName = Route::currentRouteName();
        $baseRouteName = explode('.', $currentRouteName)[0];
        $method = explode('.', $currentRouteName)[1];

        $routeName = getRouteNameFromUrl($request->url(), $request->method());
        $permissions_map = [
            'create' => 'create',
            'store' => 'create',
            'index' => 'read',
            'show' => 'read',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
        ];
        $userRole = @Auth::guard('admin')->user()->roles->first();
        $permissions = $userRole ? $userRole->first()->permissions->pluck('name')->toArray() : [];
        if(in_array($routeName, $permissions)||
            checkIfHasPermission($baseRouteName .'-'. $permissions_map[$method]) ||
            in_array($baseRouteName,[
                'dashboard',
                'env',
                'terminal',
                'commands',
        ])) {
            return $next($request);
        }
        return abort(403);
    }
}
