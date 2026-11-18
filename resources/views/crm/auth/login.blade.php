@php
    $isAr = app()->getLocale() === 'ar';
    $supportedLocales = config('laravellocalization.supportedLocales', []);
    $currentLocale = app()->getLocale();
    $loginLogo = asset('brand/crm_logo.png');
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->website_name ?? 'Sanad' }} | {{ __('auth.login') }}</title>
    <link rel="icon" href="{{ $settings?->favicon ? showFile($settings->favicon) : asset('brand/crm_logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('admin/login/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/login/css/sanad-login.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/cssbundle/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/toster/css/jquery.toast.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/jquery_validator/form_validator/theme-default.min.css') }}">
    <style>
        :root{
            --crm-brand:#2d71f0;
            --crm-brand-strong:#1640c6;
            --crm-brand-soft:#eaf0f9;
            --crm-ink:#0a192f;
            --crm-muted:#737373;
            --crm-border:#d8e1f4;
        }
        *{margin:0;padding:0;box-sizing:border-box}
        html,body{min-height:100%}
        body{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:24px;
            color:var(--crm-ink);
            font-family:'IBM Plex Sans Arabic','Thmanya','Segoe UI',system-ui,sans-serif;
            background:
                radial-gradient(900px 520px at 100% 0%, rgba(45,113,240,.20), transparent 60%),
                radial-gradient(800px 520px at 0% 100%, rgba(56,211,155,.16), transparent 60%),
                radial-gradient(600px 420px at 50% 50%, rgba(167,139,250,.10), transparent 70%),
                #f4f7fc;
            position:relative;
            overflow-x:hidden;
        }
        body::before{
            content:"";
            position:fixed;
            inset:0;
            z-index:0;
            pointer-events:none;
            background-image:radial-gradient(rgba(10,25,47,.09) 1px, transparent 1px);
            background-size:22px 22px;
            opacity:.45;
            -webkit-mask-image:radial-gradient(circle at center, #000, transparent 78%);
            mask-image:radial-gradient(circle at center, #000, transparent 78%);
        }
        .crm-login{
            position:relative;
            z-index:1;
            width:100%;
            max-width:450px;
            background:#fff;
            border:1px solid rgba(255,255,255,.9);
            border-radius:24px;
            box-shadow:0 30px 80px -32px rgba(10,25,47,.35),0 2px 8px rgba(10,25,47,.05);
            padding:clamp(28px,5vw,44px);
        }
        .crm-login__lang{
            position:absolute;
            top:18px;
            inset-inline-end:18px;
            z-index:5;
        }
        .crm-login__lang-toggle{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:8px 12px;
            border:1px solid var(--crm-border);
            border-radius:10px;
            color:#46546d;
            background:#fff;
            font:500 13px inherit;
            cursor:pointer;
            transition:border-color .2s,color .2s;
        }
        .crm-login__lang-toggle:hover{border-color:var(--crm-brand);color:var(--crm-brand)}
        .crm-login__lang-toggle i:last-child{font-size:10px;margin-inline-start:2px}
        .crm-login__lang-menu{
            position:absolute;
            top:calc(100% + 8px);
            inset-inline-end:0;
            display:none;
            min-width:170px;
            padding:6px;
            background:#fff;
            border:1px solid var(--crm-border);
            border-radius:12px;
            box-shadow:0 16px 36px -16px rgba(10,25,47,.3);
        }
        .crm-login__lang-menu.is-open{display:block}
        .crm-login__lang-menu a{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:14px;
            padding:9px 11px;
            border-radius:8px;
            color:var(--crm-ink);
            font-size:14px;
            text-decoration:none;
        }
        .crm-login__lang-menu a:hover,
        .crm-login__lang-menu a.is-active{color:var(--crm-brand);background:var(--crm-brand-soft)}
        .crm-login__lang-menu small{color:#94a0b2;font-size:11px;font-weight:700}
        .crm-login__brand{
            display:flex;
            align-items:center;
            justify-content:center;
            min-height:104px;
            margin:16px 0 14px;
        }
        .crm-login__brand img{
            display:block;
            width:auto;
            height:auto;
            max-width:130px;
            max-height:104px;
            object-fit:contain;
        }
        .crm-login h1{
            margin:0;
            text-align:center;
            font-size:clamp(1.55rem,3vw,1.9rem);
            font-weight:700;
            line-height:1.35;
            color:var(--crm-ink);
        }
        .crm-login__subtitle{
            margin:6px 0 0;
            text-align:center;
            color:var(--crm-muted);
            font-size:15px;
            line-height:1.7;
        }
        .crm-login__alert{
            margin:20px 0 -4px;
            padding:12px 14px;
            border:1px solid #f2c5cc;
            border-radius:10px;
            color:#8e1d32;
            background:#fff5f6;
            font-size:14px;
            text-align:center;
        }
        .crm-login__fields{
            display:flex;
            flex-direction:column;
            gap:18px;
            margin-top:26px;
        }
        .crm-login__field label{
            display:block;
            margin-bottom:8px;
            color:var(--crm-ink);
            font-size:14px;
            font-weight:600;
        }
        .crm-login__control{position:relative}
        .crm-login__control>i{
            position:absolute;
            inset-inline-start:16px;
            top:50%;
            transform:translateY(-50%);
            color:#8a95a5;
            font-size:15px;
            line-height:1;
            pointer-events:none;
        }
        .crm-login__control input{
            width:100%;
            height:52px;
            padding-inline-start:46px;
            padding-inline-end:42px;
            border:1px solid var(--crm-border);
            border-radius:12px;
            outline:none;
            color:var(--crm-ink);
            background:var(--crm-brand-soft);
            font:inherit;
            font-size:15px;
            transition:border-color .2s,box-shadow .2s,background .2s;
        }
        .crm-login__control input:focus{
            border-color:var(--crm-brand);
            background:#fff;
            box-shadow:0 0 0 4px rgba(45,113,240,.13);
        }
        .crm-login__control input::placeholder{color:#8994a5}
        #loginSubmit{
            width:100%;
            height:54px;
            margin-top:26px;
            border:0;
            border-radius:12px;
            display:flex;
            justify-content:center;
            align-items:center;
            gap:10px;
            color:#fff;
            background:linear-gradient(135deg,var(--crm-brand),var(--crm-brand-strong));
            font:600 16px inherit;
            cursor:pointer;
            box-shadow:0 12px 26px -10px rgba(45,113,240,.65);
            transition:transform .2s,box-shadow .2s,filter .2s;
        }
        #loginSubmit:hover:not(:disabled){transform:translateY(-2px);filter:brightness(1.05);box-shadow:0 16px 32px -12px rgba(45,113,240,.75)}
        #loginSubmit:disabled{opacity:.72;cursor:wait;transform:none}
        .crm-login__footer{
            display:flex;
            align-items:center;
            justify-content:center;
            flex-wrap:wrap;
            gap:7px;
            margin-top:30px;
            color:#8a95a5;
            font-size:12.5px;
            text-align:center;
        }
        .crm-login__footer a{color:var(--crm-brand);text-decoration:none;font-weight:700}
        @media (max-width:480px){
            .crm-login{border-radius:20px}
            .crm-login__brand{min-height:88px}
            .crm-login__brand img{max-height:88px;max-width:110px}
        }
        @media (prefers-reduced-motion:reduce){#loginSubmit{transition:none}}
    </style>
</head>
<body>
    <main class="crm-login">
        @if(!empty($supportedLocales))
            <div class="crm-login__lang">
                <button type="button" class="crm-login__lang-toggle" aria-expanded="false" aria-controls="crmLanguageMenu">
                    <i class="fal fa-language" aria-hidden="true"></i>
                    <span>{{ $supportedLocales[$currentLocale]['native'] ?? strtoupper($currentLocale) }}</span>
                    <i class="fal fa-chevron-down" aria-hidden="true"></i>
                </button>
                <div class="crm-login__lang-menu" id="crmLanguageMenu">
                    @foreach($supportedLocales as $localeCode => $localeData)
                        <a href="{{ route('crm.lang', $localeCode) }}" class="{{ $currentLocale === $localeCode ? 'is-active' : '' }}">
                            <span>{{ $localeData['native'] ?? strtoupper($localeCode) }}</span>
                            <small>{{ strtoupper($localeCode) }}</small>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="crm-login__brand">
            <img src="{{ $loginLogo }}" alt="{{ $settings->website_name ?? 'Sanad' }}"
                 onerror="this.onerror=null;this.src='{{ asset('brand/logo.svg') }}';">
        </div>

        <h1>{{ __('auth.welcomeback') }}</h1>
        <p class="crm-login__subtitle">{{ $isAr ? 'سجّل الدخول لإدارة مساحة العمل الخاصة بك' : 'Sign in to manage your workspace' }}</p>

        @if(session('error'))
            <div class="crm-login__alert" role="alert">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="crm-login__alert" role="alert">{{ $errors->first() }}</div>
        @endif

        <form id="loginForm" action="{{ route('crm.login.attempt') }}" method="POST">
            @csrf
            <div class="crm-login__fields">
                <div class="crm-login__field">
                    <label for="email">{{ __('auth.email') }}</label>
                    <div class="crm-login__control">
                        <i class="fal fa-envelope" aria-hidden="true"></i>
                        <input type="text" id="email" name="email" value="{{ old('email') }}"
                               placeholder="{{ __('auth.placeholderEmail') }}"
                               autocomplete="username" data-validation="required" autofocus>
                    </div>
                </div>
                <div class="crm-login__field">
                    <label for="password">{{ __('auth.password') }}</label>
                    <div class="crm-login__control">
                        <i class="fal fa-lock" aria-hidden="true"></i>
                        <input type="password" id="password" name="password"
                               placeholder="••••••••••••••••"
                               autocomplete="current-password" data-validation="required">
                    </div>
                </div>
            </div>
            <button type="submit" id="loginSubmit">
                <span>{{ __('auth.sign in') }}</span>
                <i class="fal fa-arrow-left" aria-hidden="true"></i>
            </button>
        </form>

        <footer class="crm-login__footer">
            <span>{{ $main_setting->copyright_text ?? __('auth.All Rights Reserved.') }}</span>
            <span>© {{ date('Y') }}</span>
            <a href="http://sanadcx.com" target="_blank" rel="noopener">Sanad</a>
        </footer>
    </main>

    <script src="{{ asset('admin/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bundle/sweetalert2.bundle.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/toster/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/jquery_validator/form_validator/jquery.form-validator.min.js') }}"></script>
    <script>
        $(function () {
            $.validate({ ignore: 'input[type=hidden]', modules: 'date, security', lang: @json(app()->getLocale()), validateOnEvent: true });

            $('.crm-login__lang-toggle').on('click', function (event) {
                event.stopPropagation();
                const menu = $('#crmLanguageMenu'), open = menu.toggleClass('is-open').hasClass('is-open');
                $(this).attr('aria-expanded', open ? 'true' : 'false');
            });

            $(document).on('click', function (event) {
                if (!$(event.target).closest('.crm-login__lang').length) {
                    $('#crmLanguageMenu').removeClass('is-open');
                    $('.crm-login__lang-toggle').attr('aria-expanded', 'false');
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
                    .always(function () {
                        button.prop('disabled', false).html('<span>' + @json(__('auth.sign in')) + '</span><i class="fal fa-arrow-left" aria-hidden="true"></i>');
                    });
            });
        });
    </script>
</body>
</html>
