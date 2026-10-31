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
    @if(($settings?->font ?? 'ibm') === 'thmanya')
    <link rel="preconnect" href="https://framerusercontent.com">
    <link rel="preconnect" href="https://fonts.thmanyah.com" crossorigin>
    <style>
        @font-face { font-family: 'Thmanya'; src: url('https://framerusercontent.com/assets/x6EBzvXf1Fi35XhsRoHxePDVo.woff2') format('woff2'); font-display: swap; font-style: normal; font-weight: 400; }
        @font-face { font-family: 'Thmanya'; src: url('https://framerusercontent.com/assets/Lh8puxCFq405qBv7dKpg9NsHZNk.woff2') format('woff2'); font-display: swap; font-style: normal; font-weight: 300; }
        @font-face { font-family: 'Thmanya'; src: url('https://framerusercontent.com/assets/oE98mOPE28KTzUeptOLRIaqW1I.woff2') format('woff2'); font-display: swap; font-style: normal; font-weight: 500; }
        @font-face { font-family: 'Thmanya'; src: url('https://framerusercontent.com/assets/LZvgFRUsP7pGWYj3tKxMUrKuhSY.woff2') format('woff2'); font-display: swap; font-style: normal; font-weight: 700; }
        @font-face { font-family: 'Thmanya'; src: url('https://framerusercontent.com/assets/ulQLGTktcl2Qq4AmD6RuVgELZKg.woff2') format('woff2'); font-display: swap; font-style: normal; font-weight: 900; }
    </style>
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('website/assets/css/styles.css') }}">
    @stack('styles')
    @if(($settings?->font ?? 'ibm') === 'thmanya')
    <style>
        :root{--sanad-font-family:'Thmanya','IBM Plex Sans Arabic',Tahoma,Arial,sans-serif!important;}
        html,body,button,input,select,textarea,h1,h2,h3,h4,h5,h6,p,span,a,li,div,label,td,th{font-family:'Thmanya','IBM Plex Sans Arabic',Tahoma,Arial,sans-serif!important;font-synthesis:none!important;font-synthesis-weight:none!important;}
    </style>
    @endif
</head>
