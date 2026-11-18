@php($currentRoute = Route::currentRouteName())
@php($crmUser = auth('crm')->user())
@php($sidebarLogo = asset('brand/crm_logo.png'))
@php($whatsappPages = [
    'whatsapp_business_settings' => 'fal fa-gear',
    'whatsapp_setup'             => 'fal fa-plug',
    'whatsapp_chat'              => 'fal fa-comment-dots',
    'whatsapp_broadcasts'        => 'fal fa-bullhorn',
    'whatsapp_contacts'          => 'fal fa-address-book',
    'whatsapp_labels'            => 'fal fa-tag',
    'whatsapp_quick_replies'     => 'fal fa-bolt',
    'whatsapp_business_hours'    => 'fal fa-clock',
    'whatsapp_analytics'         => 'fal fa-chart-bar',
])
<nav class="pc-sidebar wb-crm-compact" id="crm-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header"><a href="{{ route('crm.dashboard') }}" class="b-brand text-primary crm-sidebar-logo-badge">
                <img src="{{ $sidebarLogo }}" alt="{{ $settings->website_name ?? config('app.name') }}"
                     class="crm-sidebar-logo"
                     onerror="this.onerror=null;this.src='{{ asset('brand/logo.svg') }}';">
            </a></div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption"><label><i class="fab fa-whatsapp me-1" aria-hidden="true"></i>{{ __('whatsapp_menu') }}</label></li>
                <li class="pc-item {{ $currentRoute === 'crm.dashboard' ? 'active' : '' }}">
                    <a href="{{ route('crm.dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="fal fa-house" aria-hidden="true"></i></span>
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
                            <span class="pc-micon"><i class="fal fa-cart-shopping" aria-hidden="true"></i></span>
                            <span class="pc-mtext">{{ __('crm_sales') }}</span>
                        </a>
                    </li>
                @endif

                @if($crmUser && $crmUser->role === 'admin')
                    <li class="pc-item pc-caption"><label>{{ __('management') }}</label></li>
                    <li class="pc-item {{ $currentRoute === 'crm.users.index' ? 'active' : '' }}">
                        <a class="pc-link" href="{{ route('crm.users.index') }}">
                            <span class="pc-micon"><i class="fal fa-users" aria-hidden="true"></i></span>
                            <span class="pc-mtext">{{ __('users') }}</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <button type="button" class="wb-crm-sidebar-handle" id="crm-sidebar-mode" aria-pressed="false"
            title="{{ __('sidebar_expand') }}" aria-label="{{ __('sidebar_expand') }}">
        <svg class="wb-crm-sidebar-handle-shape" viewBox="0 0 30 132" preserveAspectRatio="none" aria-hidden="true">
            <path d="M0 0 C0 36 30 34 30 66 C30 98 0 96 0 132 Z"/>
        </svg>
        <span class="wb-crm-sidebar-handle-grip">
            <span></span><span></span><span></span>
        </span>
        <i class="fal fa-chevron-right" aria-hidden="true"></i>
    </button>

<style>
.crm-sidebar-logo-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: #fff;
    box-shadow: 0 4px 10px rgba(10, 22, 60, .18);
    flex: 0 0 auto;
}
.crm-sidebar-logo {
    display: block;
    width: 26px;
    height: 26px;
    max-width: 26px;
    max-height: 26px;
    flex: 0 0 auto;
    object-fit: contain;
}

/* ===== Brand-colored CRM sidebar: vertical icon-over-label cards ===== */
:root {
    --wb-crm-brand: #305bff;
    --wb-crm-brand-tint: rgba(255, 255, 255, .14);
}

.pc-sidebar.wb-crm-compact {
    background: var(--wb-crm-brand);
    border-inline-end: 0;
    --pc-sidebar-color: #fff;
    --pc-sidebar-active-color: var(--wb-crm-brand);
}
.pc-sidebar.wb-crm-compact .pc-navbar > .pc-item > .pc-link::after,
.pc-sidebar.wb-crm-compact .pc-navbar > .pc-item.active > .pc-link::after {
    display: none !important;
    background: transparent !important;
    content: none !important;
}
.pc-sidebar.wb-crm-compact .navbar-wrapper,
.pc-sidebar.wb-crm-compact .navbar-content {
    background: transparent;
}
.pc-sidebar.wb-crm-compact .m-header {
    border-bottom: 1px solid rgba(255, 255, 255, .14);
}
.pc-sidebar.wb-crm-compact .pc-caption label {
    color: rgba(255, 255, 255, .5);
    letter-spacing: .04em;
}
.pc-sidebar.wb-crm-compact .pc-arrow {
    color: rgba(255, 255, 255, .6);
}

