<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SANAD CX')</title>
    <meta name="description" content="@yield('meta_description', __('website.meta_description'))">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="{{ app()->getLocale() === 'ar' ? 'ar_SA' : 'en_US' }}">
    <meta property="og:site_name" content="Sanad CX">
    <meta property="og:title" content="@yield('og_title', 'SANAD CX')">
    <meta property="og:description" content="@yield('og_description', __('website.meta_description'))">
    <meta name="twitter:card" content="summary">
    <script type="application/ld+json">{"@@context":"https://schema.org","@@type":"Organization","name":"Sanad CX","email":"info@@sanadcx.com","telephone":["920022379","+966506591444"]}</script>
    <script>
      /* Resolve an explicit Light choice before paint; otherwise keep Dark. */
      (function () {
        try {
          if (window.localStorage.getItem('sanad-theme') === 'light') {
            delete document.documentElement.dataset.theme;
          }
        } catch (error) {
          /* Storage unavailable: keep the default Dark appearance. */
        }
      })();
    </script>
    <link rel="icon" type="image/svg+xml" href="{{ asset('website/assets/image/fav.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('website/assets/css/styles.css') }}">
    @stack('styles')
</head>
