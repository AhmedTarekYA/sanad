@extends('crm.layout')

@section('page-title', $pageTitle)

@section('style')
    <style>
        .crm-dashboard-coming {
            --coming-border: var(--crm-border);
            --coming-surface: var(--crm-card);
            --coming-muted: var(--crm-muted);
            position: relative;
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(300px, .9fr);
            align-items: center;
            gap: clamp(24px, 5vw, 72px);
            min-height: min(620px, calc(100vh - 150px));
            padding: clamp(28px, 6vw, 76px);
            overflow: hidden;
            border: 1px solid var(--coming-border);
            border-radius: 28px;
            background: var(--coming-surface);
            color: var(--crm-ink);
        }

        .crm-dashboard-coming__copy { position: relative; z-index: 1; }
        .crm-dashboard-coming__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 22px;
            padding: 9px 14px;
            border: 1px solid color-mix(in srgb, var(--crm-brand) 24%, transparent);
            border-radius: 999px;
            background: color-mix(in srgb, var(--crm-brand) 9%, transparent);
            color: var(--crm-brand);
            font-size: .9rem;
            font-weight: 700;
        }
        .crm-dashboard-coming__eyebrow i { font-size: .8rem; }
        .crm-dashboard-coming h1 {
            max-width: 680px;
            margin: 0 0 18px;
            color: var(--crm-ink);
            font-size: clamp(2.6rem, 6vw, 5.1rem);
            font-weight: 900;
            line-height: 1.1;
            text-wrap: balance;
        }
        .crm-dashboard-coming__lead {
            max-width: 570px;
            margin: 0;
            color: var(--coming-muted);
            font-size: clamp(1.05rem, 1.7vw, 1.25rem);
            line-height: 1.8;
            text-wrap: pretty;
        }
        .crm-dashboard-coming__features {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 28px;
        }
        .crm-dashboard-coming__feature {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 13px;
            border: 1px solid var(--coming-border);
            border-radius: 12px;
            background: var(--crm-bg);
            color: var(--crm-ink);
            font-size: .88rem;
            font-weight: 600;
        }
        .crm-dashboard-coming__feature i { color: var(--crm-brand); }
        .crm-dashboard-coming__action {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-top: 32px;
            padding: 13px 19px;
            border-radius: 13px;
            background: var(--crm-brand);
            color: #fff !important;
            font-weight: 700;
            text-decoration: none;
            transition: transform .18s ease, opacity .18s ease;
        }
        .crm-dashboard-coming__action:hover { transform: translateY(-2px); opacity: .92; }

        .crm-dashboard-coming__visual {
            position: relative;
            display: grid;
            min-height: 340px;
            place-items: center;
            isolation: isolate;
        }
        .crm-dashboard-coming__orbit {
            position: absolute;
            width: min(80%, 310px);
            aspect-ratio: 1;
            border: 1px solid color-mix(in srgb, var(--crm-brand) 20%, var(--coming-border));
            border-radius: 50%;
        }
        .crm-dashboard-coming__orbit::before,
        .crm-dashboard-coming__orbit::after {
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--crm-brand);
            content: '';
        }
        .crm-dashboard-coming__orbit::before { top: 13%; inset-inline-end: 17%; }
        .crm-dashboard-coming__orbit::after { bottom: 17%; inset-inline-start: 12%; width: 7px; height: 7px; opacity: .55; }
        .crm-dashboard-coming__preview {
            position: relative;
            z-index: 1;
            width: min(100%, 330px);
            padding: 21px;
            border: 1px solid var(--coming-border);
            border-radius: 22px;
            background: var(--coming-surface);
            box-shadow: 0 22px 60px rgba(11, 12, 16, .12);
        }
        .crm-dashboard-coming__preview-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .crm-dashboard-coming__preview-label { color: var(--coming-muted); font-size: .82rem; font-weight: 600; }
        .crm-dashboard-coming__preview-icon {
            display: grid;
            width: 38px;
            height: 38px;
            place-items: center;
            border-radius: 12px;
            background: color-mix(in srgb, var(--crm-brand) 10%, transparent);
            color: var(--crm-brand);
        }
        .crm-dashboard-coming__preview-value { margin-bottom: 19px; color: var(--crm-ink); font-size: 1.65rem; font-weight: 800; }
        .crm-dashboard-coming__bars { display: flex; height: 94px; align-items: end; gap: 9px; }
        .crm-dashboard-coming__bars span {
            flex: 1;
            height: var(--bar-height);
            border-radius: 7px 7px 3px 3px;
            background: color-mix(in srgb, var(--crm-brand) 22%, var(--crm-bg));
            transform-origin: bottom;
            animation: crm-dashboard-bar 1.8s ease-in-out infinite alternate;
            animation-delay: var(--bar-delay);
        }
        .crm-dashboard-coming__bars span:nth-child(4) { background: var(--crm-brand); }
        .crm-dashboard-coming__float {
            position: absolute;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            border: 1px solid var(--coming-border);
            border-radius: 14px;
            background: var(--coming-surface);
            color: var(--crm-ink);
            box-shadow: 0 12px 30px rgba(11, 12, 16, .1);
            font-size: .82rem;
            font-weight: 700;
            animation: crm-dashboard-float 3.2s ease-in-out infinite;
        }
        .crm-dashboard-coming__float i { color: var(--crm-brand); }
        .crm-dashboard-coming__float--top { top: 12%; inset-inline-end: 0; animation-delay: -.8s; }
        .crm-dashboard-coming__float--bottom { bottom: 12%; inset-inline-start: 0; animation-delay: -1.7s; }

        @keyframes crm-dashboard-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        @keyframes crm-dashboard-bar {
            from { transform: scaleY(.78); opacity: .75; }
            to { transform: scaleY(1); opacity: 1; }
        }
        @media (max-width: 900px) {
            .crm-dashboard-coming { grid-template-columns: 1fr; min-height: auto; padding: 34px; }
            .crm-dashboard-coming__visual { min-height: 300px; }
        }
        @media (max-width: 575px) {
            .crm-dashboard-coming { gap: 20px; padding: 26px 20px; border-radius: 20px; }
            .crm-dashboard-coming h1 { font-size: 2.65rem; }
            .crm-dashboard-coming__visual { min-height: 260px; }
            .crm-dashboard-coming__preview { width: min(88%, 300px); }
            .crm-dashboard-coming__float { font-size: .72rem; }
        }
        @media (prefers-reduced-motion: reduce) {
            .crm-dashboard-coming__float,
            .crm-dashboard-coming__bars span { animation: none; }
            .crm-dashboard-coming__action { transition: none; }
        }
        @media (prefers-reduced-motion: no-preference) {
            .crm-dashboard-coming:not(.is-visible) .crm-dashboard-coming__float,
            .crm-dashboard-coming:not(.is-visible) .crm-dashboard-coming__bars span { animation-play-state: paused; }
        }
    </style>
