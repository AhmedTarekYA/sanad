@php
    $footerLogo = ($settings && $settings->logo_footer && file_exists(public_path('/storage/' . $settings->logo_footer)))
        ? asset('/storage/' . $settings->logo_footer)
        : asset('brand/logo_dark.png');

    $socialLinks = [
        'facebook'  => ['icon' => asset('website/assets/image/svg/facebookLayer_28x28.svg'),       'label' => __('auth.social_facebook')],
        'instagram' => ['icon' => asset('website/assets/image/svg/instagramLayer_28x28_homepage-dark.svg'), 'label' => __('auth.social_instagram')],
        'twitter'   => ['icon' => asset('website/assets/image/svg/xLayer_28x28_about-dark.svg'),    'label' => __('auth.social_twitter')],
        'snapchat'  => ['icon' => asset('website/assets/image/svg/snapchatLayer_27x27.svg'),         'label' => __('auth.social_snapchat')],
        'linkedin'  => ['icon' => asset('website/assets/image/svg/linkedinLayer_28x28.svg'),         'label' => __('auth.social_linkedin')],
    ];
@endphp
@php
    $footerEmail = $settings?->email ?: 'info@sanadcx.com';
    $footerPhone = $settings?->phone ?: '920022379';
    $footerOtherPhone = $settings?->other_phone ?: '01550999793';
@endphp
<footer class="sanad-footer" data-site-footer>
 <div class="sanad-footer__content">
  <div class="sanad-footer__brand sanad-footer__column">
   <a class="sanad-footer__brand-link" href="{{ route('website.home') }}">
    <img class="sanad-footer__logo" src="{{ $footerLogo }}" alt="{{ $settings?->website_name ?? 'SANAD CX' }}" width="181" height="60">
   </a>
   <p class="sanad-footer__description">{{ $settings?->footer_text ?: 'شريكك الاستراتيجي لتعهيد وإدارة خدمات رعاية العملاء والاتصالات بالتشغيل المباشر' }}</p>
   <ul class="sanad-footer__social">
    @foreach($socialLinks as $key => $social)
        @php($url = $settings?->$key ?? '#')
        @if($url && $url !== '#')
        <li>
            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['label'] }}">
                <img class="sanad-footer__social-icon" src="{{ $social['icon'] }}" alt="" width="28" height="28">
            </a>
        </li>
        @else
        <li><img class="sanad-footer__social-icon" src="{{ $social['icon'] }}" alt="{{ $social['label'] }}" width="28" height="28"></li>
        @endif
    @endforeach
   </ul>
  </div>
  <nav class="sanad-footer__links sanad-footer__column" aria-label="{{ __('auth.footer_quick_links') }}">
   <h2 class="sanad-footer__title">{{ __('auth.footer_quick_links') }}</h2>
   <ul class="sanad-footer__link-list">
    <li><a class="sanad-footer__link" href="{{ route('website.home') }}">{{ __('auth.nav_home') }}</a></li>
    <li><a class="sanad-footer__link" href="{{ route('website.services') }}">{{ app()->getLocale() === 'ar' ? 'حلول التشغيل' : 'Operations Solutions' }}</a></li>
    <li><a class="sanad-footer__link" href="{{ route('website.how-it-works') }}">{{ app()->getLocale() === 'ar' ? 'رحلة التشغيل' : 'Operations Journey' }}</a></li>
    <li><a class="sanad-footer__link" href="{{ url('/ai-assistant') }}">{{ app()->getLocale() === 'ar' ? 'المساعد الذكي' : 'AI Assistant' }}</a></li>
    <li><a class="sanad-footer__link" href="{{ url('/fikr') }}">{{ app()->getLocale() === 'ar' ? 'فِكر' : 'Fikr' }}</a></li>
    <li><a class="sanad-footer__link" href="{{ route('website.blog') }}">{{ __('auth.nav_blog') }}</a></li>
   </ul>
  </nav>
  <nav class="sanad-footer__links sanad-footer__links--important sanad-footer__column" aria-label="{{ __('auth.footer_important_links') }}">
   <h2 class="sanad-footer__title">{{ __('auth.footer_important_links') }}</h2>
   <ul class="sanad-footer__link-list">
    <li><a class="sanad-footer__link" href="{{ route('website.about') }}">{{ __('auth.nav_about') }}</a></li>
    <li><a class="sanad-footer__link" href="{{ route('website.terms') }}">{{ __('auth.footer_terms') }}</a></li>
    <li><a class="sanad-footer__link" href="{{ route('website.privacy') }}">{{ __('auth.footer_privacy') }}</a></li>
   </ul>
  </nav>
  <div class="sanad-footer__contact sanad-footer__column">
   <h2 class="sanad-footer__title">{{ __('auth.footer_contact_us') }}</h2>
   <ul class="sanad-footer__contact-list">
    @if($footerEmail && $footerEmail !== '#')
    <li class="sanad-footer__contact-item">
     <img class="sanad-footer__contact-icon" src="{{ asset('website/assets/image/svg/emailContactIcon_16x16_homepage-dark.svg') }}" alt="" width="16" height="16">
     <a class="sanad-footer__contact-link" href="mailto:{{ $footerEmail }}"><bdi>{{ $footerEmail }}</bdi></a>
    </li>
    @endif
    @if($footerPhone && $footerPhone !== '#')
    <li class="sanad-footer__contact-item">
     <img class="sanad-footer__contact-icon" src="{{ asset('website/assets/image/svg/hotlineContactIcon_16x16.svg') }}" alt="" width="16" height="16">
     <a class="sanad-footer__contact-link" href="tel:{{ $footerPhone }}"><bdi>{{ $footerPhone }}</bdi></a>
    </li>
    @endif
    @if($footerOtherPhone && $footerOtherPhone !== '#')
    <li class="sanad-footer__contact-item">
     <img class="sanad-footer__contact-icon" src="{{ asset('website/assets/image/svg/mobileContactIcon_16x16.svg') }}" alt="" width="16" height="16">
     <a class="sanad-footer__contact-link" href="tel:{{ $footerOtherPhone }}"><bdi>{{ $footerOtherPhone }}</bdi></a>
    </li>
    @endif
   </ul>
  </div>
 </div>
 <div class="sanad-footer__legal">
  <p class="sanad-footer__copyright" lang="en" dir="ltr">{{ $settings?->copyright ?: '© 2026 Sanad CX. All rights reserved.' }}</p>
  <p class="sanad-footer__powered" lang="en" dir="ltr">Sanad CX is an operational brand powered by Mada CX.</p>
 </div>
</footer>
