<footer class="sanad-footer" data-site-footer>
 <div class="sanad-footer__content">
  <div class="sanad-footer__brand sanad-footer__column">
   <a class="sanad-footer__brand-link" href="{{ route('website.home') }}">
    <img class="sanad-footer__logo" src="{{ asset('website/assets/image/footerBrandLogo.svg') }}" alt="SANAD CX" width="181" height="60">
   </a>
   <p class="sanad-footer__description">شريكك الاستراتيجي لتعهيد وإدارة خدمات رعاية العملاء والاتصالات بالتشغيل المباشر</p>
   <ul class="sanad-footer__social">
    <li><img class="sanad-footer__social-icon" src="{{ asset('website/assets/image/svg/facebookLayer_28x28.svg') }}" alt="فيسبوك" width="28" height="28"></li>
    <li><img class="sanad-footer__social-icon" src="{{ asset('website/assets/image/svg/instagramLayer_28x28_homepage-dark.svg') }}" alt="إنستغرام" width="28" height="28"></li>
    <li><img class="sanad-footer__social-icon" src="{{ asset('website/assets/image/svg/xLayer_28x28_about-dark.svg') }}" alt="منصة X" width="28" height="28"></li>
    <li><img class="sanad-footer__social-icon" src="{{ asset('website/assets/image/svg/snapchatLayer_27x27.svg') }}" alt="سناب شات" width="28" height="28"></li>
    <li><img class="sanad-footer__social-icon" src="{{ asset('website/assets/image/svg/linkedinLayer_28x28.svg') }}" alt="لينكدإن" width="28" height="28"></li>
   </ul>
  </div>
  <nav class="sanad-footer__links sanad-footer__column" aria-label="روابط سريعة">
   <h2 class="sanad-footer__title">روابط سريعة</h2>
   <ul class="sanad-footer__link-list">
    <li><a class="sanad-footer__link" href="{{ route('website.home') }}">الرئيسية</a></li>
    <li><a class="sanad-footer__link" href="{{ route('website.services') }}">الخدمات</a></li>
    <li><a class="sanad-footer__link" href="{{ route('website.how-it-works') }}">كيف نعمل؟</a></li>
    <li><a class="sanad-footer__link" href="{{ route('website.blog') }}">المدونة</a></li>
   </ul>
  </nav>
  <nav class="sanad-footer__links sanad-footer__links--important sanad-footer__column" aria-label="روابط هامة">
   <h2 class="sanad-footer__title">روابط هامة</h2>
   <ul class="sanad-footer__link-list">
    <li><a class="sanad-footer__link" href="{{ route('website.about') }}">عن سند</a></li>
    <li><a class="sanad-footer__link" href="{{ route('website.terms') }}">الشروط والأحكام</a></li>
    <li><a class="sanad-footer__link" href="{{ route('website.privacy') }}">سياسة الخصوصية</a></li>
   </ul>
  </nav>
  <div class="sanad-footer__contact sanad-footer__column">
   <h2 class="sanad-footer__title">تواصل معنا</h2>
   <ul class="sanad-footer__contact-list">
    <li class="sanad-footer__contact-item">
     <img class="sanad-footer__contact-icon" src="{{ asset('website/assets/image/svg/emailContactIcon_16x16_homepage-dark.svg') }}" alt="" width="16" height="16">
     <a class="sanad-footer__contact-link" href="mailto:info@sanadcx.com"><bdi>info@sanadcx.com</bdi></a>
    </li>
    <li class="sanad-footer__contact-item">
     <img class="sanad-footer__contact-icon" src="{{ asset('website/assets/image/svg/hotlineContactIcon_16x16.svg') }}" alt="" width="16" height="16">
     <a class="sanad-footer__contact-link" href="tel:920022379"><bdi>920022379</bdi></a>
    </li>
    <li class="sanad-footer__contact-item">
     <img class="sanad-footer__contact-icon" src="{{ asset('website/assets/image/svg/mobileContactIcon_16x16.svg') }}" alt="" width="16" height="16">
     <a class="sanad-footer__contact-link" href="tel:+966506591444"><bdi>+966 50 659 1444</bdi></a>
    </li>
   </ul>
  </div>
 </div>
 <div class="sanad-footer__legal">
  <p class="sanad-footer__copyright" lang="en" dir="ltr">© {{ date('Y') }} Sanad CX. All rights reserved.<br>Sanad CX is an operational brand powered by Mada Co llc.</p>
 </div>
</footer>