.pc-sidebar.wb-crm-compact .pc-item {
    margin: 6px 10px;
    outline: none;
}
.pc-sidebar.wb-crm-compact .pc-item:focus,
.pc-sidebar.wb-crm-compact .pc-item:focus-visible,
.pc-sidebar.wb-crm-compact *:focus,
.pc-sidebar.wb-crm-compact *:focus-visible,
.pc-sidebar.wb-crm-compact *:focus-within {
    outline: none !important;
    box-shadow: none !important;
}

.pc-sidebar.wb-crm-compact .pc-link {
    display: flex !important;
    flex-direction: column !important;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-height: 64px;
    padding: 10px 6px;
    border-radius: 16px;
    text-align: center !important;
    color: #fff !important;
    background: transparent;
    outline: none;
    box-shadow: none;
    -webkit-tap-highlight-color: transparent;
    transition: background .25s ease, color .25s ease, box-shadow .25s ease;
}
.pc-sidebar.wb-crm-compact .pc-link:hover,
.pc-sidebar.wb-crm-compact .pc-link:focus,
.pc-sidebar.wb-crm-compact .pc-link:focus-visible,
.pc-sidebar.wb-crm-compact .pc-link:active {
    background: rgba(255, 255, 255, .12);
    color: #fff !important;
    outline: none;
    box-shadow: none;
    transform: none;
}

.pc-sidebar.wb-crm-compact .pc-micon {
    width: auto;
    height: auto;
    margin: 0 !important;
    line-height: 1;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .25s ease;
}
.pc-sidebar.wb-crm-compact .pc-micon i {
    font-size: 19px;
    color: inherit !important;
}

.pc-sidebar.wb-crm-compact .pc-mtext {
    display: none;
    max-width: 100%;
    font-size: 11px;
    font-weight: 600;
    line-height: 1.2;
    white-space: normal;
    text-align: center;
    color: inherit !important;
    opacity: 1 !important;
}

/* Active item: white rounded card + brand-blue icon badge */
.pc-sidebar.wb-crm-compact .pc-item.active .pc-link {
    background: #fff !important;
    color: var(--wb-crm-brand) !important;
    border: 0 !important;
    outline: none !important;
    box-shadow: 0 10px 22px rgba(10, 22, 60, .22) !important;
}
.pc-sidebar.wb-crm-compact .pc-item.active .pc-link:hover {
    background: #fff !important;
    color: var(--wb-crm-brand) !important;
}
.pc-sidebar.wb-crm-compact .pc-item.active {
    border: 0 !important;
    outline: none !important;
    background: transparent !important;
}
.pc-sidebar.wb-crm-compact .pc-item.active .pc-micon {
    width: 38px;
    height: 38px;
    background: rgba(48, 91, 255, .12) !important;
}
.pc-sidebar.wb-crm-compact .pc-item.active .pc-micon i {
    color: var(--wb-crm-brand) !important;
}

