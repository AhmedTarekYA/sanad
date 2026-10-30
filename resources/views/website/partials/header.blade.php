<a class="sanad-skip-link" href="#main">{{ __('auth.skip_to_main') }}</a>
<header class="sanad-header" data-site-header>
 <div class="sanad-header__row">
  <a class="sanad-header__brand" href="{{ route('website.home') }}">
   <img class="sanad-header__logo sanad-header__logo--light" src="{{ asset('website/assets/image/logo.svg') }}" alt="SANAD CX" width="181" height="60">
   <img class="sanad-header__logo sanad-header__logo--dark" src="{{ asset('website/assets/image/darkmode-logo.svg') }}" alt="" width="181" height="60" aria-hidden="true">
  </a>
  <button type="button" class="sanad-btn sanad-btn--md sanad-btn--outline sanad-header__menu" data-site-header-menu aria-expanded="false" aria-controls="sanad-site-navigation" aria-label="{{ __('auth.menu') }}" title="{{ __('auth.menu') }}">
   <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
  </button>
  <nav class="sanad-header__nav" data-site-header-nav id="sanad-site-navigation" aria-label="{{ __('auth.main_nav') }}">
   <ul class="sanad-header__list">
    <li><a class="sanad-header__link {{ request()->routeIs('website.home') ? 'sanad-header__link--active' : '' }}" href="{{ route('website.home') }}">{{ __('auth.nav_home') }}</a></li>
    <li><a class="sanad-header__link {{ request()->routeIs('website.services') ? 'sanad-header__link--active' : '' }}" href="{{ route('website.services') }}">{{ __('auth.nav_services') }}</a></li>
    <li><a class="sanad-header__link {{ request()->routeIs('website.how-it-works') ? 'sanad-header__link--active' : '' }}" href="{{ route('website.how-it-works') }}">{{ __('auth.nav_how_it_works') }}</a></li>
    <li><a class="sanad-header__link {{ request()->routeIs('website.about') ? 'sanad-header__link--active' : '' }}" href="{{ route('website.about') }}">{{ __('auth.nav_about') }}</a></li>
    <li><a class="sanad-header__link {{ request()->routeIs('website.blog*') ? 'sanad-header__link--active' : '' }}" href="{{ route('website.blog') }}">{{ __('auth.nav_blog') }}</a></li>
    <li><a class="sanad-header__link" href="{{ route('website.home') }}#faq">{{ __('auth.nav_faq') }}</a></li>
   </ul>
  </nav>
  <div class="sanad-header__actions">
   <button type="button" class="sanad-btn sanad-header__cta" data-site-header-cta>{{ __('auth.nav_cta') }}</button>
   @php($altLocale = app()->getLocale() === 'ar' ? 'en' : 'ar')
   <a class="sanad-header__language" href="{{ LaravelLocalization::getLocalizedURL($altLocale) }}" dir="ltr" aria-label="{{ $altLocale === 'en' ? 'Switch to English' : 'التبديل إلى العربية' }}">{{ strtoupper($altLocale) }}</a>
   <button type="button" class="sanad-theme-toggle" data-theme-toggle aria-pressed="true" aria-label="{{ __('auth.toggle_theme') }}">
    <svg class="sanad-theme-toggle__icon" viewBox="0 0 48 48" width="48" height="48" aria-hidden="true">
     <defs>
      <mask id="sanad-theme-cutout">
       <rect width="48" height="48" fill="white"/>
       <circle class="sanad-theme-toggle__cutout" cx="32" cy="16" r="15" fill="black"/>
      </mask>
     </defs>
     <g mask="url(#sanad-theme-cutout)" fill="currentColor">
      <path class="sanad-theme-toggle__rays" d="M40.9751 16.9657V7.02485H31.0343L24.0095 0L16.9657 7.02485H7.02485V16.9657L0 24.0095L7.02485 31.0343V40.9751H16.9657L23.9905 48L31.0154 40.9751H40.9562V31.0343L47.9811 24.0095L40.9751 16.9657ZM24.0095 37.5479C16.5302 37.5479 10.4521 31.4888 10.4521 23.9905C10.4521 16.4923 16.5112 10.4331 24.0095 10.4331C31.4888 10.4331 37.5669 16.4923 37.5669 23.9905C37.5669 31.4888 31.4888 37.5479 24.0095 37.5479Z"/>
      <path class="sanad-theme-toggle__disc" d="M25.7539 34.7552C31.6894 33.7925 35.7206 28.2004 34.7579 22.2649C33.7952 16.3295 28.2031 12.2983 22.2676 13.261C16.3322 14.2237 12.3009 19.8158 13.2637 25.7513C14.2264 31.6867 19.8185 35.7179 25.7539 34.7552Z"/>
     </g>
    </svg>
   </button>
  </div>
 </div>
</header>
