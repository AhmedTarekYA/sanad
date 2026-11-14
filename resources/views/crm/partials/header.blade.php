@php($crmUser = auth('crm')->user())
@php($crmAvatar = $crmUser?->image ? showFile($crmUser->image) : asset('admin/assets/images/user/avatar-1.jpg'))
@php($supportedLocales = config('laravellocalization.supportedLocales', []))
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
                <li class="dropdown pc-h-item">
                    <a href="#" class="pc-head-link dropdown-toggle arrow-none" id="language-toggle" aria-expanded="false" aria-label="{{ __('auth.change language') }}"><i class="ph-duotone ph-translate"></i></a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown lng-dropdown" id="language-menu">
                        @foreach($supportedLocales as $localeCode => $localeData)
                            <a href="{{ app('laravellocalization')->getLocalizedURL($localeCode, null, [], true) }}" class="dropdown-item">
                                <span class="language-flag" role="img" aria-label="{{ $localeCode === 'ar' ? 'السعودية' : 'English' }}">{{ $localeCode === 'ar' ? '🇸🇦' : '🇬🇧' }}</span>
                                <span>{{ $localeData['native'] ?? strtoupper($localeCode) }} <small>({{ strtoupper($localeCode) }})</small></span>
                            </a>
                        @endforeach
                    </div>
                </li>
                <li class="pc-h-item"><span class="pc-head-link"><img src="{{ $crmAvatar }}" alt="{{ $crmUser?->name }}" class="user-avtar"><span class="d-none d-md-inline ms-2">{{ $crmUser?->name }}</span></span></li>
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
<style>
.pc-header .pc-h-item>.dropdown-menu.show{display:block}
.pc-header .lng-dropdown{min-width:170px}
.pc-header .lng-dropdown .dropdown-item{display:flex;align-items:center;gap:10px}
.pc-header .lng-dropdown .language-flag{display:inline-flex;width:25px;height:22px;align-items:center;justify-content:center;font-size:20px;line-height:1}
.pc-header .lng-dropdown small{margin-inline-start:6px;color:var(--bs-secondary-color)}
.pc-header .user-avtar{width:36px;height:36px;object-fit:cover;border-radius:50%;border:2px solid rgba(45,113,240,.18)}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
    const ids=['language'];
    ids.forEach(function(name){
        const toggle=document.getElementById(name+'-toggle'),menu=document.getElementById(name+'-menu');
        if(!toggle||!menu)return;
        toggle.addEventListener('click',function(e){
            e.preventDefault();
            e.stopPropagation();
            document.querySelectorAll('.pc-header .pc-h-dropdown').forEach(function(other){if(other!==menu)other.classList.remove('show')});
            menu.classList.toggle('show');
            toggle.setAttribute('aria-expanded',menu.classList.contains('show')?'true':'false');
        });
        menu.addEventListener('click',function(e){e.stopPropagation()});
    });
    document.addEventListener('click',function(){document.querySelectorAll('.pc-header .pc-h-dropdown').forEach(function(menu){menu.classList.remove('show')})});
});
</script>