@endsection

@section('content')
    @php($isArabic = app()->getLocale() === 'ar')
    <section class="crm-dashboard-coming" id="crm-dashboard-coming" aria-labelledby="crm-dashboard-coming-title">
        <div class="crm-dashboard-coming__copy">
            <div class="crm-dashboard-coming__eyebrow">
                <i class="fas fa-sparkles" aria-hidden="true"></i>
                <span>{{ $isArabic ? 'نعمل على تجربة جديدة لك' : 'A new experience is on the way' }}</span>
            </div>
            <h1 id="crm-dashboard-coming-title">{{ $isArabic ? 'قريباً' : 'Coming soon' }}</h1>
            <p class="crm-dashboard-coming__lead">
                {{ $isArabic
                    ? 'نجهّز لك لوحة تجمع أهم تفاصيل عملك في مكان واحد. قريباً ستتابع محادثاتك وأداء فريقك ومؤشرات عملك من نظرة واحدة.'
                    : 'We’re bringing your work together in one place. Soon, you’ll be able to follow conversations, team performance, and business insights at a glance.' }}
            </p>
            <div class="crm-dashboard-coming__features" aria-label="{{ $isArabic ? 'مزايا قادمة' : 'Coming features' }}">
                <span class="crm-dashboard-coming__feature"><i class="fas fa-comments" aria-hidden="true"></i>{{ $isArabic ? 'ملخص المحادثات' : 'Conversation overview' }}</span>
                <span class="crm-dashboard-coming__feature"><i class="fas fa-chart-line" aria-hidden="true"></i>{{ $isArabic ? 'مؤشرات الأداء' : 'Performance insights' }}</span>
                <span class="crm-dashboard-coming__feature"><i class="fas fa-users" aria-hidden="true"></i>{{ $isArabic ? 'متابعة الفريق' : 'Team activity' }}</span>
            </div>
            <a class="crm-dashboard-coming__action" href="{{ route('crm.whatsapp_chat') }}">
                <span>{{ $isArabic ? 'اذهب إلى المحادثات' : 'Go to conversations' }}</span>
                <i class="fas fa-arrow-left" aria-hidden="true"></i>
            </a>
        </div>

        <div class="crm-dashboard-coming__visual" aria-hidden="true">
            <div class="crm-dashboard-coming__orbit"></div>
            <div class="crm-dashboard-coming__preview">
                <div class="crm-dashboard-coming__preview-head">
                    <span class="crm-dashboard-coming__preview-label">{{ $isArabic ? 'نظرة عامة' : 'Overview' }}</span>
                    <span class="crm-dashboard-coming__preview-icon"><i class="fas fa-chart-pie"></i></span>
                </div>
                <div class="crm-dashboard-coming__preview-value">{{ $isArabic ? 'لوحتك القادمة' : 'Your next dashboard' }}</div>
                <div class="crm-dashboard-coming__bars">
                    <span style="--bar-height:42%;--bar-delay:-.2s"></span>
                    <span style="--bar-height:68%;--bar-delay:-.8s"></span>
                    <span style="--bar-height:52%;--bar-delay:-1.1s"></span>
                    <span style="--bar-height:86%;--bar-delay:-.5s"></span>
                    <span style="--bar-height:62%;--bar-delay:-1.4s"></span>
                    <span style="--bar-height:100%;--bar-delay:-.9s"></span>
                    <span style="--bar-height:76%;--bar-delay:-.3s"></span>
                </div>
            </div>
            <div class="crm-dashboard-coming__float crm-dashboard-coming__float--top"><i class="fas fa-message"></i>{{ $isArabic ? 'محادثاتك في مكان واحد' : 'Your conversations, together' }}</div>
            <div class="crm-dashboard-coming__float crm-dashboard-coming__float--bottom"><i class="fas fa-arrow-trend-up"></i>{{ $isArabic ? 'أداء أوضح' : 'A clearer view of performance' }}</div>
        </div>
    </section>
    @include('crm.partials.help-modal', [
        'title' => $isArabic ? 'الرئيسية' : 'Dashboard',
        'description' => $isArabic
            ? 'قريباً ستعرض الصفحة ملخصاً للمحادثات ومؤشرات الأداء ونشاط الفريق.'
            : 'This page will soon bring together conversation summaries, performance insights, and team activity.',
    ])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var dashboard = document.getElementById('crm-dashboard-coming');
            if (!dashboard || !('IntersectionObserver' in window)) {
                if (dashboard) dashboard.classList.add('is-visible');
                return;
            }

            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    dashboard.classList.toggle('is-visible', entry.isIntersecting);
                });
            });
            observer.observe(dashboard);
        });
    </script>
@endsection
