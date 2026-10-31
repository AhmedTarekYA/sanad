<?php

namespace App\Http\Middleware;

use App\Enums\AdminTypeisEnum;
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
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('admin')->user()->admin_type == AdminTypeisEnum::Developer->value) {
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
            'update-font' => 'update',
            'destroy' => 'delete',
            'toggle-read' => 'read',
        ];
        $userRole = @Auth::guard('admin')->user()->roles->first();
        $permissions = $userRole ? $userRole->first()->permissions->pluck('name')->toArray() : [];
        $mappedPermission = $permissions_map[$method] ?? null;
        if (in_array($routeName, $permissions) ||
            ($mappedPermission !== null && checkIfHasPermission($baseRouteName.'-'.$mappedPermission)) ||
            in_array($baseRouteName, [
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
