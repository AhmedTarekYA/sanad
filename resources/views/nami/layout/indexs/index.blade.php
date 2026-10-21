<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', config('app.name')) · {{ config('app.name') }}</title>
    @include('nami.layout.inc._meta')
    @include('nami.layout.inc._css')
    @yield('style')
</head>
<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" data-pc-theme="light"><script>(function(){var t=localStorage.getItem('nami-theme');if(t==='auto')t=matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';if(t==='dark'||t==='light'){document.body.setAttribute('data-pc-theme',t);document.body.setAttribute('data-pc-sidebar-theme',t==='dark'?'dark':'light')}})();</script>
    <div class="loader-bg"><div class="loader-track"><div class="loader-fill"></div></div></div>
    @include('nami.layout.inc.sidebar')
    @include('nami.layout.inc.header')
    <main class="pc-container" id="main-content" tabindex="-1">
        <div class="pc-content">
            @unless(request()->routeIs('dashboard.index'))
                <div class="page-header"><div class="page-block"><ul class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ __('auth.home') }}</a></li>@hasSection('page-links') @yield('page-links') @else <li class="breadcrumb-item active" aria-current="page"><span>@yield('page-title')</span></li> @endif</ul></div></div>
            @endunless
            @yield('content')
            @yield('up-card')
        </div>
    </main>
    @include('nami.layout.inc.footer')
    @include('nami.layout.inc.global_modals')
    @include('nami.layout.inc._js')
    @include('nami.layout.inc._js_custom')
    @yield('js')
</body>
</html>