/* Drag/pin handle: a curved "curtain pull" tab bulging from the sidebar edge */
.wb-crm-sidebar-handle {
    display: none;
    flex-direction: column;
    position: absolute;
    top: 50%;
    inset-inline-end: -20px;
    transform: translateY(-50%);
    width: 30px;
    height: 76px;
    border: 0;
    border-radius: 0 50% 50% 0 / 0 40% 40% 0;
    background: #fff;
    color: var(--wb-crm-brand);
    box-shadow: 4px 0 16px rgba(10, 22, 60, .28);
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: ew-resize;
    z-index: 1052;
    transition: box-shadow .2s ease, background .2s ease, height .2s ease, width .2s ease;
    touch-action: none;
}
[data-pc-direction="rtl"] .wb-crm-sidebar-handle {
    border-radius: 50% 0 0 50% / 40% 0 0 40%;
    box-shadow: -4px 0 16px rgba(10, 22, 60, .28);
}
.wb-crm-sidebar-handle:hover {
    box-shadow: 6px 0 20px rgba(10, 22, 60, .34);
    height: 86px;
    width: 34px;
}
[data-pc-direction="rtl"] .wb-crm-sidebar-handle:hover {
    box-shadow: -6px 0 20px rgba(10, 22, 60, .34);
}
.wb-crm-sidebar-handle i {
    font-size: 12px;
    transition: transform .25s ease;
}
.wb-crm-sidebar-handle-grip {
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.wb-crm-sidebar-handle-grip span {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: currentColor;
    opacity: .45;
}
[data-pc-direction="rtl"] .wb-crm-sidebar-handle {
    inset-inline-end: auto;
    inset-inline-start: -14px;
}
.pc-sidebar.wb-crm-compact.wb-crm-dragging {
    transition: none !important;
}
.pc-sidebar.wb-crm-compact.wb-crm-dragging .navbar-wrapper,
.pc-sidebar.wb-crm-compact.wb-crm-dragging .navbar-content,
.pc-sidebar.wb-crm-compact.wb-crm-dragging .m-header {
    transition: none !important;
}

/* Compact CRM sidebar: narrow icon-only rail that expands over the page on hover */
@media (min-width: 1025px) {
    .wb-crm-sidebar-handle {
        display: flex;
    }
    .pc-sidebar.wb-crm-compact {
        width: 94px;
        transition: width .3s cubic-bezier(.4, 0, .2, 1), box-shadow .3s ease;
    }
    .pc-sidebar.wb-crm-compact .navbar-wrapper,
    .pc-sidebar.wb-crm-compact .navbar-content {
        width: 94px;
        transition: width .3s cubic-bezier(.4, 0, .2, 1);
        overflow-x: hidden;
    }
    .pc-sidebar.wb-crm-compact .m-header {
        width: 94px;
        padding: 16px 12px;
        justify-content: center;
        transition: width .3s cubic-bezier(.4, 0, .2, 1), padding .3s ease;
    }
    .pc-sidebar.wb-crm-compact .m-header .b-brand,
    .pc-sidebar.wb-crm-compact .m-header .logo-lg {
        max-width: 52px;
        margin: 0 auto;
    }
    .pc-sidebar.wb-crm-compact .pc-navbar {
        padding-inline: 6px;
        transition: padding .3s ease;
    }
    .pc-sidebar.wb-crm-compact .pc-caption {
        display: none;
    }
    .pc-sidebar.wb-crm-compact .pc-arrow {
        display: none;
    }

    /* No hover-preview: the rail only expands via an explicit click/drag on the
       handle (setPinned). This keeps the handle's position stable under the
       cursor and guarantees content is always pushed, never overlaid. */

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

    /* RTL: mirror the compact rail offsets */
    [data-pc-direction="rtl"] .pc-sidebar.wb-crm-compact:not(.pc-sidebar-hide) ~ .pc-container,
    [data-pc-direction="rtl"] .pc-sidebar.wb-crm-compact:not(.pc-sidebar-hide) ~ .pc-footer {
        margin-left: 0;
        margin-right: 94px;
    }
    [data-pc-direction="rtl"] .pc-sidebar.wb-crm-compact:not(.pc-sidebar-hide) ~ .pc-header {
        left: 0;
        right: 94px;
    }
    [data-pc-direction="rtl"] .pc-sidebar.wb-crm-compact.pc-sidebar-hide ~ .pc-container,
    [data-pc-direction="rtl"] .pc-sidebar.wb-crm-compact.pc-sidebar-hide ~ .pc-footer {
        margin-right: 0;
    }
    [data-pc-direction="rtl"] .pc-sidebar.wb-crm-compact.pc-sidebar-hide ~ .pc-header {
        right: 0;
    }

    /* Pinned (normal) mode: always expanded, hover behaviour disabled.
       !important is required here to beat the base .wb-crm-compact width
       rule above, which otherwise wins despite lower specificity (same
       pattern already used elsewhere in this file to beat shared CSS). */
    .pc-sidebar.wb-crm-compact.wb-crm-pinned,
    .pc-sidebar.wb-crm-compact.wb-crm-pinned:not(.pc-sidebar-hide):hover,
    .pc-sidebar.wb-crm-compact.wb-crm-pinned:not(.pc-sidebar-hide):focus-within {
        width: 158px !important;
        box-shadow: none;
    }
    .pc-sidebar.wb-crm-compact.wb-crm-pinned .navbar-wrapper,
    .pc-sidebar.wb-crm-compact.wb-crm-pinned .navbar-content,
    .pc-sidebar.wb-crm-compact.wb-crm-pinned .m-header {
        width: 158px !important;
    }
    .pc-sidebar.wb-crm-compact.wb-crm-pinned .pc-navbar {
        padding-inline: 10px !important;
    }
    .pc-sidebar.wb-crm-compact.wb-crm-pinned .pc-caption {
        display: block !important;
    }
    .pc-sidebar.wb-crm-compact.wb-crm-pinned .pc-mtext {
        display: block !important;
    }
    .pc-sidebar.wb-crm-compact.wb-crm-pinned .wb-crm-sidebar-handle i {
        transform: rotate(180deg);
    }
    .pc-sidebar.wb-crm-compact.wb-crm-pinned ~ .pc-container,
    .pc-sidebar.wb-crm-compact.wb-crm-pinned ~ .pc-footer {
        margin-left: 158px !important;
    }
    .pc-sidebar.wb-crm-compact.wb-crm-pinned ~ .pc-header {
        left: 158px !important;
    }
    [data-pc-direction="rtl"] .pc-sidebar.wb-crm-compact.wb-crm-pinned ~ .pc-container,
    [data-pc-direction="rtl"] .pc-sidebar.wb-crm-compact.wb-crm-pinned ~ .pc-footer {
        margin-left: 0 !important;
        margin-right: 158px !important;
    }
    [data-pc-direction="rtl"] .pc-sidebar.wb-crm-compact.wb-crm-pinned ~ .pc-header {
        left: 0 !important;
        right: 158px !important;
    }

    /* Hidden state wins over pinned mode */
    .pc-sidebar.wb-crm-compact.wb-crm-pinned.pc-sidebar-hide {
        width: 0 !important;
    }
    .pc-sidebar.wb-crm-compact.wb-crm-pinned.pc-sidebar-hide ~ .pc-container,
    .pc-sidebar.wb-crm-compact.wb-crm-pinned.pc-sidebar-hide ~ .pc-footer {
        margin-left: 0 !important;
    }
    .pc-sidebar.wb-crm-compact.wb-crm-pinned.pc-sidebar-hide ~ .pc-header {
        left: 0 !important;
    }
    [data-pc-direction="rtl"] .pc-sidebar.wb-crm-compact.wb-crm-pinned.pc-sidebar-hide ~ .pc-container,
    [data-pc-direction="rtl"] .pc-sidebar.wb-crm-compact.wb-crm-pinned.pc-sidebar-hide ~ .pc-footer {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    [data-pc-direction="rtl"] .pc-sidebar.wb-crm-compact.wb-crm-pinned.pc-sidebar-hide ~ .pc-header {
        left: 0 !important;
        right: 0 !important;
    }
}
/* ===== Id-scoped overrides: beat shared sanad-ui.css (dark accent green, gray links) ===== */
#crm-sidebar .pc-navbar {
    padding-inline: 0 !important;
}
#crm-sidebar .pc-navbar > .pc-item:not(.pc-caption) {
    margin: 6px 10px;
}
#crm-sidebar .pc-navbar > .pc-item > .pc-link,
#crm-sidebar .pc-navbar > .pc-item:not(.active) > .pc-link:hover {
    color: #fff !important;
    margin-inline: 0 !important;
    border: 0 !important;
    box-shadow: none !important;
}
#crm-sidebar .pc-navbar > .pc-item:not(.active) > .pc-link:hover {
    background: rgba(255, 255, 255, .12) !important;
}
#crm-sidebar .pc-navbar > .pc-item.active {
    margin-inline: 0 !important;
}
#crm-sidebar .pc-navbar > .pc-item.active > .pc-link,
#crm-sidebar .pc-navbar > .pc-item.active > .pc-link:hover,
#crm-sidebar .pc-navbar > .pc-item.active > .pc-link:focus {
    background: #fff !important;
    color: var(--wb-crm-brand) !important;
    border: 0 !important;
    border-radius: 0 !important;
    box-shadow: none !important;
}
#crm-sidebar .pc-navbar > .pc-item.active > .pc-link .pc-micon i,
#crm-sidebar .pc-navbar > .pc-item.active > .pc-link .pc-mtext {
    color: var(--wb-crm-brand) !important;
}
#crm-sidebar .pc-navbar > .pc-item > .pc-link::before,
#crm-sidebar .pc-navbar > .pc-item > .pc-link::after {
    content: none !important;
    display: none !important;
}

