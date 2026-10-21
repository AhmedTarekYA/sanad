@php($currentRoute = Route::currentRouteName())
@php($sidebarLogo = isset($settings) && $settings->logo_header && file_exists(public_path('/storage/' . $settings->logo_header)) ? showFile($settings->logo_header) : asset('brand/logo.svg'))
<nav class="pc-sidebar"><div class="navbar-wrapper"><div class="m-header"><a href="{{ route('dashboard.index') }}" class="b-brand text-primary"><img src="{{ $sidebarLogo }}" alt="{{ $settings->website_name ?? config('app.name') }}" class="logo-lg nami-fallback-logo" onerror="this.onerror=null;this.src='{{ asset('brand/logo.svg') }}';"></a></div><div class="navbar-content"><ul class="pc-navbar">
<li class="pc-item pc-caption"><label><i class="ph-duotone ph-squares-four me-1" aria-hidden="true"></i>{{ __('auth.dashboard') }}</label></li>
<li class="pc-item {{ $currentRoute === 'dashboard.index' ? 'active' : '' }}"><a href="{{ route('dashboard.index') }}" class="pc-link"><span class="pc-micon"><img class="nami-sidebar-svg" src="{{ asset('admin/assets/icons/profile-overview.svg') }}" alt="" aria-hidden="true"></span><span class="pc-mtext">{{ __('auth.home') }}</span></a></li>
@if(checkIfHasPermission('settings-read'))<li class="pc-item {{ Str::startsWith($currentRoute, 'settings.') ? 'active' : '' }}"><a href="{{ route('settings.index') }}" class="pc-link"><span class="pc-micon"><img class="nami-sidebar-svg" src="{{ asset('admin/assets/icons/category.svg') }}" alt="" aria-hidden="true"></span><span class="pc-mtext">{{ __('auth.site_settings') }}</span></a></li>@endif
@if(auth('admin')->user()?->admin_type === \App\Enums\AdminTypeisEnum::Developer->value) @php($developerActive = in_array(explode('.', $currentRoute)[0], ['env','terminal','commands','main-settings']))<li class="pc-item pc-hasmenu {{ $developerActive ? 'active pc-trigger' : '' }}"><a href="#" class="pc-link"><span class="pc-micon"><img class="nami-sidebar-svg" src="{{ asset('admin/assets/icons/manager.svg') }}" alt="" aria-hidden="true"></span><span class="pc-mtext">{{ __('auth.system_settings') }}</span><span class="pc-arrow"><i class="ti ti-chevron-left" aria-hidden="true"></i></span></a><ul class="pc-submenu"><li class="pc-item {{ $currentRoute === 'env.index' ? 'active' : '' }}"><a class="pc-link" href="{{ route('env.index') }}"><span class="pc-micon"><img class="nami-sidebar-svg" src="{{ asset('admin/assets/icons/orders.svg') }}" alt="" aria-hidden="true"></span><span class="pc-mtext">env</span></a></li><li class="pc-item {{ $currentRoute === 'terminal.index' ? 'active' : '' }}"><a class="pc-link" href="{{ route('terminal.index') }}"><span class="pc-micon"><img class="nami-sidebar-svg" src="{{ asset('admin/assets/icons/wallet.svg') }}" alt="" aria-hidden="true"></span><span class="pc-mtext">{{ __('auth.terminal') }}</span></a></li><li class="pc-item {{ $currentRoute === 'commands.index' ? 'active' : '' }}"><a class="pc-link" href="{{ route('commands.index') }}"><span class="pc-micon"><img class="nami-sidebar-svg" src="{{ asset('admin/assets/icons/offers.svg') }}" alt="" aria-hidden="true"></span><span class="pc-mtext">{{ __('auth.commands') }}</span></a></li><li class="pc-item {{ $currentRoute === 'main-settings.index' ? 'active' : '' }}"><a class="pc-link" href="{{ route('main-settings.index') }}"><span class="pc-micon"><img class="nami-sidebar-svg" src="{{ asset('admin/assets/icons/category.svg') }}" alt="" aria-hidden="true"></span><span class="pc-mtext">{{ __('auth.main_settings') }}</span></a></li><li class="pc-item"><a class="pc-link" href="{{ url('/log-viewer') }}" target="_blank"><span class="pc-micon"><img class="nami-sidebar-svg" src="{{ asset('admin/assets/icons/orders.svg') }}" alt="" aria-hidden="true"></span><span class="pc-mtext">Log viewer</span></a></li></ul></li>@endif
@if(checkIfHasPermission('roles-read')) @php($rolesActive = in_array(explode('.', $currentRoute)[0], ['admins','permissions','roles']))<li class="pc-item pc-hasmenu {{ $rolesActive ? 'active pc-trigger' : '' }}"><a href="#" class="pc-link"><span class="pc-micon"><img class="nami-sidebar-svg" src="{{ asset('admin/assets/icons/users.svg') }}" alt="" aria-hidden="true"></span><span class="pc-mtext">{{ __('permission.users and roles') }}</span><span class="pc-arrow"><i class="ti ti-chevron-left"></i></span></a><ul class="pc-submenu">@if(checkIfHasPermission('admins-read'))<li class="pc-item"><a class="pc-link" href="{{ route('admins.index') }}"><span class="pc-micon"><img class="nami-sidebar-svg" src="{{ asset('admin/assets/icons/users.svg') }}" alt="" aria-hidden="true"></span><span class="pc-mtext">{{ __('auth.users') }}</span></a></li>@endif @if(auth('admin')->user()?->admin_type === \App\Enums\AdminTypeisEnum::Developer->value)<li class="pc-item"><a class="pc-link" href="{{ route('permissions.index') }}"><span class="pc-micon"><img class="nami-sidebar-svg" src="{{ asset('admin/assets/icons/profile-overview.svg') }}" alt="" aria-hidden="true"></span><span class="pc-mtext">{{ __('permission.permissions') }}</span></a></li>@endif @if(checkIfHasPermission('roles-read'))<li class="pc-item"><a class="pc-link" href="{{ route('roles.index') }}"><span class="pc-micon"><img class="nami-sidebar-svg" src="{{ asset('admin/assets/icons/manager.svg') }}" alt="" aria-hidden="true"></span><span class="pc-mtext">{{ __('permission.roles') }}</span></a></li>@endif</ul></li>@endif
@if(checkIfHasPermission('configs-read'))<li class="pc-item {{ Str::startsWith($currentRoute, 'configs.') ? 'active' : '' }}"><a href="{{ route('configs.index') }}" class="pc-link"><span class="pc-micon"><img class="nami-sidebar-svg" src="{{ asset('admin/assets/icons/bank.svg') }}" alt="" aria-hidden="true"></span><span class="pc-mtext">{{ __('config') }}</span></a></li>@endif
</ul></div></div></nav>
<style>
    .pc-sidebar .m-header .nami-fallback-logo { max-width: 150px; max-height: 52px; object-fit: contain; transition: transform .25s ease, filter .25s ease; }
    .pc-sidebar .m-header:hover .nami-fallback-logo { transform: translateY(-2px) scale(1.03); filter: drop-shadow(0 8px 12px rgba(4,169,245,.16)); }
    .pc-sidebar .pc-navbar > .pc-item { animation: nami-sidebar-item-in .35s ease both; }
    .pc-sidebar .pc-navbar > .pc-item:nth-child(2) { animation-delay: .04s; }
    .pc-sidebar .pc-navbar > .pc-item:nth-child(3) { animation-delay: .08s; }
    .pc-sidebar .pc-navbar > .pc-item:nth-child(4) { animation-delay: .12s; }
    .pc-sidebar .pc-navbar > .pc-item:nth-child(5) { animation-delay: .16s; }
    .pc-sidebar .pc-navbar { padding-inline: 10px; }
    .pc-sidebar .pc-navbar > .pc-item:not(.pc-caption) { margin-block: 4px; }
    .pc-sidebar .pc-link { border-radius: 12px; transition: color .2s ease, background-color .2s ease, transform .2s ease, box-shadow .2s ease; }
    .pc-sidebar .pc-item:not(.active) > .pc-link:hover { background: linear-gradient(90deg, color-mix(in srgb, var(--bs-primary) 6%, transparent), color-mix(in srgb, var(--bs-primary) 13%, transparent)); box-shadow: 0 5px 14px rgba(15,23,42,.05); }
    .pc-sidebar .pc-link:hover { transform: translateX(-3px); }
    html[dir="ltr"] .pc-sidebar .pc-link:hover { transform: translateX(3px); }
    .pc-sidebar .pc-item.active > .pc-link { box-shadow: inset 3px 0 0 var(--bs-primary); }
    html[dir="rtl"] .pc-sidebar .pc-item.active > .pc-link { box-shadow: inset -3px 0 0 var(--bs-primary); }
    .pc-sidebar .pc-micon i { transition: transform .2s ease, color .2s ease; }
    .pc-sidebar .pc-link:hover .pc-micon i { transform: scale(1.12); }
    .pc-sidebar .pc-hasmenu > .pc-link .pc-arrow { transition: transform .25s ease; }
    .pc-sidebar .pc-hasmenu.pc-trigger > .pc-link .pc-arrow { transform: rotate(-90deg); }
    @keyframes nami-sidebar-item-in { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    @media (prefers-reduced-motion: reduce) { .pc-sidebar .pc-navbar > .pc-item, .pc-sidebar .pc-link, .pc-sidebar .pc-micon i, .pc-sidebar .m-header .nami-fallback-logo { animation: none; transition: none; } }
    /* Keep navigation states quiet and predictable across the vendor theme presets. */
    .pc-sidebar .pc-navbar .pc-item:not(.active) > .pc-link:hover { transform: none; box-shadow: none; background: color-mix(in srgb, var(--bs-primary) 6%, transparent); }
    .pc-sidebar .pc-navbar .pc-item.active > .pc-link { color: var(--bs-primary); background: color-mix(in srgb, var(--bs-primary) 10%, #fff); box-shadow: inset -3px 0 0 var(--bs-primary); font-weight: 600; }
    html[dir="ltr"] .pc-sidebar .pc-navbar .pc-item.active > .pc-link { box-shadow: inset 3px 0 0 var(--bs-primary); }
    .pc-sidebar .pc-navbar .pc-submenu .pc-item.active > .pc-link { background: color-mix(in srgb, var(--bs-primary) 7%, transparent); box-shadow: none; }
    .pc-sidebar .pc-navbar > .pc-item > .pc-link::after,
    .pc-sidebar .pc-navbar > .pc-item .pc-submenu::after,
    .pc-sidebar .pc-navbar > .pc-item .pc-submenu .pc-item > .pc-link::after { display: none !important; }
    .pc-sidebar .pc-navbar .pc-item.active > .pc-link { border-inline-end: 3px solid var(--bs-primary); }
    html[dir="ltr"] .pc-sidebar .pc-navbar .pc-item.active > .pc-link { border-inline-end: 0; border-inline-start: 3px solid var(--bs-primary); }
    .pc-sidebar .pc-navbar .pc-submenu { border-inline-start: 1px solid color-mix(in srgb, var(--bs-primary) 18%, var(--pc-sidebar-submenu-border-color)); }
    .pc-sidebar .pc-navbar .pc-submenu .pc-item.active > .pc-link { border-inline-end: 0; border-inline-start: 3px solid var(--bs-primary); }
    html[dir="ltr"] .pc-sidebar .pc-navbar .pc-submenu .pc-item.active > .pc-link { border-inline-start: 3px solid var(--bs-primary); }
    .pc-sidebar .pc-navbar .pc-link:hover .pc-micon i { transform: none; }
    /* Replace the vendor's oversized RTL submenu indentation with a compact inset. */
    [data-pc-direction="rtl"] .pc-sidebar .pc-navbar > .pc-item .pc-submenu .pc-link { padding: 8px 10px 8px 15px; }
    [data-pc-direction="rtl"] .pc-sidebar .pc-navbar > .pc-item .pc-submenu .pc-link { position: relative; inset-inline-end: -16px; }
    [data-pc-direction="ltr"] .pc-sidebar .pc-navbar > .pc-item .pc-submenu .pc-link { padding: 8px 15px 8px 20px; }
</style>
