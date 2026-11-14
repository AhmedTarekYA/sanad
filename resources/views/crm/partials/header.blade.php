@php($crmUser = auth('crm')->user())
<header class="pc-header">
    <div class="header-wrapper">
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <li class="pc-h-item pc-sidebar-collapse"><a href="#" class="pc-head-link ms-0" id="sidebar-hide" aria-label="{{ __('auth.sidebar') }}"><i class="ti ti-menu-2"></i></a></li>
                <li class="pc-h-item pc-sidebar-popup"><a href="#" class="pc-head-link ms-0" id="mobile-collapse" aria-label="{{ __('auth.sidebar') }}"><i class="ti ti-menu-2"></i></a></li>
            </ul>
        </div>
        <div class="ms-auto">
            <ul class="list-unstyled d-flex align-items-center mb-0">
                <li class="pc-h-item"><span class="pc-head-link"><i class="ph-duotone ph-user-circle" aria-hidden="true"></i><span class="d-none d-md-inline ms-2">{{ $crmUser?->name }}</span></span></li>
                <li class="pc-h-item">
                    <form method="POST" action="{{ route('crm.logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="pc-head-link border-0 bg-transparent"><i class="ph-duotone ph-power" aria-hidden="true"></i><span class="d-none d-md-inline ms-2">{{ __('auth.logout') }}</span></button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
