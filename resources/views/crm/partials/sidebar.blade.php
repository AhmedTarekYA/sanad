@php($currentRoute = Route::currentRouteName())
@php($sidebarLogo = isset($settings) && $settings->logo_header && file_exists(public_path('/storage/' . $settings->logo_header)) ? showFile($settings->logo_header) : asset('brand/logo.svg'))
@php($whatsappActive = Str::startsWith($currentRoute, 'crm.whatsapp_'))
@php($whatsappPages = [
    'whatsapp_business_settings' => 'fal fa-cog',
    'whatsapp_setup'             => 'fal fa-plug',
    'whatsapp_chat'              => 'fal fa-comments',
    'whatsapp_broadcasts'        => 'fal fa-bullhorn',
    'whatsapp_contacts'          => 'fal fa-address-book',
    'whatsapp_labels'            => 'fal fa-tags',
    'whatsapp_quick_replies'     => 'fal fa-bolt',
    'whatsapp_business_hours'    => 'fal fa-clock',
    'whatsapp_analytics'         => 'fal fa-chart-bar',
])
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header"><a href="{{ route('crm.dashboard') }}" class="b-brand text-primary">
                <img src="{{ $sidebarLogo }}" alt="{{ $settings->website_name ?? config('app.name') }}"
                     class="logo-lg sanad-fallback-logo"
                     onerror="this.onerror=null;this.src='{{ asset('brand/logo.svg') }}';">
            </a></div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption"><label><i class="ph-duotone ph-squares-four me-1" aria-hidden="true"></i>{{ __('crm_users') }}</label></li>
                <li class="pc-item {{ $currentRoute === 'crm.dashboard' ? 'active' : '' }}"><a href="{{ route('crm.dashboard') }}" class="pc-link"><span class="pc-micon"><i class="fal fa-home" aria-hidden="true"></i></span><span class="pc-mtext">{{ __('auth.home') }}</span></a></li>
                <li class="pc-item pc-hasmenu {{ $whatsappActive ? 'active pc-trigger' : '' }}">
                    <a href="#" class="pc-link"><span class="pc-micon"><i class="fab fa-whatsapp" aria-hidden="true"></i></span><span class="pc-mtext">{{ __('whatsapp_menu') }}</span><span class="pc-arrow"><i class="ti ti-chevron-left" aria-hidden="true"></i></span></a>
                    <ul class="pc-submenu">
                        @foreach($whatsappPages as $page => $icon)
                            <li class="pc-item {{ $currentRoute === 'crm.'.$page ? 'active' : '' }}"><a class="pc-link" href="{{ route('crm.'.$page) }}"><span class="pc-micon"><i class="{{ $icon }}" aria-hidden="true"></i></span><span class="pc-mtext">{{ __($page) }}</span></a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
