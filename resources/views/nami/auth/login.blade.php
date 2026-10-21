<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->website_name ?? 'Nami' }} | {{ __('auth.login') }}</title>
    <link rel="icon" href="{{ $settings?->favicon ? showFile($settings->favicon) : asset('brand/logo.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('admin/login/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/login/css/nami-login.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/cssbundle/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/toster/css/jquery.toast.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/jquery_validator/form_validator/theme-default.min.css') }}">
    <style>
        .nami-image-layer[data-image="1"] { background-image: url('{{ asset('light-able/assets/images/authentication/img-auth-bg.jpg') }}'); }
        .nami-image-layer[data-image="2"] { background-image: url('{{ asset('light-able/assets/images/pages/img-gallery-2.jpg') }}'); }
        .nami-image-layer[data-image="3"] { background-image: url('{{ asset('light-able/assets/images/pages/img-gallery-4.jpg') }}'); }
        .nami-image-layer[data-image="4"] { background-image: url('{{ asset('light-able/assets/images/pages/img-gallery-9.jpg') }}'); }
        .nami-image-layer[data-image="5"] { background-image: url('{{ asset('light-able/assets/images/authentication/img-auth-bg.jpg') }}'); }
        .nami-image-layer[data-image="6"] { background-image: url('{{ asset('light-able/assets/images/pages/img-gallery-2.jpg') }}'); }
    </style>
</head>
<body>
    @php
        $loginLogo = isset($settings) && $settings->logo_header && file_exists(public_path('/storage/' . $settings->logo_header))
            ? showFile($settings->logo_header)
            : asset('brand/logo.svg');
    @endphp

    <main class="nami-login">
        <section class="nami-login__form-side">
            @php
                $supportedLocales = config('laravellocalization.supportedLocales', []);
                $currentLocale = app()->getLocale();
            @endphp
            <div class="nami-login__language">
                <button type="button" class="nami-login__language-toggle" aria-expanded="false" aria-controls="namiLanguageMenu"><i class="fal fa-language" aria-hidden="true"></i><span>{{ $supportedLocales[$currentLocale]['native'] ?? strtoupper($currentLocale) }}</span><i class="fal fa-chevron-down" aria-hidden="true"></i></button>
                <div class="nami-login__language-menu" id="namiLanguageMenu">
                    @foreach($supportedLocales as $localeCode => $localeData)
                        <a href="{{ app('laravellocalization')->getLocalizedURL($localeCode, null, [], true) }}" class="{{ $currentLocale === $localeCode ? 'is-active' : '' }}"><span>{{ $localeData['native'] ?? strtoupper($localeCode) }}</span><small>{{ strtoupper($localeCode) }}</small></a>
                    @endforeach
                </div>
            </div>
            <div class="nami-login__form-wrap">
                <div class="nami-login__brand"><img src="{{ $loginLogo }}" alt="{{ $settings->website_name ?? 'NAMI' }}" onerror="this.onerror=null;this.src='{{ asset('brand/logo.svg') }}';"></div>
                <h1>{{ __('auth.welcomeback') }}</h1>
                <p class="nami-login__subtitle">{{ app()->getLocale() === 'ar' ? 'سجّل الدخول لإدارة مساحة العمل الخاصة بك' : 'Sign in to manage your workspace' }}</p>
                @if(session('error'))<div class="nami-login__alert" role="alert">{{ session('error') }}</div>@endif

                <form id="loginForm" action="{{ route('admin.login') }}" method="POST">
                    @csrf
                    <div class="nami-login__fields">
                        <div class="nami-login__field">
                            <label for="email">{{ __('auth.email') }}</label>
                            <input type="text" id="email" name="login" placeholder="{{ __('auth.placeholderEmail') }}" autocomplete="username" data-validation="required" autofocus>
                        </div>
                        <div class="nami-login__field">
                            <label for="password">{{ __('auth.password') }}</label>
                            <input type="password" id="password" name="password" placeholder="••••••••••••••••" autocomplete="current-password" data-validation="required">
                        </div>
                    </div>
                    <button type="submit" id="loginSubmit"><span>{{ __('auth.sign in') }}</span><i class="fal fa-arrow-left" aria-hidden="true"></i></button>
                </form>
            </div>
            <footer class="nami-login__footer"><span>{{ $main_setting->copyright_text ?? __('auth.All Rights Reserved.') }}</span><span>© {{ date('Y') }}</span><a href="https://nami-tec.com" target="_blank" rel="noopener">NAMI</a></footer>
        </section>

        <section class="nami-login__image-side" aria-label="Nami">
            <div class="nami-login__image-overlay"></div>
            @for($image = 1; $image <= 6; $image++)<div class="nami-image-layer" data-image="{{ $image }}" style="{{ $image === 1 ? 'opacity:1;z-index:1;' : '' }}"></div>@endfor
            <div class="nami-login__image-content"><img src="{{ $loginLogo }}" alt="{{ $settings->website_name ?? 'NAMI' }}" onerror="this.onerror=null;this.src='{{ asset('brand/logo.svg') }}';"><span>{{ $settings->website_name ?? 'NAMI' }}</span></div>
        </section>
    </main>

    <script src="{{ asset('admin/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bundle/sweetalert2.bundle.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/toster/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/jquery_validator/form_validator/jquery.form-validator.min.js') }}"></script>
    <script>
        $(function () {
            $.validate({ ignore: 'input[type=hidden]', modules: 'date, security', lang: @json(app()->getLocale()), validateOnEvent: true });
            $('.nami-login__language-toggle').on('click', function () {
                const menu = $('#namiLanguageMenu'), open = menu.toggleClass('is-open').hasClass('is-open');
                $(this).attr('aria-expanded', open ? 'true' : 'false');
            });
            $(document).on('click', function (event) {
                if (!$(event.target).closest('.nami-login__language').length) {
                    $('#namiLanguageMenu').removeClass('is-open');
                    $('.nami-login__language-toggle').attr('aria-expanded', 'false');
                }
            });
            $(document).on('submit', '#loginForm', function (event) {
                event.preventDefault();
                const form = $(this), button = $('#loginSubmit');
                button.prop('disabled', true).html('<span>' + @json(__('auth.wait')) + '</span><i class="fal fa-spinner fa-spin" aria-hidden="true"></i>');
                $.ajax({ url: form.attr('action'), data: form.serialize(), type: 'POST', dataType: 'json' })
                    .done(function (result) { if (result.code === 200) window.location.href = result.data.url; else warningToster(@json(__('auth.an error occurred')), result.message); })
                    .fail(function (xhr) {
                        if (xhr.status === 422) validToster(@json(__('auth.an error occurred')), @json(__('auth.generic validation error')));
                        else errorToster(@json(__('auth.an error occurred')), @json(__('auth.generic validation error')));
                    })
                    .always(function () { button.prop('disabled', false).html('<span>' + @json(__('auth.sign in')) + '</span><i class="fal fa-arrow-left" aria-hidden="true"></i>'); });
            });
            let currentImage = 1;
            if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) setInterval(function () {
                let nextImage; do { nextImage = Math.floor(Math.random() * 6) + 1; } while (nextImage === currentImage);
                $('.nami-image-layer[data-image="' + currentImage + '"]').css({ opacity: 0, zIndex: 0 });
                $('.nami-image-layer[data-image="' + nextImage + '"]').css({ opacity: 1, zIndex: 1 }); currentImage = nextImage;
            }, 5000);
        });
    </script>
</body>
</html>
