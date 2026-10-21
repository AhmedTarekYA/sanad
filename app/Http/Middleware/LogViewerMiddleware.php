<?php

namespace App\Http\Middleware;

use App\Enums\AdminTypeisEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogViewerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin || $admin->admin_type != AdminTypeisEnum::Developer->value) {
            return redirect()->route("admin.form.login");
        }

        return $next($request);
    }
}
