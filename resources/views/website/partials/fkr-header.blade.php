@php($isAr = app()->getLocale() === 'ar')
<a class="sanad-skip-link" href="#main">{{ __('auth.skip_to_main') }}</a>
<header class="fkr-site-header" data-fkr-site-header>
    <div class="fkr-site-header__inner">
        <a class="fkr-site-header__back" href="{{ route('website.home') }}" dir="{{ $isAr ? 'rtl' : 'ltr' }}" aria-label="{{ $isAr ? 'العودة إلى SANAD CX' : 'Back to SANAD CX' }}">
            <span aria-hidden="true">←</span>
            <span>{{ $isAr ? 'العودة إلى Sanad CX' : 'Back to Sanad CX' }}</span>
        </a>

        <button type="button" class="fkr-site-header__theme" data-theme-toggle aria-pressed="true" aria-label="{{ __('auth.toggle_theme') }}">
            <svg viewBox="0 0 48 48" width="48" height="48" aria-hidden="true">
                <defs>
                    <mask id="fkr-theme-cutout">
                        <rect width="48" height="48" fill="white" />
                        <circle class="fkr-site-header__theme-cutout" cx="32" cy="16" r="15" fill="black" />
                    </mask>
                </defs>
                <g mask="url(#fkr-theme-cutout)" fill="currentColor">
                    <path class="fkr-site-header__theme-rays" d="M40.9751 16.9657V7.02485H31.0343L24.0095 0L16.9657 7.02485H7.02485V16.9657L0 24.0095L7.02485 31.0343V40.9751H16.9657L23.9905 48L31.0154 40.9751H40.9562V31.0343L47.9811 24.0095L40.9751 16.9657ZM24.0095 37.5479C16.5302 37.5479 10.4521 31.4888 10.4521 23.9905C10.4521 16.4923 16.5112 10.4331 24.0095 10.4331C31.4888 10.4331 37.5669 16.4923 37.5669 23.9905C37.5669 31.4888 31.4888 37.5479 24.0095 37.5479Z" />
                    <path class="fkr-site-header__theme-disc" d="M25.7539 34.7552C31.6894 33.7925 35.7206 28.2004 34.7579 22.2649C33.7952 16.3295 28.2031 12.2983 22.2676 13.261C16.3322 14.2237 12.3009 19.8158 13.2637 25.7513C14.2264 31.6867 19.8185 35.7179 25.7539 34.7552Z" />
                </g>
            </svg>
        </button>

        <nav class="fkr-site-header__nav fkr-site-header__nav--desktop" aria-label="{{ __('auth.main_nav') }}">
            <a href="{{ route('website.about') }}">{{ $isAr ? 'من نحن' : 'About us' }}</a>
            <a href="#fkr-services">{{ $isAr ? 'خدماتنا' : 'Services' }}</a>
            <a href="#fkr-sectors">{{ $isAr ? 'القطاعات' : 'Sectors' }}</a>
            <a href="#fkr-method">{{ $isAr ? 'منهجيتنا' : 'Our methodology' }}</a>
        </nav>

        <details class="fkr-site-header__menu" data-fkr-mobile-menu>
            <summary class="fkr-site-header__menu-toggle" aria-label="{{ __('auth.menu') }}" aria-controls="fkr-mobile-navigation" title="{{ __('auth.menu') }}">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16" /></svg>
            </summary>
            <nav class="fkr-site-header__nav fkr-site-header__nav--mobile" id="fkr-mobile-navigation" aria-label="{{ __('auth.main_nav') }}">
                <a href="{{ route('website.about') }}">{{ $isAr ? 'من نحن' : 'About us' }}</a>
                <a href="#fkr-services">{{ $isAr ? 'خدماتنا' : 'Services' }}</a>
                <a href="#fkr-sectors">{{ $isAr ? 'القطاعات' : 'Sectors' }}</a>
                <a href="#fkr-method">{{ $isAr ? 'منهجيتنا' : 'Our methodology' }}</a>
            </nav>
        </details>

        <a class="fkr-site-header__brand" href="{{ route('website.fkr') }}" aria-label="{{ $isAr ? 'فِكر' : 'Fikr' }}" aria-current="page">
            <span><img src="{{ asset('website/assets/image/fkr/brand-logo.png') }}" alt="" width="72" height="56"></span>
        </a>
    </div>
</header>
<script>
    (() => {
        const menu = document.querySelector('[data-fkr-mobile-menu]');
        if (!menu) {
            return;
        }

        const toggle = menu.querySelector('summary');
        menu.querySelectorAll('.fkr-site-header__nav--mobile a[href^="#"]').forEach((link) => {
            link.addEventListener('click', () => {
                menu.open = false;
            });
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && menu.open) {
                menu.open = false;
                toggle.focus();
            }
        });
    })();
</script>
