@php($user = getAuthUser())
@php($avatar = $user?->image ? showFile($user->image) : asset('admin/assets/img/profile_av.png'))
@php($supportedLocales = config('laravellocalization.supportedLocales', []))
@php($isArabic = app()->getLocale() === 'ar')
<header class="pc-header"><div class="header-wrapper"><div class="me-auto pc-mob-drp"><ul class="list-unstyled"><li class="pc-h-item pc-sidebar-collapse"><a href="#" class="pc-head-link ms-0" id="sidebar-hide" aria-label="{{ __('auth.sidebar') }}"><i class="ti ti-menu-2"></i></a></li><li class="pc-h-item pc-sidebar-popup"><a href="#" class="pc-head-link ms-0" id="mobile-collapse" aria-label="{{ __('auth.sidebar') }}"><i class="ti ti-menu-2"></i></a></li><li class="pc-h-item d-none d-md-inline-flex"><div class="form-search position-relative" id="global-menu-search"><i class="ph-duotone ph-magnifying-glass icon-search"></i><input id="search-input" type="search" class="form-control" autocomplete="off" placeholder="{{ __('auth.search') }}" aria-label="{{ __('auth.search') }}"><button class="btn btn-search" type="button"><kbd>ctrl+k</kbd></button><div class="card shadow search-result" id="sidebar-search-results" hidden><div class="card-body"><small class="text-uppercase text-muted">{{ trans('auth.suggestions') }}</small><div class="list-group list-group-flush mt-2" id="sidebar-menu"></div></div></div></div></li></ul></div><div class="ms-auto"><ul class="list-unstyled d-flex align-items-center mb-0"><li class="dropdown pc-h-item d-none d-md-inline-flex"><a href="#" class="pc-head-link dropdown-toggle arrow-none" id="theme-toggle" aria-expanded="false" aria-label="Theme"><i class="ph-duotone ph-sun-dim"></i></a><div class="dropdown-menu dropdown-menu-end pc-h-dropdown" id="theme-menu"><a href="#" class="dropdown-item theme-option" data-theme-value="dark"><i class="ph-duotone ph-moon"></i><span>Dark</span></a><a href="#" class="dropdown-item theme-option" data-theme-value="light"><i class="ph-duotone ph-sun-dim"></i><span>Light</span></a><a href="#" class="dropdown-item theme-option" data-theme-value="auto"><i class="ph-duotone ph-cpu"></i><span>Auto</span></a></div></li><li class="dropdown pc-h-item d-none d-md-inline-flex"><a href="#" class="pc-head-link dropdown-toggle arrow-none nami-font-toggle-btn" id="nami-font-toggle" aria-expanded="false" aria-label="{{ $isArabic ? 'تغيير الخط' : 'Change font' }}"><i class="ph-duotone ph-text-t" aria-hidden="true"></i></a><div class="dropdown-menu dropdown-menu-end pc-h-dropdown nami-font-dropdown" id="nami-font-menu"><a href="#" class="dropdown-item nami-font-option" data-font="ibm"><span class="nami-font-sample nami-font-sample--ibm">أبجد Aa</span><small>IBM Plex Arabic</small></a><a href="#" class="dropdown-item nami-font-option" data-font="thmanya"><span class="nami-font-sample nami-font-sample--thmanya">أبجد Aa</span><small>ثمانية</small></a></div></li><li class="dropdown pc-h-item d-none d-md-inline-flex"><a href="#" class="pc-head-link head-link-primary dropdown-toggle arrow-none" id="language-toggle" aria-expanded="false" aria-label="{{ __('auth.change language') }}"><i class="ph-duotone ph-translate"></i></a><div class="dropdown-menu dropdown-menu-end pc-h-dropdown lng-dropdown" id="language-menu">@foreach($supportedLocales as $localeCode => $localeData)<a href="{{ app('laravellocalization')->getLocalizedURL($localeCode, null, [], true) }}" class="dropdown-item"><span class="language-flag" role="img" aria-label="{{ $localeCode === 'ar' ? 'السعودية' : 'English' }}">{{ $localeCode === 'ar' ? '🇸🇦' : '🇬🇧' }}</span><span>{{ $localeData['native'] ?? strtoupper($localeCode) }} <small>({{ strtoupper($localeCode) }})</small></span></a>@endforeach</div></li><li class="dropdown pc-h-item header-user-profile"><a href="#" class="pc-head-link dropdown-toggle arrow-none" id="profile-toggle" aria-expanded="false" aria-label="{{ __('auth.profile') }}"><img src="{{ $avatar }}" alt="{{ $user?->name ?? __('auth.profile') }}" class="user-avtar"></a><div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown" id="profile-menu"><div class="dropdown-header"><h5 class="m-0">{{ __('auth.profile') }}</h5></div><div class="dropdown-body"><ul class="list-group list-group-flush w-100"><li class="list-group-item"><div class="d-flex align-items-center"><img src="{{ $avatar }}" alt="" class="wid-50 rounded-circle"><div class="flex-grow-1 mx-3"><h5 class="mb-0">{{ $user?->name }}</h5><a class="link-primary" href="mailto:{{ $user?->email }}">{{ $user?->email }}</a></div></div></li><li class="list-group-item"><a href="{{ route('profile.index') }}" class="dropdown-item"><i class="ph-duotone ph-user-circle"></i><span>{{ __('auth.profile') }}</span></a></li><li class="list-group-item"><a href="{{ route('admin.logout') }}" class="dropdown-item"><i class="ph-duotone ph-power"></i><span>{{ __('auth.logout') }}</span></a></li></ul></div></div></li></ul></div></div></header>
<style>
#global-menu-search .search-result{position:absolute;top:calc(100% + 10px);inset-inline-start:0;width:min(390px,calc(100vw - 40px));z-index:1050;border:0;border-radius:14px}
#global-menu-search .search-result .list-group-item{border:0;border-radius:9px;padding:10px 12px}
.pc-header .pc-h-item>.dropdown-menu.show{display:block}
.pc-header .lng-dropdown{min-width:170px}
.pc-header .lng-dropdown .dropdown-item{display:flex;align-items:center;gap:10px}
.pc-header .lng-dropdown .language-flag{display:inline-flex;width:25px;height:22px;align-items:center;justify-content:center;font-size:20px;line-height:1}
.pc-header .lng-dropdown small{margin-inline-start:6px;color:var(--bs-secondary-color)}
.pc-header .dropdown-user-profile{width:360px;max-width:calc(100vw - 24px);padding:0;overflow:hidden}
.pc-header .dropdown-user-profile .dropdown-body{padding:0}
.pc-header .dropdown-user-profile .dropdown-item{display:flex;align-items:center;gap:10px;padding:11px 16px;border-radius:8px}
.pc-header .dropdown-user-profile .dropdown-item i{font-size:20px}
.pc-header .dropdown-user-profile .list-group-item{padding:14px 16px}
.pc-header .dropdown-user-profile .wid-50{width:50px;height:50px;object-fit:cover}
.pc-header .user-avtar{width:36px;height:36px;object-fit:cover;border-radius:50%;border:2px solid rgba(45,113,240,.18);transition:transform .2s,box-shadow .2s}
.pc-header .user-avtar:hover,.pc-header .header-user-profile:hover .user-avtar{transform:scale(1.08);box-shadow:0 0 0 4px rgba(45,113,240,.18),0 8px 16px rgba(10,25,47,.18)}
/* Font switcher */
.nami-font-toggle-btn i{font-size:20px}
.nami-font-dropdown{min-width:195px}
.nami-font-dropdown .dropdown-item{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:11px 14px;border-radius:8px}
.nami-font-dropdown .dropdown-item.is-active{color:var(--bs-primary,#2D71F0);background:color-mix(in srgb,var(--bs-primary,#2D71F0) 8%,transparent)}
.nami-font-dropdown .dropdown-item.is-active .nami-font-sample{color:var(--bs-primary,#2D71F0)}
.nami-font-dropdown small{color:var(--bs-secondary-color);font-size:11px;white-space:nowrap}
.nami-font-sample{font-size:15px;font-weight:600}
.nami-font-sample--ibm{font-family:'IBM Plex Sans Arabic',sans-serif}
.nami-font-sample--thmanya{font-family:'Thmanya',sans-serif}
</style>
<script>document.addEventListener('DOMContentLoaded',function(){function applyTheme(value){var theme=value;if(theme==='auto')theme=matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';if(typeof layout_change==='function')layout_change(theme);document.body.setAttribute('data-pc-sidebar-theme',theme==='dark'?'dark':'light')}document.querySelectorAll('.theme-option').forEach(function(option){option.addEventListener('click',function(e){e.preventDefault();const value=option.dataset.themeValue;applyTheme(value);localStorage.setItem('nami-theme',value)})});const savedTheme=localStorage.getItem('nami-theme');if(savedTheme)applyTheme(savedTheme)});</script>
<script>document.addEventListener('DOMContentLoaded',function(){const ids=['theme','language','profile','nami-font'];ids.forEach(function(name){const toggle=document.getElementById(name+'-toggle'),menu=document.getElementById(name+'-menu');if(!toggle||!menu)return;toggle.addEventListener('click',function(e){e.preventDefault();e.stopPropagation();document.querySelectorAll('.pc-header .pc-h-dropdown').forEach(function(other){if(other!==menu)other.classList.remove('show')});menu.classList.toggle('show');toggle.setAttribute('aria-expanded',menu.classList.contains('show')?'true':'false')});menu.addEventListener('click',function(e){e.stopPropagation()})});document.addEventListener('click',function(){document.querySelectorAll('.pc-header .pc-h-dropdown').forEach(function(menu){menu.classList.remove('show')})})});</script>
<script>
document.addEventListener('DOMContentLoaded',function(){
    /* ── Font switcher ── */
    var FONTS={ibm:"'IBM Plex Sans Arabic','Thmanya',sans-serif",thmanya:"'Thmanya','IBM Plex Sans Arabic',sans-serif"};
    function applyFont(name,save){
        if(!FONTS[name])name='ibm';
        var ff=FONTS[name];
        /* inject <style> to override ALL font declarations site-wide */
        var tag=document.getElementById('nami-font-override');
        if(!tag){tag=document.createElement('style');tag.id='nami-font-override';document.head.appendChild(tag);}
        tag.textContent=':root{--bs-font-sans-serif:'+ff+';--bs-body-font-family:'+ff+';}'+
            'body,button,input,select,textarea,h1,h2,h3,h4,h5,h6,p,span,a,td,th,label,small{font-family:'+ff+'!important}';
        document.querySelectorAll('.nami-font-option').forEach(function(opt){opt.classList.toggle('is-active',opt.dataset.font===name)});
        if(save)localStorage.setItem('nami-font',name);
    }
    document.querySelectorAll('.nami-font-option').forEach(function(opt){
        opt.addEventListener('click',function(e){
            e.preventDefault();
            applyFont(opt.dataset.font,true);
            var m=document.getElementById('nami-font-menu');
            if(m)m.classList.remove('show');
            var t=document.getElementById('nami-font-toggle');
            if(t)t.setAttribute('aria-expanded','false');
        });
    });
    applyFont(localStorage.getItem('nami-font')||'ibm',false);

    /* ── Restore saved settings ── */
    function rgb(hex){var v=hex.replace('#',''),f=v.length===3?v.split('').map(function(x){return x+x}).join(''):v;return parseInt(f.substring(0,2),16)+', '+parseInt(f.substring(2,4),16)+', '+parseInt(f.substring(4,6),16)}
    function applyColor(color){document.body.style.setProperty('--bs-primary',color);document.body.style.setProperty('--bs-primary-rgb',rgb(color));document.body.style.setProperty('--bs-blue',color);document.body.style.setProperty('--pc-sidebar-active-color',color);document.body.style.setProperty('--bs-link-color',color);document.body.style.setProperty('--bs-link-color-rgb',rgb(color));document.body.style.setProperty('--bs-link-hover-color','color-mix(in srgb,'+color+' 78%,black)');document.body.style.setProperty('--bs-primary-light','color-mix(in srgb,'+color+' 12%,white)');document.body.style.setProperty('--bs-primary-dark','color-mix(in srgb,'+color+' 82%,black)');document.body.style.setProperty('--nami-primary-hover','color-mix(in srgb,'+color+' 78%,black)')}
    var savedColor=localStorage.getItem('nami-primary-color');
    if(savedColor)applyColor(savedColor);
    function applyDensity(v){document.body.classList.remove('nami-density-comfortable','nami-density-normal','nami-density-compact');document.body.classList.add('nami-density-'+v)}
    function applyRadius(v){document.body.classList.remove('nami-radius-sharp','nami-radius-normal','nami-radius-round');document.body.classList.add('nami-radius-'+v)}
    function applyIcons(v){document.body.classList.toggle('nami-icons-muted',v==='muted')}
    function applySidebar(v){var s=document.querySelector('.pc-sidebar');if(s)s.classList.toggle('pc-sidebar-hide',v==='compact')}
    applyDensity(localStorage.getItem('nami-density')||'normal');
    applyRadius(localStorage.getItem('nami-radius')||'normal');
    applyIcons(localStorage.getItem('nami-icon-mode')||'color');
    applySidebar(localStorage.getItem('nami-sidebar-mode')||'full');
});
</script>
