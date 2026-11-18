<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', $pageTitle ?? config('app.name')) · {{ config('app.name') }}</title>
    @include('sanad.layout.inc._meta')
    @include('sanad.layout.inc._css')
    {{-- Font Awesome Pro (Light/Solid/Regular/Brands) for the CRM area only --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/fontawesome.min.css') }}">
    @yield('style')
</head>
<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" data-pc-theme="light"><script>(function(){var t=localStorage.getItem('sanad-theme');if(t==='auto')t=matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';if(t==='dark'||t==='light'){document.body.setAttribute('data-pc-theme',t);document.body.setAttribute('data-pc-sidebar-theme',t==='dark'?'dark':'light')}})();</script>
    <div class="loader-bg"><div class="loader-track"><div class="loader-fill"></div></div></div>
    @include('crm.partials.sidebar')
    @include('crm.partials.header')
    <main class="pc-container" id="main-content" tabindex="-1">
        <div class="pc-content">
            @yield('content')
        </div>
    </main>
    @include('sanad.layout.inc._js')
    @include('sanad.layout.inc._js_custom')
    @yield('js')
</body>
</html>
