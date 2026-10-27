<!DOCTYPE html>
<html data-sanad-page="@yield('page_key', '')" lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" data-theme="dark">
@include('website.partials.head')
<body>
@include('website.partials.header')
<main id="main">
    @yield('content')
</main>
@include('website.partials.footer')
@include('website.partials.consultation')
@include('website.partials.scripts')
</body>
</html>
