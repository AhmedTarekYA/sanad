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
    <li><a class="sanad-header__link {{ request()->routeIs('website.services') ? 'sanad-header__link--active' : '' }}" href="{{ route('website.services') }}">{{ app()->getLocale() === 'ar' ? 'حلول التشغيل' : 'Operations Solutions' }}</a></li>
    <li><a class="sanad-header__link {{ request()->routeIs('website.ai-assistant') ? 'sanad-header__link--active' : '' }}" href="{{ route('website.ai-assistant') }}">{{ app()->getLocale() === 'ar' ? 'المساعد الذكي' : 'AI Assistant' }}</a></li>
    <li><a class="sanad-header__link {{ (request()->routeIs('website.fkr') || request()->routeIs('website.fkr')) ? 'sanad-header__link--active' : '' }}" href="{{ route('website.fkr') }}">{{ app()->getLocale() === 'ar' ? 'فِكر' : 'fkr' }}</a></li>
    <li><a class="sanad-header__link {{ request()->routeIs('website.how-it-works') ? 'sanad-header__link--active' : '' }}" href="{{ route('website.how-it-works') }}">{{ app()->getLocale() === 'ar' ? 'رحلة التشغيل' : 'Operations Journey' }}</a></li>
    <li><a class="sanad-header__link {{ request()->routeIs('website.about') ? 'sanad-header__link--active' : '' }}" href="{{ route('website.about') }}">{{ __('auth.nav_about') }}</a></li>
   </ul>
  </nav>
  <div class="sanad-header__actions">
   <button type="button" class="sanad-btn sanad-header__cta" data-site-header-cta>{{ __('auth.nav_cta') }}</button>
   @php($altLocale = app()->getLocale() === 'ar' ? 'en' : 'ar')
   <a class="sanad-header__language" href="{{ LaravelLocalization::getLocalizedURL($altLocale) }}" dir="ltr" aria-label="{{ $altLocale === 'en' ? 'Switch to English' : 'التبديل إلى العربية' }}">{{ strtoupper($altLocale) }}</a>
   <button type="button" class="sanad-theme-toggle" data-theme-toggle aria-pressed="true" aria-label="{{ __('auth.toggle_theme') }}">
    @include('website.partials.theme-icon')
   </button>
  </div>
 </div>
</header>
