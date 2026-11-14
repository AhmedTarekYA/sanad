@php($currentRoute = Route::currentRouteName())
@php($sidebarLogo = isset($settings) && $settings->logo_header && file_exists(public_path('/storage/' . $settings->logo_header)) ? showFile($settings->logo_header) : asset('brand/logo.svg'))
@php($whatsappPages = [
    'whatsapp_business_settings' => 'ti ti-settings',
    'whatsapp_setup'             => 'ti ti-plug',
    'whatsapp_chat'              => 'ti ti-message-2',
    'whatsapp_broadcasts'        => 'ti ti-speakerphone',
    'whatsapp_contacts'          => 'ti ti-address-book',
    'whatsapp_labels'            => 'ti ti-tag',
    'whatsapp_quick_replies'     => 'ti ti-bolt',
    'whatsapp_business_hours'    => 'ti ti-clock',
    'whatsapp_analytics'         => 'ti ti-chart-bar',
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
                <li class="pc-item pc-caption"><label><i class="fab fa-whatsapp me-1" aria-hidden="true"></i>{{ __('whatsapp_menu') }}</label></li>
                <li class="pc-item {{ $currentRoute === 'crm.dashboard' ? 'active' : '' }}">
                    <a href="{{ route('crm.dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-home" aria-hidden="true"></i></span>
                        <span class="pc-mtext">{{ __('auth.home') }}</span>
                    </a>
                </li>
                @foreach($whatsappPages as $page => $icon)
                    <li class="pc-item {{ $currentRoute === 'crm.'.$page ? 'active' : '' }}">
                        <a class="pc-link" href="{{ route('crm.'.$page) }}">
                            <span class="pc-micon"><i class="{{ $icon }}" aria-hidden="true"></i></span>
                            <span class="pc-mtext">{{ __($page) }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>
