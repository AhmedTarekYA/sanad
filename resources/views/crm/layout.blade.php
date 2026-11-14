<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', $pageTitle ?? config('app.name')) · {{ config('app.name') }}</title>
    @include('sanad.layout.inc._meta')
    @include('sanad.layout.inc._css')
    @yield('style')
</head>
<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" data-pc-theme="light"><script>(function(){var t=localStorage.getItem('sanad-theme');if(t==='auto')t=matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';if(t==='dark'||t==='light'){document.body.setAttribute('data-pc-theme',t);document.body.setAttribute('data-pc-sidebar-theme',t==='dark'?'dark':'light')}})();</script>
    <div class="loader-bg"><div class="loader-track"><div class="loader-fill"></div></div></div>
    @include('crm.partials.sidebar')
    @include('crm.partials.header')
    <main class="pc-container" id="main-content" tabindex="-1">
        <div class="pc-content">
            <div class="page-header"><div class="page-block"><ul class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="{{ route('crm.dashboard') }}">{{ __('auth.home') }}</a></li><li class="breadcrumb-item active" aria-current="page"><span>@yield('page-title', $pageTitle ?? '')</span></li></ul></div></div>
            @yield('content')
        </div>
    </main>
    <footer class="pc-footer"><div class="footer-wrapper container-fluid"><div class="row"><div class="col-sm-6 my-1"><p class="m-0">{{ $main_setting->copyright_text ?? __('auth.All Rights Reserved.') }} © {{ date('Y') }}</p></div><div class="col-sm-6 ms-auto my-1"><ul class="list-inline footer-link mb-0 justify-content-sm-end d-flex"><li class="list-inline-item"><a href="{{ route('crm.dashboard') }}">{{ __('auth.home') }}</a></li></ul></div></div></div></footer>
    @include('sanad.layout.inc._js')
    @include('sanad.layout.inc._js_custom')
    @yield('js')
</body>
</html>
