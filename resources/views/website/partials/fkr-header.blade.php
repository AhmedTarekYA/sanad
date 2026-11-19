@php($isAr = app()->getLocale() === 'ar')
<a class="sanad-skip-link" href="#main">{{ __('auth.skip_to_main') }}</a>
<header class="fkr-site-header" data-fkr-site-header>
    <div class="fkr-site-header__inner">
        <a class="fkr-site-header__back" href="{{ route('website.home') }}" dir="{{ $isAr ? 'rtl' : 'ltr' }}" aria-label="{{ $isAr ? 'العودة إلى SANAD CX' : 'Back to SANAD CX' }}">
            <span aria-hidden="true">←</span>
            <span>{{ $isAr ? 'العودة إلى Sanad CX' : 'Back to Sanad CX' }}</span>
        </a>

        <button type="button" class="fkr-site-header__theme" data-theme-toggle aria-pressed="true" aria-label="{{ __('auth.toggle_theme') }}">
            @include('website.partials.theme-icon')
        </button>

        <nav class="fkr-site-header__nav fkr-site-header__nav--desktop" aria-label="{{ __('auth.main_nav') }}">
            <a href="#fkr-about">{{ $isAr ? 'من نحن' : 'About us' }}</a>
            <a href="#fkr-services">{{ $isAr ? 'خدماتنا' : 'Services' }}</a>
            <a href="#fkr-sectors">{{ $isAr ? 'القطاعات' : 'Sectors' }}</a>
            <a href="#fkr-method">{{ $isAr ? 'منهجيتنا' : 'Our methodology' }}</a>
        </nav>

        <details class="fkr-site-header__menu" data-fkr-mobile-menu>
            <summary class="fkr-site-header__menu-toggle" aria-label="{{ __('auth.menu') }}" aria-controls="fkr-mobile-navigation" title="{{ __('auth.menu') }}">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16" /></svg>
            </summary>
            <nav class="fkr-site-header__nav fkr-site-header__nav--mobile" id="fkr-mobile-navigation" aria-label="{{ __('auth.main_nav') }}">
                <a href="#fkr-about">{{ $isAr ? 'من نحن' : 'About us' }}</a>
                <a href="#fkr-services">{{ $isAr ? 'خدماتنا' : 'Services' }}</a>
                <a href="#fkr-sectors">{{ $isAr ? 'القطاعات' : 'Sectors' }}</a>
                <a href="#fkr-method">{{ $isAr ? 'منهجيتنا' : 'Our methodology' }}</a>
            </nav>
        </details>

        <a class="fkr-site-header__brand" href="#main" aria-label="{{ $isAr ? 'فِكر' : 'Fikr' }}" aria-current="page">
            <span>@include('website.partials.fikr-logo', ['logoId' => 'fikr-header'])</span>
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
