@extends('crm.layout')

@section('page-title', $pageTitle)

@section('style')
    <style>
        :root {
            --wb-green: #00a884;
            --wb-green-dark: #008069;
            --wb-bg: #f0f2f5;
            --wb-border: rgba(0, 0, 0, 0.08);
        }

        .wb-wrap {
            min-height: 78vh;
            background: var(--wb-bg);
            border: 1px solid var(--wb-border);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            display: flex;
            flex-direction: column;
        }

        .wb-head {
            padding: 12px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(180deg, rgba(0, 168, 132, 0.08), rgba(0, 168, 132, 0.03));
            border-bottom: 1px solid var(--wb-border);
        }

        .wb-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 900;
            color: rgba(0, 0, 0, 0.85);
        }

        .wb-wa-badge {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: var(--wb-green);
            color: #fff;
            display: grid;
            place-items: center;
            box-shadow: 0 8px 18px rgba(0, 168, 132, 0.25);
            flex: 0 0 auto;
        }

        .wb-body {
            padding: 14px;
            overflow: auto;
        }

        .wb-card {
            background: #fff;
            border: 1px solid var(--wb-border);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.06);
        }

        .wb-card-head {
            padding: 12px 14px;
            border-bottom: 1px solid var(--wb-border);
            font-weight: 900;
            color: rgba(0, 0, 0, 0.82);
            background: linear-gradient(180deg, rgba(0, 168, 132, 0.07), rgba(0, 168, 132, 0.02));
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .wb-card-body {
            padding: 14px;
        }

        .wb-pill {
            display: inline-flex;
            align-items: center;
            height: 28px;
            padding: 0 10px;
            border-radius: 999px;
            border: 1px solid rgba(0, 168, 132, 0.22);
            background: rgba(0, 168, 132, 0.08);
            color: rgba(0, 128, 105, 0.95);
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .wb-pill.is-danger {
            border-color: rgba(220, 53, 69, 0.25);
            background: rgba(220, 53, 69, 0.08);
            color: rgba(220, 53, 69, 0.95);
        }

        .wb-pill.is-ok {
            border-color: rgba(0, 168, 132, 0.22);
            background: rgba(0, 168, 132, 0.08);
            color: rgba(0, 128, 105, 0.95);
        }

        .wb-primary {
            height: 40px;
            padding: 0 14px;
            border-radius: 12px;
            border: 1px solid rgba(0, 168, 132, 0.25);
            background: var(--wb-green);
            color: #fff;
            font-weight: 900;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .wb-primary:hover {
            background: var(--wb-green-dark);
            color: #fff;
        }

        .wb-secondary {
            height: 40px;
            padding: 0 14px;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            background: #fff;
            color: rgba(0, 0, 0, 0.75);
            font-weight: 900;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .wb-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 12px;
        }

        @media (max-width: 1200px) {
            .wb-grid {
                grid-template-columns: 1fr;
            }
        }

        .wb-step {
            border: 1px solid rgba(0, 0, 0, 0.08);
            background: rgba(0, 0, 0, 0.02);
            border-radius: 14px;
            padding: 12px;
        }

        .wb-step-title {
            font-weight: 900;
            color: rgba(0, 0, 0, 0.82);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .wb-step-num {
            width: 30px;
            height: 30px;
            border-radius: 10px;
            background: rgba(0, 168, 132, 0.12);
            border: 1px solid rgba(0, 168, 132, 0.18);
            color: rgba(0, 128, 105, 0.95);
            display: grid;
            place-items: center;
            font-weight: 900;
            flex: 0 0 auto;
        }

        .wb-step-desc {
            margin-top: 8px;
            font-size: 13px;
            color: rgba(0, 0, 0, 0.62);
            line-height: 1.6;
        }

        .wb-kv {
            display: grid;
            grid-template-columns: 160px 1fr;
            gap: 10px;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        .wb-kv:last-child {
            border-bottom: 0;
        }

        .wb-kv-k {
            font-weight: 900;
            color: rgba(0, 0, 0, 0.72);
            font-size: 12px;
        }

        .wb-kv-v {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .wb-code {
            background: rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            padding: 8px 10px;
            font-size: 12px;
            font-weight: 900;
            color: rgba(0, 0, 0, 0.72);
            max-width: 100%;
            overflow: auto;
        }

        .wb-copy {
            height: 34px;
            padding: 0 12px;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            background: #fff;
            font-weight: 900;
            color: rgba(0, 0, 0, 0.72);
        }

        .wb-ill {
            width: 100%;
            max-height: 240px;
            object-fit: contain;
            display: block;
            margin: 6px auto 0;
            opacity: 0.95;
        }
    </style>
@endsection

@section('content')
    <div class="wb-wrap" id="whatsapp-setup-root"
         data-t-copied="{{ __('whatsapp_copied') }}">
        <div class="wb-head">
            <div class="wb-title">
                <span class="wb-wa-badge"><i class="fa fa-plug"></i></span>
                <span>{{ __('whatsapp_setup') }}</span>
            </div>
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                <a class="wb-secondary" href="{{ $metaAppsUrl }}" target="_blank" rel="noopener">
                    <i class="fa fa-external-link"></i> {{ __('whatsapp_open_meta_console') }}
                </a>
                <a class="wb-primary" href="{{ route('crm.whatsapp_business_settings') }}">
                    <i class="fa fa-cog"></i> {{ __('whatsapp_open_settings') }}
                </a>
            </div>
        </div>

        <div class="wb-body">
            <div class="wb-grid">
                <div class="wb-card">
                    <div class="wb-card-head">
                        <span>{{ __('whatsapp_setup_steps') }}</span>
                        <span class="wb-pill {{ ($hasActive ?? false) ? 'is-ok' : 'is-danger' }}">
                            {{ ($hasActive ?? false) ? __('whatsapp_connected') : __('whatsapp_not_connected') }}
                        </span>
                    </div>
                    <div class="wb-card-body" style="display:grid; gap:10px;">
                        <div class="wb-step">
                            <div class="wb-step-title">
                                <span class="wb-step-num">1</span>
                                <span>{{ __('whatsapp_step_create_app') }}</span>
                            </div>
                            <div class="wb-step-desc">{{ __('whatsapp_step_create_app_desc') }}</div>
                        </div>

                        <div class="wb-step">
                            <div class="wb-step-title">
                                <span class="wb-step-num">2</span>
                                <span>{{ __('whatsapp_step_add_product') }}</span>
                            </div>
                            <div class="wb-step-desc">{{ __('whatsapp_step_add_product_desc') }}</div>
                        </div>

                        <div class="wb-step">
                            <div class="wb-step-title">
                                <span class="wb-step-num">3</span>
                                <span>{{ __('whatsapp_step_webhook') }}</span>
                            </div>
                            <div class="wb-step-desc">{{ __('whatsapp_step_webhook_desc') }}</div>
                        </div>

                        <div class="wb-step">
                            <div class="wb-step-title">
                                <span class="wb-step-num">4</span>
                                <span>{{ __('whatsapp_step_tokens') }}</span>
                            </div>
                            <div class="wb-step-desc">{{ __('whatsapp_step_tokens_desc') }}</div>
                        </div>

                        <div class="wb-step">
                            <div class="wb-step-title">
                                <span class="wb-step-num">5</span>
                                <span>{{ __('whatsapp_step_fill_settings') }}</span>
                            </div>
                            <div class="wb-step-desc">{{ __('whatsapp_step_fill_settings_desc') }}</div>
                        </div>
                    </div>
                </div>

                <div class="wb-card">
                    <div class="wb-card-head">
                        <span>{{ __('whatsapp_setup_values') }}</span>
                        <span class="wb-pill {{ ($hasRequired ?? false) ? 'is-ok' : 'is-danger' }}">
                            {{ ($hasRequired ?? false) ? __('whatsapp_settings_ready') : __('whatsapp_settings_missing') }}
                        </span>
                    </div>
                    <div class="wb-card-body">
                        <div class="wb-kv">
                            <div class="wb-kv-k">{{ __('whatsapp_webhook_callback_url') }}</div>
                            <div class="wb-kv-v">
                                <div class="wb-code" data-copy="{{ $webhookUrl }}">{{ $webhookUrl }}</div>
                                <button class="wb-copy" type="button" data-copy-btn="{{ $webhookUrl }}">{{ __('whatsapp_copy') }}</button>
                            </div>
                        </div>
                        <div class="wb-kv">
                            <div class="wb-kv-k">{{ __('whatsapp_webhook_verify_url') }}</div>
                            <div class="wb-kv-v">
                                <div class="wb-code" data-copy="{{ $verifyUrl }}">{{ $verifyUrl }}</div>
                                <button class="wb-copy" type="button" data-copy-btn="{{ $verifyUrl }}">{{ __('whatsapp_copy') }}</button>
                            </div>
                        </div>
                        <div class="wb-kv">
                            <div class="wb-kv-k">{{ __('whatsapp_verify_token') }}</div>
                            <div class="wb-kv-v">
                                <div class="wb-code">{{ __('whatsapp_verify_token_hint') }}</div>
                            </div>
                        </div>
                        <div class="wb-kv">
                            <div class="wb-kv-k">{{ __('whatsapp_phone_number_id') }}</div>
                            <div class="wb-kv-v">
                                <span class="wb-pill">{{ data_get($settings, 'phone_number_id') ?: '—' }}</span>
                            </div>
                        </div>
                        <div class="wb-kv">
                            <div class="wb-kv-k">{{ __('whatsapp_api_version') }}</div>
                            <div class="wb-kv-v">
                                <span class="wb-pill">{{ data_get($settings, 'api_version') ?: '—' }}</span>
                            </div>
                        </div>

                        <img class="wb-ill" src="{{ asset('admin/assets/ill.svg') }}" alt="{{ __('whatsapp_setup') }}">
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