/* Curved bump handle: same blue as the sidebar, bulging out of its edge */
#crm-sidebar {
    overflow: visible !important;
}
#crm-sidebar .wb-crm-sidebar-handle {
    inset-inline-start: auto;
    inset-inline-end: -29px;
    width: 30px;
    height: 132px;
    padding: 0;
    padding-inline-end: 6px;
    gap: 6px;
    border-radius: 0;
    background: transparent;
    box-shadow: none;
    color: #fff;
    filter: drop-shadow(3px 0 6px rgba(10, 22, 60, .25));
}
#crm-sidebar .wb-crm-sidebar-handle:hover {
    filter: drop-shadow(3px 0 10px rgba(10, 22, 60, .4));
}
#crm-sidebar .wb-crm-sidebar-handle-shape {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    fill: var(--wb-crm-brand);
    z-index: -1;
    transition: transform .2s ease, fill .2s ease;
    transform-origin: left center;
}
#crm-sidebar .wb-crm-sidebar-handle:hover .wb-crm-sidebar-handle-shape {
    transform: scale(1.05);
    fill: #2449d6;
}
#crm-sidebar .wb-crm-sidebar-handle-grip,
#crm-sidebar .wb-crm-sidebar-handle i {
    position: relative;
    z-index: 1;
}
#crm-sidebar .wb-crm-sidebar-handle-grip span {
    opacity: .7;
}
#crm-sidebar .wb-crm-sidebar-handle:hover .wb-crm-sidebar-handle-grip span {
    opacity: 1;
}
[data-pc-direction="rtl"] #crm-sidebar .wb-crm-sidebar-handle {
    inset-inline-start: auto;
    inset-inline-end: -29px;
    filter: drop-shadow(-3px 0 6px rgba(10, 22, 60, .25));
}
[data-pc-direction="rtl"] #crm-sidebar .wb-crm-sidebar-handle:hover {
    filter: drop-shadow(-3px 0 10px rgba(10, 22, 60, .4));
}
[data-pc-direction="rtl"] #crm-sidebar .wb-crm-sidebar-handle-shape {
    transform: scaleX(-1);
    transform-origin: center;
}
[data-pc-direction="rtl"] #crm-sidebar .wb-crm-sidebar-handle:hover .wb-crm-sidebar-handle-shape {
    transform: scaleX(-1) scale(1.05);
    transform-origin: center;
}
</style>
</nav>
<script>
(function () {
    try {
        if (localStorage.getItem('sanad-crm-sidebar') === 'expanded') {
            var sidebar = document.querySelector('.pc-sidebar.wb-crm-compact');
            if (sidebar) {
                sidebar.classList.add('wb-crm-pinned');
            }
        }
    } catch (error) {}
})();

