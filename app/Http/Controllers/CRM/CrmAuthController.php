<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CRM\CrmUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CrmAuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::guard('crm')->check()) {
            return redirect()->route('crm.dashboard');
        }

        return view('crm.auth.login');
    }

    public function login(Request $request): JsonResponse|RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = CrmUser::where('email', $credentials['email'])->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        if (! $user->is_active) {
            throw ValidationException::withMessages([
                'email' => __('auth.crm_account_inactive'),
            ]);
        }

        if ($user->subscription_ends_at && $user->subscription_ends_at->isPast()) {
            throw ValidationException::withMessages([
                'email' => __('auth.crm_subscription_expired'),
            ]);
        }

        if (! Auth::guard('crm')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        if ($request->expectsJson()) {
            return jsonSuccess(['url' => '/'], __('auth.login successful'));
        }

        return redirect()->intended('/');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('crm')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/login');
    }
}
