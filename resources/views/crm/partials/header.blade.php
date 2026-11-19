@php($crmUser = auth('crm')->user())
@php($crmAvatar = showFile($crmUser?->image, 'admin'))
@php($supportedLocales = config('laravellocalization.supportedLocales', []))
<header class="pc-header">
    <div class="header-wrapper">
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <li class="pc-h-item pc-sidebar-collapse"><a href="#" class="pc-head-link ms-0" id="sidebar-hide" aria-label="{{ __('auth.sidebar') }}"><i class="fas fa-bars"></i></a></li>
                <li class="pc-h-item pc-sidebar-popup"><a href="#" class="pc-head-link ms-0" id="mobile-collapse" aria-label="{{ __('auth.sidebar') }}"><i class="fas fa-bars"></i></a></li>
            </ul>
        </div>
        <div class="ms-auto">
            <ul class="list-unstyled d-flex align-items-center mb-0">
                <li class="pc-h-item crm-clock-item d-none d-md-flex">
                    <div class="crm-clock" title="{{ __('date') }}">
                        <div class="crm-clock-text">
                            <span class="crm-clock-date" id="crm-live-date"></span>
                            <span class="crm-clock-time" id="crm-live-time">
                                <span class="crm-clock-hour" id="crm-live-hour"></span><span class="crm-clock-minute" id="crm-live-minute"></span><span class="crm-clock-second" id="crm-live-second"></span><span class="crm-clock-period" id="crm-live-period"></span>
                            </span>
                        </div>
                    </div>
                </li>
                <li class="pc-h-item">
                    <a href="#" class="pc-head-link arrow-none" id="theme-toggle" aria-label="Theme"><i class="fal fa-sun" id="theme-toggle-icon"></i></a>
                </li>
                <li class="dropdown pc-h-item">
                    <a href="#" class="pc-head-link dropdown-toggle arrow-none" id="language-toggle" aria-expanded="false" aria-label="{{ __('auth.change language') }}"><i class="fas fa-language"></i></a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown lng-dropdown" id="language-menu">
                        @foreach($supportedLocales as $localeCode => $localeData)
                            <a href="{{ route('crm.lang', $localeCode) }}" class="dropdown-item">
                                <span class="language-flag" role="img" aria-label="{{ $localeCode === 'ar' ? 'السعودية' : 'English' }}">{{ $localeCode === 'ar' ? '🇸🇦' : '🇬🇧' }}</span>
                                <span>{{ $localeData['native'] ?? strtoupper($localeCode) }} <small>({{ strtoupper($localeCode) }})</small></span>
                            </a>
                        @endforeach
                    </div>
                </li>
                <li class="dropdown pc-h-item header-user-profile">
                    <a href="#" class="pc-head-link dropdown-toggle arrow-none" id="profile-toggle" aria-expanded="false" aria-label="{{ __('auth.profile') }}"><img src="{{ $crmAvatar }}" alt="{{ $crmUser?->name }}" class="user-avtar"></a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown crm-profile-dropdown" id="profile-menu">
                        <div class="dropdown-body">
                            <div class="d-flex align-items-center px-3 py-2">
                                <img src="{{ $crmAvatar }}" alt="" class="wid-40 rounded-circle">
                                <div class="flex-grow-1 mx-2 text-truncate">
                                    <h6 class="mb-0 text-truncate">{{ $crmUser?->name }}</h6>
                                    <small class="text-muted text-truncate d-block">{{ $crmUser?->email }}</small>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('crm.logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start"><i class="fas fa-power-off me-2" aria-hidden="true"></i>{{ __('auth.logout') }}</button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
<style>
/* CRM header: branded gradient bar with live date/time */
.pc-header {
    background: #0b0c10;
    --pc-header-color: #fff;
    --pc-active-background: rgba(255, 255, 255, .14);
    color: #fff;
    box-shadow: none;
    border-bottom: 1px solid rgba(255, 255, 255, .08);
    -webkit-backdrop-filter: none;
    backdrop-filter: none;
}
[data-pc-theme="dark"] .pc-header {
    background: #0b0c10;
}
.pc-header .header-wrapper { align-items: center; }
.pc-header .pc-head-link { box-shadow: none; }
.pc-header .pc-h-item>.dropdown-menu.show{display:block}
.pc-header .lng-dropdown{min-width:170px}
.pc-header .lng-dropdown .dropdown-item{display:flex;align-items:center;gap:10px}
.pc-header .lng-dropdown .language-flag{display:inline-flex;width:25px;height:22px;align-items:center;justify-content:center;font-size:20px;line-height:1}
.pc-header .lng-dropdown small{margin-inline-start:6px;color:var(--bs-secondary-color)}
.pc-header .user-avtar{width:36px;height:36px;object-fit:cover;border-radius:50%;border:2px solid rgba(255,255,255,.72);box-shadow:0 0 0 3px rgba(255,255,255,.14);cursor:pointer}
.pc-header .crm-profile-dropdown{min-width:240px;padding:8px 0}
.pc-header .crm-profile-dropdown .wid-40{width:40px;height:40px;object-fit:cover}
.pc-header .crm-profile-dropdown .dropdown-item{padding:8px 16px}

/* Live clock */
.pc-header .crm-clock-item{min-height:74px;margin-inline-end:10px}
.pc-header .crm-clock{display:flex;align-items:center;gap:12px;color:#fff}
.pc-header .crm-clock-text{display:flex;flex-direction:column;line-height:1.1;gap:3px}
.pc-header .crm-clock-date{font-size:10.5px;font-weight:500;letter-spacing:.02em;opacity:.78;white-space:nowrap;text-transform:capitalize}
.pc-header .crm-clock-time{display:flex;align-items:baseline;gap:1px;font-variant-numeric:tabular-nums;white-space:nowrap;line-height:1}
.pc-header .crm-clock-hour{font-size:24px;font-weight:800;letter-spacing:.01em;background:linear-gradient(90deg,#fff,rgba(255,255,255,.82));-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent}
.pc-header .crm-clock-minute{font-size:14.5px;font-weight:600;opacity:.85}
.pc-header .crm-clock-second{font-size:11px;font-weight:500;opacity:.62;margin-inline-start:2px}
.pc-header .crm-clock-period{font-size:10.5px;font-weight:600;letter-spacing:.06em;opacity:.7;margin-inline-start:4px;text-transform:uppercase}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){
    var themeToggle=document.getElementById('theme-toggle'),themeToggleIcon=document.getElementById('theme-toggle-icon');
    function applyTheme(value){var theme=value==='dark'?'dark':'light';if(typeof layout_change==='function')layout_change(theme);document.body.setAttribute('data-pc-theme',theme);document.body.setAttribute('data-pc-sidebar-theme',theme==='dark'?'dark':'light');if(themeToggleIcon)themeToggleIcon.className=theme==='dark'?'fal fa-moon':'fal fa-sun';if(themeToggle)themeToggle.setAttribute('aria-label',theme==='dark'?'Dark':'Light')}
    if(themeToggle){themeToggle.addEventListener('click',function(e){e.preventDefault();var next=document.body.getAttribute('data-pc-theme')==='dark'?'light':'dark';applyTheme(next);localStorage.setItem('sanad-theme',next)})}
    var savedTheme=localStorage.getItem('sanad-theme');if(savedTheme==='auto')savedTheme=matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';if(savedTheme)applyTheme(savedTheme);else applyTheme(document.body.getAttribute('data-pc-theme'));
    const ids=['language','profile'];
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

    var crmSidebar=document.querySelector('.pc-sidebar.wb-crm-compact');
    var crmSidebarMode=document.getElementById('crm-sidebar-mode');
    var crmSidebarLabels={expand:"{{ __('sidebar_expand') }}",collapse:"{{ __('sidebar_collapse') }}"};
    function applyCrmSidebarMode(mode){
        if(!crmSidebar)return;
        var pinned=mode==='expanded';
        crmSidebar.classList.toggle('wb-crm-pinned',pinned);
        if(crmSidebarMode){
            var label=pinned?crmSidebarLabels.collapse:crmSidebarLabels.expand;
            crmSidebarMode.setAttribute('aria-pressed',pinned?'true':'false');
            crmSidebarMode.setAttribute('title',label);
            crmSidebarMode.setAttribute('aria-label',label);
        }
    }
    window.applyCrmSidebarMode=applyCrmSidebarMode;
    if(crmSidebar&&crmSidebarMode){
        var crmSidebarStored='compact';
        try{crmSidebarStored=localStorage.getItem('sanad-crm-sidebar')||'compact'}catch(error){}
        applyCrmSidebarMode(crmSidebarStored);
        // Click/drag-to-pin is handled by sidebar.blade.php's own mousedown/mouseup
        // listeners on this same button (they call window.applyCrmSidebarMode above).
        // Do not also bind a 'click' listener here: mousedown+mouseup there would
        // toggle it open, then the native 'click' firing right after would toggle
        // it straight back closed.
    }

    var clockDate=document.getElementById('crm-live-date'),clockHour=document.getElementById('crm-live-hour'),clockMinute=document.getElementById('crm-live-minute'),clockSecond=document.getElementById('crm-live-second'),clockPeriod=document.getElementById('crm-live-period');
    if(clockDate&&clockHour&&clockMinute){
        var clockLocale=document.documentElement.lang||'en';
        var dateFormatter,timeFormatter;
        try{
            dateFormatter=new Intl.DateTimeFormat(clockLocale,{day:'numeric',month:'long',year:'numeric'});
            timeFormatter=new Intl.DateTimeFormat(clockLocale,{hour:'2-digit',minute:'2-digit',second:'2-digit',hour12:true});
        }catch(error){
            dateFormatter=new Intl.DateTimeFormat('en',{day:'numeric',month:'long',year:'numeric'});
            timeFormatter=new Intl.DateTimeFormat('en',{hour:'2-digit',minute:'2-digit',second:'2-digit',hour12:true});
        }
        function updateClock(){
            var now=new Date();
            clockDate.textContent=dateFormatter.format(now);
            if(typeof timeFormatter.formatToParts==='function'){
                var parts={};
                timeFormatter.formatToParts(now).forEach(function(part){parts[part.type]=part.value});
                clockHour.textContent=parts.hour||'';
                clockMinute.textContent=parts.minute?':'+parts.minute:'';
                if(clockSecond)clockSecond.textContent=parts.second?':'+parts.second:'';
                if(clockPeriod)clockPeriod.textContent=parts.dayPeriod?parts.dayPeriod.replace(/\s/g,''):'';
            }else{
                clockHour.textContent=timeFormatter.format(now);
                clockMinute.textContent='';
                if(clockSecond)clockSecond.textContent='';
                if(clockPeriod)clockPeriod.textContent='';
            }
        }
        updateClock();
        setInterval(updateClock,1000);
    }
});
</script>
