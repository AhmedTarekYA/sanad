<?php

namespace App\Http\Middleware;

use App\Enums\AdminTypeisEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeveloperOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless(
            $request->user('admin')?->admin_type === AdminTypeisEnum::Developer->value,
            403
        );

        return $next($request);
    }
}
