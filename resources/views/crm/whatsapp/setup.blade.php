@extends('crm.layout')

@section('page-title', $pageTitle)

@section('style')
    <style>
        .wa-setup {
            padding-bottom: 8px;
        }

        .wa-intro {
            margin-bottom: 22px;
        }

        .wa-intro__title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
            color: var(--sanad-ink);
            font-size: clamp(1.45rem, 2vw, 1.9rem);
            font-weight: 700;
            line-height: 1.25;
        }

        .wa-intro__title .ph-duotone {
            color: var(--sanad-primary);
            font-size: 1.6rem;
        }

        .wa-intro p {
            margin: 6px 0 0;
            color: var(--sanad-muted);
            font-size: .92rem;
        }

        .wa-intro__badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 14px;
        }

        .wa-intro__actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }

        .wa-intro__actions .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 44px;
            padding-inline: 18px;
            border-radius: 12px;
            font-weight: 600;
        }

        .wa-intro__actions .btn-primary {
            border: 0;
            box-shadow: 0 8px 18px color-mix(in srgb, var(--sanad-primary) 22%, transparent);
        }

        .wa-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: .76rem;
            font-weight: 700;
            line-height: 1.2;
            white-space: nowrap;
        }

        .wa-status__dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
            box-shadow: 0 0 0 3px color-mix(in srgb, currentColor 16%, transparent);
        }

        .wa-status.is-ok {
            color: #0f7a58;
            border-color: color-mix(in srgb, var(--sanad-success) 38%, #fff);
            background: color-mix(in srgb, var(--sanad-success) 14%, #fff);
        }

        .wa-status.is-off {
            color: var(--sanad-danger);
            border-color: color-mix(in srgb, var(--sanad-danger) 28%, #fff);
            background: color-mix(in srgb, var(--sanad-danger) 9%, #fff);
        }

        .wa-panel {
            height: 100%;
            overflow: hidden;
            border: 1px solid var(--sanad-border);
            border-radius: var(--sanad-radius-md);
            background: var(--sanad-surface);
            box-shadow: var(--sanad-shadow-sm);
        }

        .wa-panel__head {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 18px 20px;
            border-bottom: 1px solid var(--sanad-border);
            background: linear-gradient(180deg, var(--sanad-surface-subtle), var(--sanad-surface));
        }

        .wa-panel__heading {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .wa-panel__icon {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            color: var(--sanad-primary);
            background: var(--sanad-primary-soft);
            font-size: 21px;
        }

        .wa-panel__heading h2 {
            margin: 0;
            color: var(--sanad-ink);
            font-size: 1.02rem;
            font-weight: 700;
        }

        .wa-panel__heading p {
            margin: 2px 0 0;
            color: var(--sanad-muted);
            font-size: .78rem;
            line-height: 1.5;
        }

        .wa-panel__body {
            padding: 20px;
        }

        .wa-steps {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .wa-step {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding-bottom: 14px;
        }

        .wa-step:last-child {
            padding-bottom: 0;
        }

        .wa-step:not(:last-child)::before {
            content: '';
            position: absolute;
            inset-block: 40px 4px;
            inset-inline-start: 17px;
            width: 2px;
            border-radius: 99px;
            background: linear-gradient(180deg, color-mix(in srgb, var(--sanad-primary) 35%, var(--sanad-border)), var(--sanad-border));
        }

        .wa-step__num {
            position: relative;
            z-index: 1;
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border: 1px solid color-mix(in srgb, var(--sanad-primary) 24%, var(--sanad-border));
            border-radius: 12px;
            color: var(--sanad-primary);
            background: var(--sanad-surface);
            font-size: .84rem;
            font-weight: 700;
            box-shadow: 0 4px 10px color-mix(in srgb, var(--sanad-primary) 12%, transparent);
        }

        .wa-step__card {
            flex: 1;
            min-width: 0;
            padding: 13px 16px;
            border: 1px solid var(--sanad-border);
            border-radius: 14px;
            background: var(--sanad-surface);
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .wa-step__card:hover {
            border-color: color-mix(in srgb, var(--sanad-primary) 30%, var(--sanad-border));
            box-shadow: var(--sanad-shadow-sm);
            transform: translateY(-1px);
        }

        .wa-step__title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            color: var(--sanad-ink);
            font-size: .9rem;
            font-weight: 700;
        }

        .wa-step__title .ph-duotone {
            color: var(--sanad-primary);
            font-size: 1.05rem;
        }

        .wa-step__desc {
            margin: 5px 0 0;
            color: var(--sanad-muted);
            font-size: .8rem;
            line-height: 1.65;
        }

        .wa-values {
            display: grid;
            gap: 10px;
        }

        .wa-value {
            padding: 13px 14px;
            border: 1px solid var(--sanad-border);
            border-radius: 14px;
            background: var(--sanad-surface-subtle);
        }

        .wa-value__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 8px;
        }

        .wa-value__label {
            display: flex;
            align-items: center;
            gap: 7px;
            min-width: 0;
            color: var(--sanad-ink);
            font-size: .79rem;
            font-weight: 600;
        }

        .wa-value__label .ph-duotone {
            color: var(--sanad-primary);
            font-size: 1rem;
        }

        .wa-copy {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            gap: 5px;
            min-height: 30px;
            padding-inline: 10px;
            border: 1px solid var(--sanad-border);
            border-radius: 9px;
            color: var(--sanad-muted);
            background: var(--sanad-surface);
            font-size: .72rem;
            font-weight: 600;
            transition: color .18s ease, border-color .18s ease, background .18s ease;
        }

        .wa-copy:hover,
        .wa-copy:focus-visible {
            color: var(--sanad-primary);
            border-color: color-mix(in srgb, var(--sanad-primary) 35%, var(--sanad-border));
            background: var(--sanad-primary-soft);
        }

        .wa-copy .ph-duotone {
            font-size: .95rem;
        }

        .wa-value__code {
            display: block;
            overflow: auto;
            margin: 0;
            padding: 9px 11px;
            border: 1px solid var(--sanad-border);
            border-radius: 10px;
            color: #42506a;
            background: var(--sanad-surface);
            font-size: .76rem;
            font-weight: 500;
            line-height: 1.5;
            white-space: nowrap;
        }

        .wa-value__hint {
            margin: 0;
            padding: 9px 11px;
            border: 1px dashed var(--sanad-border);
            border-radius: 10px;
            color: var(--sanad-muted);
            background: var(--sanad-surface);
            font-size: .76rem;
            line-height: 1.55;
        }

        .wa-illustration {
            position: relative;
            margin-top: 16px;
            padding: 18px;
            overflow: hidden;
            border: 1px solid color-mix(in srgb, var(--sanad-primary) 16%, var(--sanad-border));
            border-radius: 16px;
            background: linear-gradient(135deg, color-mix(in srgb, var(--sanad-primary) 10%, #fff), color-mix(in srgb, var(--sanad-success) 12%, #fff));
            text-align: center;
        }

        .wa-illustration img {
            display: block;
            width: 100%;
            max-width: 210px;
            max-height: 180px;
            margin: 0 auto;
            object-fit: contain;
        }

        .wa-illustration p {
            margin: 6px 0 0;
            color: #42506a;
            font-size: .76rem;
            font-weight: 600;
            line-height: 1.55;
        }

        @media (max-width: 767.98px) {
            .wa-panel__head,
            .wa-panel__body {
                padding: 16px;
            }

            .wa-intro__actions,
            .wa-intro__actions .btn {
                width: 100%;
            }

            .wa-intro__actions .btn {
                justify-content: center;
            }

            .wa-step__card {
                padding: 12px 14px;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $isConnected = (bool) ($hasActive ?? false);
        $isReady = (bool) ($hasRequired ?? false);
        $phoneNumberId = data_get($settings, 'phone_number_id');
        $apiVersion = data_get($settings, 'api_version');
        $verifyToken = data_get($settings, 'webhook_verify_token');
    @endphp

    <div class="wa-setup" id="whatsapp-setup-root" data-t-copied="{{ __('whatsapp_copied') }}">
        <div class="sanad-page-intro wa-intro">
            <div>
                <p class="sanad-page-intro__eyebrow">{{ __('whatsapp_menu') }}</p>
                <h1 class="wa-intro__title">
                    <i class="ph-duotone ph-plugs-connected" aria-hidden="true"></i>
                    {{ __('whatsapp_setup') }}
                </h1>
                <p>{{ __('whatsapp_setup_subtitle') }}</p>
                <div class="wa-intro__badges">
                    <span class="wa-status {{ $isConnected ? 'is-ok' : 'is-off' }}">
                        <span class="wa-status__dot"></span>
                        {{ $isConnected ? __('whatsapp_connected') : __('whatsapp_not_connected') }}
                    </span>
                    <span class="wa-status {{ $isReady ? 'is-ok' : 'is-off' }}">
                        <span class="wa-status__dot"></span>
                        {{ $isReady ? __('whatsapp_settings_ready') : __('whatsapp_settings_missing') }}
                    </span>
                </div>
            </div>
            <div class="wa-intro__actions">
                <a class="btn btn-outline-primary" href="{{ $metaAppsUrl }}" target="_blank" rel="noopener">
                    <i class="ph-duotone ph-arrow-square-out" aria-hidden="true"></i>
                    {{ __('whatsapp_open_meta_console') }}
                </a>
                <a class="btn btn-primary" href="{{ route('crm.whatsapp_business_settings') }}">
                    <i class="ph-duotone ph-gear" aria-hidden="true"></i>
                    {{ __('whatsapp_open_settings') }}
                </a>
            </div>
        </div>

        <div class="row g-4 align-items-stretch">
            <div class="col-lg-7">
                <div class="wa-panel">
                    <div class="wa-panel__head">
                        <div class="wa-panel__heading">
                            <span class="wa-panel__icon"><i class="ph-duotone ph-list-checks" aria-hidden="true"></i></span>
                            <div>
                                <h2>{{ __('whatsapp_setup_steps') }}</h2>
                                <p>{{ __('whatsapp_setup_subtitle') }}</p>
                            </div>
                        </div>
                        <span class="wa-status {{ $isConnected ? 'is-ok' : 'is-off' }}">
                            <span class="wa-status__dot"></span>
                            {{ $isConnected ? __('whatsapp_connected') : __('whatsapp_not_connected') }}
                        </span>
                    </div>

                    <div class="wa-panel__body">
                        <ol class="wa-steps">
                            @foreach([
                                ['icon' => 'ph-app-window', 'title' => 'whatsapp_step_create_app', 'desc' => 'whatsapp_step_create_app_desc'],
                                ['icon' => 'ph-whatsapp-logo', 'title' => 'whatsapp_step_add_product', 'desc' => 'whatsapp_step_add_product_desc'],
                                ['icon' => 'ph-webhooks-logo', 'title' => 'whatsapp_step_webhook', 'desc' => 'whatsapp_step_webhook_desc'],
                                ['icon' => 'ph-key', 'title' => 'whatsapp_step_tokens', 'desc' => 'whatsapp_step_tokens_desc'],
                                ['icon' => 'ph-check-square', 'title' => 'whatsapp_step_fill_settings', 'desc' => 'whatsapp_step_fill_settings_desc'],
                            ] as $stepIndex => $step)
                                <li class="wa-step">
                                    <span class="wa-step__num">{{ $stepIndex + 1 }}</span>
                                    <div class="wa-step__card">
                                        <h3 class="wa-step__title">
                                            <i class="ph-duotone {{ $step['icon'] }}" aria-hidden="true"></i>
                                            {{ __($step['title']) }}
                                        </h3>
                                        <p class="wa-step__desc">{{ __($step['desc']) }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="wa-panel">
                    <div class="wa-panel__head">
                        <div class="wa-panel__heading">
                            <span class="wa-panel__icon"><i class="ph-duotone ph-plug" aria-hidden="true"></i></span>
                            <div>
                                <h2>{{ __('whatsapp_setup_values') }}</h2>
                                <p>{{ __('whatsapp_verify_token_hint') }}</p>
                            </div>
                        </div>
                        <span class="wa-status {{ $isReady ? 'is-ok' : 'is-off' }}">
                            <span class="wa-status__dot"></span>
                            {{ $isReady ? __('whatsapp_settings_ready') : __('whatsapp_settings_missing') }}
                        </span>
                    </div>

                    <div class="wa-panel__body">
                        <div class="wa-values">
                            <div class="wa-value">
                                <div class="wa-value__head">
                                    <span class="wa-value__label">
                                        <i class="ph-duotone ph-link" aria-hidden="true"></i>
                                        {{ __('whatsapp_webhook_callback_url') }}
                                    </span>
                                    <button class="wa-copy" type="button" data-copy-btn="{{ $webhookUrl }}">
                                        <i class="ph-duotone ph-copy" aria-hidden="true"></i>
                                        {{ __('whatsapp_copy') }}
                                    </button>
                                </div>
                                <code class="wa-value__code" dir="ltr" data-copy="{{ $webhookUrl }}">{{ $webhookUrl }}</code>
                            </div>

                            <div class="wa-value">
                                <div class="wa-value__head">
                                    <span class="wa-value__label">
                                        <i class="ph-duotone ph-plugs-connected" aria-hidden="true"></i>
                                        {{ __('whatsapp_webhook_verify_url') }}
                                    </span>
                                    <button class="wa-copy" type="button" data-copy-btn="{{ $verifyUrl }}">
                                        <i class="ph-duotone ph-copy" aria-hidden="true"></i>
                                        {{ __('whatsapp_copy') }}
                                    </button>
                                </div>
                                <code class="wa-value__code" dir="ltr" data-copy="{{ $verifyUrl }}">{{ $verifyUrl }}</code>
                            </div>

                            <div class="wa-value">
                                <div class="wa-value__head">
                                    <span class="wa-value__label">
                                        <i class="ph-duotone ph-shield-check" aria-hidden="true"></i>
                                        {{ __('whatsapp_verify_token') }}
                                    </span>
                                    @if($verifyToken)
                                        <button class="wa-copy" type="button" data-copy-btn="{{ $verifyToken }}">
                                            <i class="ph-duotone ph-copy" aria-hidden="true"></i>
                                            {{ __('whatsapp_copy') }}
                                        </button>
                                    @endif
                                </div>
                                @if($verifyToken)
                                    <code class="wa-value__code" dir="ltr" data-copy="{{ $verifyToken }}">{{ $verifyToken }}</code>
                                @else
                                    <p class="wa-value__hint">{{ __('whatsapp_verify_token_hint') }}</p>
                                @endif
                            </div>

                            <div class="wa-value">
                                <div class="wa-value__head">
                                    <span class="wa-value__label">
                                        <i class="ph-duotone ph-phone" aria-hidden="true"></i>
                                        {{ __('whatsapp_phone_number_id') }}
                                    </span>
                                    @if($phoneNumberId)
                                        <button class="wa-copy" type="button" data-copy-btn="{{ $phoneNumberId }}">
                                            <i class="ph-duotone ph-copy" aria-hidden="true"></i>
                                            {{ __('whatsapp_copy') }}
                                        </button>
                                    @endif
                                </div>
                                @if($phoneNumberId)
                                    <code class="wa-value__code" dir="ltr" data-copy="{{ $phoneNumberId }}">{{ $phoneNumberId }}</code>
                                @else
                                    <p class="wa-value__hint">{{ __('whatsapp_settings_missing') }}</p>
                                @endif
                            </div>

                            <div class="wa-value">
                                <div class="wa-value__head">
                                    <span class="wa-value__label">
                                        <i class="ph-duotone ph-code" aria-hidden="true"></i>
                                        {{ __('whatsapp_api_version') }}
                                    </span>
                                    @if($apiVersion)
                                        <button class="wa-copy" type="button" data-copy-btn="{{ $apiVersion }}">
                                            <i class="ph-duotone ph-copy" aria-hidden="true"></i>
                                            {{ __('whatsapp_copy') }}
                                        </button>
                                    @endif
                                </div>
                                @if($apiVersion)
                                    <code class="wa-value__code" dir="ltr" data-copy="{{ $apiVersion }}">{{ $apiVersion }}</code>
                                @else
                                    <p class="wa-value__hint">{{ __('whatsapp_settings_missing') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="wa-illustration">
                            <img src="{{ asset('admin/assets/ill.svg') }}" alt="{{ __('whatsapp_setup') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        (function () {
            const root = document.getElementById('whatsapp-setup-root');
            if (!root) return;
            const tCopied = root.dataset.tCopied || 'Copied';
            document.addEventListener('click', function (e) {
                const btn = e.target && e.target.closest ? e.target.closest('[data-copy-btn]') : null;
                if (!btn) return;
                const text = btn.getAttribute('data-copy-btn') || '';
                if (!text) return;

                const done = function () {
                    if (window.successToster) {
                        successToster(tCopied);
                    } else {
                        alert(tCopied);
                    }
                };

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text).then(done);
                } else {
                    const el = document.createElement('textarea');
                    el.value = text;
                    document.body.appendChild(el);
                    el.select();
                    document.execCommand('copy');
                    document.body.removeChild(el);
                    done();
                }
            });
        })();
    </script>
@endsection
