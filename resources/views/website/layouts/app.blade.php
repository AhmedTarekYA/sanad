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
@php $waNumber = isset($settings) ? preg_replace('/[^0-9]/', '', $settings->whatsapp) : ''; @endphp
@if($waNumber)
    <button type="button" id="whatsapp-float-btn" class="whatsapp-float" aria-label="{{ __('auth.contact_via_whatsapp') }}"
            data-wa-url="https://wa.me/{{ $waNumber }}"
            data-track-url="{{ route('website.whatsapp.click') }}">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 0C7.164 0 0 7.164 0 16c0 2.825.745 5.482 2.041 7.783L.057 31.72a.667.667 0 00.823.823l7.937-1.984A15.933 15.933 0 0016 32c8.836 0 16-7.164 16-16S24.836 0 16 0zm9.208 22.792c-.384.384-1.579 1.192-2.171 1.192-.592 0-1.133-.267-2.683-1.049-1.133-.571-2.563-1.429-4.272-3.136-1.707-1.709-2.565-3.139-3.136-4.272-.782-1.55-1.049-2.091-1.049-2.683 0-.592.808-1.787 1.192-2.171.272-.272.635-.397.981-.397.171 0 .333.029.469.085.171.072.363.2.573.381.389.336.853.859 1.363 1.531.653.861 1.115 1.779 1.115 2.096 0 .205-.027.353-.091.512-.085.208-.235.397-.477.717-.139.184-.304.397-.488.64-.048.064-.096.131-.141.2.4.848 1.0 1.717 1.781 2.5.784.784 1.653 1.381 2.5 1.781.069-.045.136-.093.2-.141.243-.184.456-.349.64-.488.32-.242.509-.392.717-.477.159-.064.307-.091.512-.091.317 0 1.235.462 2.096 1.115.672.51 1.195.974 1.531 1.363.181.21.309.402.381.573.056.136.085.298.085.469 0 .346-.125.709-.397.981z"/>
        </svg>
    </button>
    <style>
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 30px;
            left: 30px;
            background-color: #25d366;
            color: #fff;
            border: none;
            border-radius: 50px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.5);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .whatsapp-float:hover {
            background-color: #128c7e;
            color: #fff;
            box-shadow: 0 6px 16px rgba(18, 140, 126, 0.6);
            transform: scale(1.1);
        }
        [dir="rtl"] .whatsapp-float {
            left: auto;
            right: 30px;
        }
        @media (max-width: 768px) {
            .whatsapp-float {
                width: 50px;
                height: 50px;
                bottom: 20px;
                left: 20px;
            }
            [dir="rtl"] .whatsapp-float {
                left: auto;
                right: 20px;
            }
            .whatsapp-float svg {
                width: 26px;
                height: 26px;
            }
        }
    </style>
    <script>
        (function () {
            var btn = document.getElementById('whatsapp-float-btn');
            if (!btn) return;
            btn.addEventListener('click', function () {
                var waUrl    = btn.getAttribute('data-wa-url');
                var trackUrl = btn.getAttribute('data-track-url');
                var page     = document.querySelector('html').getAttribute('data-sanad-page') || 'home';
                // Fire tracking request — open WhatsApp regardless of response
                fetch(trackUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ page: page }),
                }).catch(function () {});
                window.open(waUrl, '_blank', 'noopener,noreferrer');
            });
        })();
    </script>
@endif
@include('website.partials.scripts')
</body>
</html>
