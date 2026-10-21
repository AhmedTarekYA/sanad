<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->website_name ?? 'Sanad' }} | {{ __('auth.login') }}</title>
    <link rel="icon" href="{{ $settings?->favicon ? showFile($settings->favicon) : asset('brand/logo.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('admin/login/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/login/css/sanad-login.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/cssbundle/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/toster/css/jquery.toast.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/jquery_validator/form_validator/theme-default.min.css') }}">
    <style>
        .sanad-image-layer[data-image="1"] { background-image: url('{{ asset('admin/login/imgs/1.png') }}'); }
        .sanad-image-layer[data-image="2"] { background-image: url('{{ asset('admin/login/imgs/2.png') }}'); }
        .sanad-image-layer[data-image="3"] { background-image: url('{{ asset('admin/login/imgs/3.png') }}'); }
    </style>
</head>
<body>
    @php
        $loginLogo = isset($settings) && $settings->logo_header && file_exists(public_path('/storage/' . $settings->logo_header))
            ? showFile($settings->logo_header)
            : asset('brand/logo.svg');
    @endphp

    <main class="sanad-login">
        <section class="sanad-login__form-side">
            @php
                $supportedLocales = config('laravellocalization.supportedLocales', []);
                $currentLocale = app()->getLocale();
            @endphp
            <div class="sanad-login__language">
                <button type="button" class="sanad-login__language-toggle" aria-expanded="false" aria-controls="sanadLanguageMenu"><i class="fal fa-language" aria-hidden="true"></i><span>{{ $supportedLocales[$currentLocale]['native'] ?? strtoupper($currentLocale) }}</span><i class="fal fa-chevron-down" aria-hidden="true"></i></button>
                <div class="sanad-login__language-menu" id="sanadLanguageMenu">
                    @foreach($supportedLocales as $localeCode => $localeData)
                        <a href="{{ app('laravellocalization')->getLocalizedURL($localeCode, null, [], true) }}" class="{{ $currentLocale === $localeCode ? 'is-active' : '' }}"><span>{{ $localeData['native'] ?? strtoupper($localeCode) }}</span><small>{{ strtoupper($localeCode) }}</small></a>
                    @endforeach
                </div>
            </div>
            <div class="sanad-login__form-wrap">
                <div class="sanad-login__brand"><img src="{{ $loginLogo }}" alt="{{ $settings->website_name ?? 'Sanad' }}" onerror="this.onerror=null;this.src='{{ asset('brand/logo.svg') }}';"></div>
                <h1>{{ __('auth.welcomeback') }}</h1>
                <p class="sanad-login__subtitle">{{ app()->getLocale() === 'ar' ? 'سجّل الدخول لإدارة مساحة العمل الخاصة بك' : 'Sign in to manage your workspace' }}</p>
                @if(session('error'))<div class="sanad-login__alert" role="alert">{{ session('error') }}</div>@endif

                <form id="loginForm" action="{{ route('admin.login') }}" method="POST">
                    @csrf
                    <div class="sanad-login__fields">
                        <div class="sanad-login__field">
                            <label for="email">{{ __('auth.email') }}</label>
                            <input type="text" id="email" name="login" placeholder="{{ __('auth.placeholderEmail') }}" autocomplete="username" data-validation="required" autofocus>
                        </div>
                        <div class="sanad-login__field">
                            <label for="password">{{ __('auth.password') }}</label>
                            <input type="password" id="password" name="password" placeholder="••••••••••••••••" autocomplete="current-password" data-validation="required">
                        </div>
                    </div>
                    <button type="submit" id="loginSubmit"><span>{{ __('auth.sign in') }}</span><i class="fal fa-arrow-left" aria-hidden="true"></i></button>
                </form>
            </div>
            <footer class="sanad-login__footer"><span>{{ $main_setting->copyright_text ?? __('auth.All Rights Reserved.') }}</span><span>© {{ date('Y') }}</span><a href="https://sanad-tec.com" target="_blank" rel="noopener">Sanad</a></footer>
        </section>

        <section class="sanad-login__image-side" aria-label="Sanad">
            <div class="sanad-login__image-overlay"></div>
            @for($image = 1; $image <= 3; $image++)<div class="sanad-image-layer" data-image="{{ $image }}" style="{{ $image === 1 ? 'opacity:1;z-index:1;' : '' }}"></div>@endfor
{{--            <div class="sanad-login__image-content"><img src="{{ $loginLogo }}" alt="{{ $settings->website_name ?? 'Sanad' }}" onerror="this.onerror=null;this.src='{{ asset('brand/logo.svg') }}';">--}}
{{--                <span>{{ $settings->website_name ?? 'Sanad' }}</span>--}}
{{--            </div>--}}
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
            $('.sanad-login__language-toggle').on('click', function () {
                const menu = $('#sanadLanguageMenu'), open = menu.toggleClass('is-open').hasClass('is-open');
                $(this).attr('aria-expanded', open ? 'true' : 'false');
            });
            $(document).on('click', function (event) {
                if (!$(event.target).closest('.sanad-login__language').length) {
                    $('#sanadLanguageMenu').removeClass('is-open');
                    $('.sanad-login__language-toggle').attr('aria-expanded', 'false');
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
                let nextImage; do { nextImage = Math.floor(Math.random() * 3) + 1; } while (nextImage === currentImage);
                $('.sanad-image-layer[data-image="' + currentImage + '"]').css({ opacity: 0, zIndex: 0 });
                $('.sanad-image-layer[data-image="' + nextImage + '"]').css({ opacity: 1, zIndex: 1 }); currentImage = nextImage;
            }, 5000);
        });
    </script>
</body>
</html>
