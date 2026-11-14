@php
    $isAr = app()->getLocale() === 'ar';
    $supportedLocales = config('laravellocalization.supportedLocales', []);
    $currentLocale = app()->getLocale();
    $brandLogo = isset($settings) && $settings->logo_header && file_exists(public_path('/storage/' . $settings->logo_header))
        ? showFile($settings->logo_header)
        : asset('brand/logo.svg');
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $settings->website_name ?? 'Sanad' }} | {{ $isAr ? 'قريباً' : 'Coming Soon' }}</title>
    <link rel="icon" href="{{ $settings?->favicon ? showFile($settings->favicon) : asset('brand/logo.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{
            --brand:#2d71f0;
            --brand-600:#1f5fe0;
            --brand-050:#eef4ff;
            --ink:#0f1b33;
            --muted:#64748b;
            --card:#ffffff;
        }
        *{margin:0;padding:0;box-sizing:border-box}
        html,body{height:100%}
        body{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            font-family:{{ $isAr ? "'Cairo'" : "'Plus Jakarta Sans'" }},'Segoe UI',system-ui,sans-serif;
            color:var(--ink);
            background:
                radial-gradient(1100px 600px at 85% -10%, rgba(45,113,240,.16), transparent 60%),
                radial-gradient(900px 600px at -10% 110%, rgba(45,113,240,.12), transparent 55%),
                #f6f8fc;
            padding:24px;
            position:relative;
            overflow:hidden;
        }
        .cs-blob{position:absolute;border-radius:50%;filter:blur(60px);opacity:.5;z-index:0}
        .cs-blob.one{width:360px;height:360px;background:rgba(45,113,240,.22);inset-inline-end:-80px;top:-90px}
        .cs-blob.two{width:300px;height:300px;background:rgba(167,139,250,.18);inset-inline-start:-70px;bottom:-80px}
        .cs-card{
            position:relative;z-index:1;
            width:100%;max-width:560px;
            background:rgba(255,255,255,.75);
            backdrop-filter:blur(18px);
            -webkit-backdrop-filter:blur(18px);
            border:1px solid rgba(255,255,255,.7);
            box-shadow:0 30px 80px -30px rgba(15,27,51,.35);
            border-radius:28px;
            padding:clamp(28px,5vw,52px);
            text-align:center;
        }
        .cs-top{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:34px}
        .cs-logo img{height:40px;width:auto;object-fit:contain}
        .cs-lang{position:relative}
        .cs-lang-toggle{
            display:inline-flex;align-items:center;gap:8px;cursor:pointer;
            background:#fff;border:1px solid #e6ebf3;border-radius:12px;
            padding:8px 12px;font:inherit;font-size:.85rem;font-weight:600;color:var(--ink);
        }
        .cs-lang-toggle:hover{border-color:var(--brand)}
        .cs-lang-menu{
            position:absolute;inset-inline-end:0;top:calc(100% + 8px);min-width:150px;
            background:#fff;border:1px solid #eceff4;border-radius:14px;
            box-shadow:0 18px 40px -18px rgba(15,27,51,.3);
            padding:6px;display:none;z-index:5;text-align:start;
        }
        .cs-lang-menu.open{display:block}
        .cs-lang-menu a{
            display:flex;align-items:center;justify-content:space-between;
            text-decoration:none;color:var(--ink);font-size:.88rem;font-weight:600;
            padding:9px 12px;border-radius:10px;
        }
        .cs-lang-menu a:hover{background:var(--brand-050);color:var(--brand)}
        .cs-lang-menu a.active{color:var(--brand)}
        .cs-lang-menu small{color:var(--muted);font-weight:700}
        .cs-badge{
            display:inline-flex;align-items:center;gap:8px;
            background:var(--brand-050);color:var(--brand-600);
            font-size:.72rem;font-weight:800;letter-spacing:.12em;
            padding:8px 16px;border-radius:999px;margin-bottom:26px;
            border:1px solid rgba(45,113,240,.18);
        }
        .cs-badge .ping{width:8px;height:8px;border-radius:50%;background:var(--brand);box-shadow:0 0 0 0 rgba(45,113,240,.5);animation:ping 1.6s ease-out infinite}
        @keyframes ping{0%{box-shadow:0 0 0 0 rgba(45,113,240,.45)}70%{box-shadow:0 0 0 10px rgba(45,113,240,0)}100%{box-shadow:0 0 0 0 rgba(45,113,240,0)}}
        .cs-card h1{
            font-size:clamp(2.6rem,7vw,4rem);font-weight:800;line-height:1.15;margin-bottom:14px;
            background:linear-gradient(135deg,var(--brand),#7aa2ff 60%,#a78bfa);
            -webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;
        }
        .cs-card p{color:var(--muted);font-size:1.05rem;line-height:1.8;max-width:420px;margin:0 auto}
        .cs-progress{height:8px;background:#e9eef6;border-radius:999px;overflow:hidden;margin:34px auto 10px;max-width:360px}
        .cs-progress span{display:block;height:100%;width:62%;border-radius:999px;background:linear-gradient(90deg,var(--brand),#7aa2ff);animation:grow 2.4s ease-in-out infinite alternate}
        @keyframes grow{from{width:48%}to{width:78%}}
        .cs-progress-label{color:var(--muted);font-size:.82rem;font-weight:600}
        .cs-footer{margin-top:30px;color:var(--muted);font-size:.82rem;display:flex;gap:6px;align-items:center;justify-content:center;flex-wrap:wrap}
        .cs-footer a{color:var(--brand);text-decoration:none;font-weight:700}
        @media (max-width:520px){.cs-card{border-radius:22px}.cs-logo img{height:34px}}
        @media (prefers-reduced-motion:reduce){.cs-badge .ping,.cs-progress span{animation:none}}
    </style>
</head>
<body>
    <div class="cs-blob one"></div>
    <div class="cs-blob two"></div>

    <main class="cs-card">
        <div class="cs-top">
            <div class="cs-logo"><img src="{{ $brandLogo }}" alt="{{ $settings->website_name ?? 'Sanad' }}" onerror="this.onerror=null;this.src='{{ asset('brand/logo.svg') }}';"></div>
            @if(!empty($supportedLocales))
                <div class="cs-lang">
                    <button type="button" class="cs-lang-toggle" id="csLangToggle" aria-expanded="false">
                        <span>{{ $supportedLocales[$currentLocale]['native'] ?? strtoupper($currentLocale) }}</span>
                        <span>▾</span>
                    </button>
                    <div class="cs-lang-menu" id="csLangMenu">
                        @foreach($supportedLocales as $localeCode => $localeData)
                            <a href="{{ route('crm.lang', $localeCode) }}" class="{{ $currentLocale === $localeCode ? 'active' : '' }}">
                                <span>{{ $localeData['native'] ?? strtoupper($localeCode) }}</span>
                                <small>{{ strtoupper($localeCode) }}</small>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <span class="cs-badge"><span class="ping"></span>{{ $isAr ? 'منصة سند CRM' : 'SANAD CRM' }}</span>
        <h1>{{ $isAr ? 'قريباً' : 'Coming Soon' }}</h1>
        <p>{{ $isAr
            ? 'نعمل على بناء منصة CRM متكاملة لإدارة علاقات عملائك باحترافية وسهولة. ترقّب الإطلاق قريباً.'
            : 'We are crafting a complete CRM platform to manage your customer relationships with ease and professionalism. Launching soon.' }}</p>

        <div class="cs-progress"><span></span></div>
        <div class="cs-progress-label">{{ $isAr ? 'جاري التطوير…' : 'In development…' }}</div>

        <footer class="cs-footer">
            <span>© {{ date('Y') }} {{ $settings->website_name ?? 'Sanad' }}</span>
            <span>·</span>
            <a href="http://sanadcx.com" target="_blank" rel="noopener">Sanad</a>
        </footer>
    </main>

    <script>
        (function () {
            var t = document.getElementById('csLangToggle'), m = document.getElementById('csLangMenu');
            if (t && m) {
                t.addEventListener('click', function (e) {
                    e.stopPropagation();
                    var open = m.classList.toggle('open');
                    t.setAttribute('aria-expanded', open ? 'true' : 'false');
                });
                document.addEventListener('click', function () { m.classList.remove('open'); t.setAttribute('aria-expanded', 'false'); });
            }
        })();
    </script>
</body>
</html>

{{--
========================================================================
  ORIGINAL LOGIN PAGE — COMMENTED OUT (restore by removing this wrapper)
========================================================================
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
                        <a href="{{ route('crm.lang', $localeCode) }}" class="{{ $currentLocale === $localeCode ? 'is-active' : '' }}"><span>{{ $localeData['native'] ?? strtoupper($localeCode) }}</span><small>{{ strtoupper($localeCode) }}</small></a>
                    @endforeach
                </div>
            </div>
            <div class="sanad-login__form-wrap">
                <div class="sanad-login__brand"><img src="{{ $loginLogo }}" alt="{{ $settings->website_name ?? 'Sanad' }}" onerror="this.onerror=null;this.src='{{ asset('brand/logo.svg') }}';"></div>
                <h1>{{ __('auth.welcomeback') }}</h1>
                <p class="sanad-login__subtitle">{{ app()->getLocale() === 'ar' ? 'سجّل الدخول لإدارة مساحة العمل الخاصة بك' : 'Sign in to manage your workspace' }}</p>
                @if(session('error'))<div class="sanad-login__alert" role="alert">{{ session('error') }}</div>@endif
                @if($errors->any())<div class="sanad-login__alert" role="alert">{{ $errors->first() }}</div>@endif

                <form id="loginForm" action="/login" method="POST">
                    @csrf
                    <div class="sanad-login__fields">
                        <div class="sanad-login__field">
                            <label for="email">{{ __('auth.email') }}</label>
                            <input type="text" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('auth.placeholderEmail') }}" autocomplete="username" data-validation="required" autofocus>
                        </div>
                        <div class="sanad-login__field">
                            <label for="password">{{ __('auth.password') }}</label>
                            <input type="password" id="password" name="password" placeholder="••••••••••••••••" autocomplete="current-password" data-validation="required">
                        </div>
                    </div>
                    <button type="submit" id="loginSubmit"><span>{{ __('auth.sign in') }}</span><i class="fal fa-arrow-left" aria-hidden="true"></i></button>
                </form>
            </div>
            <footer class="sanad-login__footer"><span>{{ $main_setting->copyright_text ?? __('auth.All Rights Reserved.') }}</span><span>© {{ date('Y') }}</span><a href="http://sanadcx.com" target="_blank" rel="noopener">Sanad</a></footer>
        </section>

        <section class="sanad-login__image-side" aria-label="Sanad">
            <div class="sanad-login__image-overlay"></div>
            @for($image = 1; $image <= 3; $image++)<div class="sanad-image-layer" data-image="{{ $image }}" style="{{ $image === 1 ? 'opacity:1;z-index:1;' : '' }}"></div>@endfor
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
            function firstError(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    return Object.values(xhr.responseJSON.errors)[0][0];
                }
                return @json(__('auth.generic validation error'));
            }
            $(document).on('submit', '#loginForm', function (event) {
                event.preventDefault();
                const form = $(this), button = $('#loginSubmit');
                button.prop('disabled', true).html('<span>' + @json(__('auth.wait')) + '</span><i class="fal fa-spinner fa-spin" aria-hidden="true"></i>');
                $.ajax({ url: form.attr('action'), data: form.serialize(), type: 'POST', dataType: 'json' })
                    .done(function (result) {
                        if (result.code === 200 && result.data && result.data.url) {
                            window.location.href = result.data.url;
                        } else {
                            warningToster(@json(__('auth.an error occurred')), result.message || @json(__('auth.generic validation error')));
                        }
                    })
                    .fail(function (xhr) {
                        warningToster(@json(__('auth.an error occurred')), firstError(xhr));
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
--}}
