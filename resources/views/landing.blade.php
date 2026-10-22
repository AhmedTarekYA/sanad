<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings?->website_name ?? config('app.name') }}</title>
    <meta name="description" content="{{ $settings?->website_name ?? config('app.name') }}">

    @if($settings?->favicon)
        <link rel="icon" href="{{ showFile($settings->favicon) }}" type="image/x-icon">
    @endif

    {{-- Bootstrap RTL / LTR --}}
    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    @endif

    <style>
        :root {
            --brand: #2d71f0;
            --brand-dark: #1a5cd4;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f0f5ff 0%, #e8f0fe 50%, #f5f0ff 100%);
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        /* ── Hero ── */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 3rem 1rem;
        }

        .hero-logo {
            max-height: 90px;
            max-width: 220px;
            object-fit: contain;
            margin-bottom: 2rem;
            filter: drop-shadow(0 4px 12px rgba(45,113,240,.15));
        }

        .hero-title {
            font-size: clamp(2rem, 6vw, 3.5rem);
            font-weight: 800;
            background: linear-gradient(135deg, var(--brand), #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .hero-subtitle {
            font-size: 1.15rem;
            color: #64748b;
            max-width: 420px;
        }

        /* ── WhatsApp Float ── */
        .whatsapp-float {
            position: fixed;
            bottom: 28px;
            {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}: 28px;
            width: 60px;
            height: 60px;
            background: #25d366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 24px rgba(37,211,102,.45);
            transition: transform .2s, box-shadow .2s;
            z-index: 9999;
            text-decoration: none;
        }

        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 32px rgba(37,211,102,.6);
        }

        .whatsapp-float svg {
            width: 34px;
            height: 34px;
            fill: #fff;
        }

        /* ── Pulse ring ── */
        .whatsapp-float::before {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            border: 3px solid rgba(37,211,102,.4);
            animation: pulse-ring 2s ease-out infinite;
        }

        @keyframes pulse-ring {
            0%   { transform: scale(1); opacity: .8; }
            100% { transform: scale(1.5); opacity: 0; }
        }

        /* ── Footer ── */
        footer {
            text-align: center;
            padding: .75rem 1rem;
            color: #94a3b8;
            font-size: .8rem;
        }
    </style>
</head>
<body>

    <section class="hero">
        @if($settings?->logo_header)
            <img src="{{ showFile($settings->logo_header) }}" alt="{{ $settings?->website_name }}" class="hero-logo">
        @endif

        <h1 class="hero-title">مرحبا بكم</h1>

        @if($settings?->website_name)
            <p class="hero-subtitle">{{ $settings->website_name }}</p>
        @endif
    </section>

    @if($settings?->whatsapp)
        @php($wa = preg_replace('/[^0-9+]/', '', $settings->whatsapp))
        <a href="https://wa.me/{{ ltrim($wa, '+') }}" class="whatsapp-float" target="_blank" rel="noopener"
           aria-label="تواصل معنا عبر واتساب">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
        </a>
    @endif

    <footer>
        &copy; {{ date('Y') }} {{ $settings?->website_name ?? config('app.name') }}
    </footer>

</body>
</html>