document.addEventListener('DOMContentLoaded', function () {
    var sidebar = document.querySelector('.pc-sidebar.wb-crm-compact');
    var handle = document.querySelector('.wb-crm-sidebar-handle');
    if (!sidebar || !handle) {
        return;
    }

    function getDir() {
        return document.documentElement.getAttribute('dir')
            || document.body.getAttribute('dir')
            || (document.body.getAttribute('data-pc-direction') === 'rtl' ? 'rtl' : 'ltr');
    }

    function setPinned(pinned) {
        if (typeof window.applyCrmSidebarMode === 'function') {
            window.applyCrmSidebarMode(pinned ? 'expanded' : 'compact');
        } else {
            sidebar.classList.toggle('wb-crm-pinned', pinned);
        }
        try {
            localStorage.setItem('sanad-crm-sidebar', pinned ? 'expanded' : 'compact');
        } catch (error) {}
    }

    var dragging = false;
    var startX = 0;
    var moved = 0;
    var threshold = 50;

    function pointerX(e) {
        if (typeof e.clientX === 'number') {
            return e.clientX;
        }
        if (e.touches && e.touches[0]) {
            return e.touches[0].clientX;
        }
        if (e.changedTouches && e.changedTouches[0]) {
            return e.changedTouches[0].clientX;
        }
        return null;
    }

    function onDown(e) {
        dragging = true;
        moved = 0;
        startX = pointerX(e);
        sidebar.classList.add('wb-crm-dragging');
        document.addEventListener('mousemove', onMove);
        document.addEventListener('mouseup', onUp);
        document.addEventListener('touchmove', onMove, { passive: false });
        document.addEventListener('touchend', onUp);
        e.preventDefault();
    }

    function onMove(e) {
        if (!dragging) {
            return;
        }
        var x = pointerX(e);
        if (x === null || startX === null) {
            return;
        }
        var delta = x - startX;
        moved = getDir() === 'rtl' ? -delta : delta;
        if (e.cancelable) {
            e.preventDefault();
        }
    }

    function onUp() {
        if (!dragging) {
            return;
        }
        dragging = false;
        sidebar.classList.remove('wb-crm-dragging');
        var currentlyPinned = sidebar.classList.contains('wb-crm-pinned');
        var absMoved = Math.abs(moved);
        if (absMoved < 8) {
            setPinned(!currentlyPinned);
        } else if (!currentlyPinned && moved > threshold) {
            setPinned(true);
        } else if (currentlyPinned && moved < -threshold) {
            setPinned(false);
        }
        document.removeEventListener('mousemove', onMove);
        document.removeEventListener('mouseup', onUp);
        document.removeEventListener('touchmove', onMove);
        document.removeEventListener('touchend', onUp);
    }

    handle.addEventListener('mousedown', onDown);
    handle.addEventListener('touchstart', onDown, { passive: false });
});
</script>
