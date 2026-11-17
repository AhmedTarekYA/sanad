@php($currentRoute = Route::currentRouteName())
@php($crmUser = auth('crm')->user())
@php($sidebarLogo = isset($settings) && $settings->logo_header && file_exists(public_path('/storage/' . $settings->logo_header)) ? showFile($settings->logo_header) : asset('brand/logo.svg'))
@php($whatsappPages = [
    'whatsapp_business_settings' => 'ti ti-settings',
    'whatsapp_setup'             => 'ti ti-plug',
    'whatsapp_chat'              => 'ti ti-message-2',
    'whatsapp_broadcasts'        => 'ti ti-speakerphone',
    'whatsapp_contacts'          => 'fas fa-address-book',
    'whatsapp_labels'            => 'ti ti-tag',
    'whatsapp_quick_replies'     => 'ti ti-bolt',
    'whatsapp_business_hours'    => 'ti ti-clock',
    'whatsapp_analytics'         => 'ti ti-chart-bar',
])
<nav class="pc-sidebar wb-crm-compact">
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
                    @if($crmUser && $crmUser->canAccess($page))
                        <li class="pc-item {{ $currentRoute === 'crm.'.$page ? 'active' : '' }}">
                            <a class="pc-link" href="{{ route('crm.'.$page) }}">
                                <span class="pc-micon"><i class="{{ $icon }}" aria-hidden="true"></i></span>
                                <span class="pc-mtext">{{ __($page) }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach

                @if($crmUser && $crmUser->canAccess('crm_sales'))
                    <li class="pc-item pc-caption"><label>{{ __('crm_sales') }}</label></li>
                    <li class="pc-item {{ $currentRoute === 'crm.crm_sales.index' ? 'active' : '' }}">
                        <a class="pc-link" href="{{ route('crm.crm_sales.index') }}">
                            <span class="pc-micon"><i class="ti ti-shopping-cart" aria-hidden="true"></i></span>
                            <span class="pc-mtext">{{ __('crm_sales') }}</span>
                        </a>
                    </li>
                @endif

                @if($crmUser && $crmUser->role === 'admin')
                    <li class="pc-item pc-caption"><label>{{ __('management') }}</label></li>
                    <li class="pc-item {{ $currentRoute === 'crm.users.index' ? 'active' : '' }}">
                        <a class="pc-link" href="{{ route('crm.users.index') }}">
                            <span class="pc-micon"><i class="ti ti-users" aria-hidden="true"></i></span>
                            <span class="pc-mtext">{{ __('users') }}</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
<style>
.pc-sidebar .pc-micon .fas,
.pc-sidebar .pc-micon .fab,
.pc-sidebar .pc-micon .far {
    font-size: 20px;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
}

/* Compact CRM sidebar: narrow rail with stacked icon + small label */
@media (min-width: 1025px) {
    .pc-sidebar.wb-crm-compact {
        width: 94px;
    }
    .pc-sidebar.wb-crm-compact .navbar-wrapper,
    .pc-sidebar.wb-crm-compact .navbar-content {
        width: 94px;
    }
    .pc-sidebar.wb-crm-compact .m-header {
        width: 94px;
        padding: 16px 12px;
        justify-content: center;
    }
    .pc-sidebar.wb-crm-compact .m-header .b-brand,
    .pc-sidebar.wb-crm-compact .m-header .logo-lg {
        max-width: 52px;
        margin: 0 auto;
    }
    .pc-sidebar.wb-crm-compact .pc-navbar {
        padding-inline: 8px;
    }
    .pc-sidebar.wb-crm-compact .pc-caption {
        display: none;
    }
    .pc-sidebar.wb-crm-compact .pc-item {
        margin: 4px 0;
    }
    .pc-sidebar.wb-crm-compact .pc-link {
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 5px;
        min-height: 62px;
        padding: 9px 4px;
        border-radius: 12px;
        text-align: center;
    }
    .pc-sidebar.wb-crm-compact .pc-link:hover {
        transform: none;
    }
    .pc-sidebar.wb-crm-compact .pc-micon {
        width: auto;
        height: auto;
        margin: 0 !important;
        line-height: 1;
    }
    .pc-sidebar.wb-crm-compact .pc-micon i {
        font-size: 20px;
    }
    .pc-sidebar.wb-crm-compact .pc-mtext {
        display: block !important;
        max-width: 78px;
        font-size: 10.5px;
        font-weight: 600;
        line-height: 1.2;
        white-space: normal;
        text-align: center;
        opacity: 1 !important;
    }
    .pc-sidebar.wb-crm-compact .pc-arrow {
        display: none;
    }
    .pc-sidebar.wb-crm-compact:not(.pc-sidebar-hide) ~ .pc-container,
    .pc-sidebar.wb-crm-compact:not(.pc-sidebar-hide) ~ .pc-footer {
        margin-left: 94px;
    }
    .pc-sidebar.wb-crm-compact:not(.pc-sidebar-hide) ~ .pc-header {
        left: 94px;
    }
    .pc-sidebar.wb-crm-compact.pc-sidebar-hide {
        width: 0;
    }
    .pc-sidebar.wb-crm-compact.pc-sidebar-hide ~ .pc-container,
    .pc-sidebar.wb-crm-compact.pc-sidebar-hide ~ .pc-footer {
        margin-left: 0;
    }
    .pc-sidebar.wb-crm-compact.pc-sidebar-hide ~ .pc-header {
        left: 0;
    }
}
</style>
</nav>
