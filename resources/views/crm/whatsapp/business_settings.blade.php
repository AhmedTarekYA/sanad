@extends('crm.layout')

@section('page-title', $pageTitle)

@section('style')
    <style>
        .wa-settings {
            --wa-radius: var(--sanad-radius-md);
            --wa-shadow: var(--sanad-shadow-sm);
            --wa-shadow-lg: var(--sanad-shadow-md);
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

        .wa-list {
            display: grid;
            gap: 18px;
        }

        .wa-account {
            overflow: hidden;
            border: 1px solid var(--sanad-border);
            border-radius: var(--wa-radius);
            background: var(--sanad-surface);
            box-shadow: var(--wa-shadow);
            transition: box-shadow .2s ease, border-color .2s ease;
        }

        .wa-account:hover {
            border-color: color-mix(in srgb, var(--sanad-primary) 28%, var(--sanad-border));
            box-shadow: var(--wa-shadow-lg);
        }

        .wa-account__head {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--sanad-border);
            background: linear-gradient(180deg, var(--sanad-surface-subtle), var(--sanad-surface));
        }

        .wa-account__identity {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .wa-account__avatar {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            color: var(--sanad-primary);
            background: var(--sanad-primary-soft);
            font-size: 20px;
        }

        .wa-account__copy {
            min-width: 0;
        }

        .wa-account__name {
            display: block;
            overflow: hidden;
            color: var(--sanad-ink);
            font-size: 1rem;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .wa-account__meta {
            display: block;
            margin-top: 1px;
            color: var(--sanad-muted);
            font-size: .76rem;
            font-weight: 500;
        }

        .wa-account__actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
        }

        .wa-switch {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            min-height: 34px;
            margin: 0;
            padding: 4px 12px;
            border: 1px solid var(--sanad-border);
            border-radius: 999px;
            background: var(--sanad-surface);
        }

        .wa-switch .form-check-input {
            width: 2.15rem;
            height: 1.15rem;
            margin: 0;
            cursor: pointer;
        }

        .wa-switch .form-check-input:checked {
            border-color: var(--sanad-primary);
            background-color: var(--sanad-primary);
        }

        .wa-switch .form-check-label {
            margin: 0;
            color: var(--sanad-muted);
            font-size: .8rem;
            font-weight: 600;
            cursor: pointer;
        }

        .wa-account__body {
            padding: 20px;
        }

        .wa-field {
            position: relative;
        }

        .wa-field__icon {
            position: absolute;
            inset-inline-start: 14px;
            top: 23px;
            z-index: 2;
            transform: translateY(-50%);
            color: var(--sanad-muted);
            font-size: 1.05rem;
            line-height: 1;
            pointer-events: none;
        }

        .wa-field .form-control {
            min-height: 46px;
            padding-inline-start: 2.7rem;
            border-color: var(--sanad-border);
            border-radius: 12px;
            background: var(--sanad-surface);
            color: var(--sanad-ink);
            font-size: .88rem;
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .wa-field.has-toggle .form-control {
            padding-inline-end: 2.9rem;
        }

        .wa-field .form-control:focus {
            border-color: var(--sanad-primary);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--sanad-primary) 16%, transparent);
        }

        .wa-field .form-text {
            margin-top: 6px;
            color: var(--sanad-muted);
            font-size: .74rem;
        }

        .wa-secret-toggle {
            position: absolute;
            inset-inline-end: 7px;
            top: 23px;
            z-index: 3;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            padding: 0;
            border: 0;
            border-radius: 9px;
            color: var(--sanad-muted);
            background: transparent;
            font-size: 1.05rem;
            transform: translateY(-50%);
            transition: color .18s ease, background .18s ease;
        }

        .wa-secret-toggle:hover,
        .wa-secret-toggle:focus-visible {
            color: var(--sanad-primary);
            background: var(--sanad-primary-soft);
        }

        .wa-remove {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            min-height: 36px;
            border-radius: 10px;
            font-size: .8rem;
            font-weight: 600;
        }

        .wa-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
            padding: 48px 24px;
            border: 1px dashed color-mix(in srgb, var(--sanad-primary) 28%, var(--sanad-border));
            border-radius: var(--wa-radius);
            background: var(--sanad-surface);
            box-shadow: var(--wa-shadow);
            text-align: center;
        }

        .wa-empty[hidden] {
            display: none !important;
        }

        .wa-empty__icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border-radius: 18px;
            color: var(--sanad-primary);
            background: var(--sanad-primary-soft);
            font-size: 30px;
        }

        .wa-empty h3 {
            margin: 0;
            color: var(--sanad-ink);
            font-size: 1.05rem;
            font-weight: 700;
        }

        .wa-empty p {
            max-width: 44ch;
            margin: 0;
            color: var(--sanad-muted);
            font-size: .86rem;
            line-height: 1.6;
        }

        .wa-savebar {
            position: sticky;
            bottom: 14px;
            z-index: 20;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-top: 20px;
            padding: 14px 18px;
            border: 1px solid var(--sanad-border);
            border-radius: var(--wa-radius);
            background: color-mix(in srgb, var(--sanad-surface) 92%, transparent);
            box-shadow: var(--wa-shadow-lg);
            backdrop-filter: blur(8px);
        }

        .wa-savebar__hint {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            color: var(--sanad-muted);
            font-size: .8rem;
        }

        .wa-savebar__hint .ph-duotone {
            color: var(--sanad-primary);
            font-size: 1.15rem;
        }

        .wa-savebar .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 44px;
            padding-inline: 22px;
            border: 0;
            border-radius: 12px;
            font-weight: 600;
            box-shadow: 0 8px 18px color-mix(in srgb, var(--sanad-primary) 24%, transparent);
        }

        .wa-intro .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 44px;
            padding-inline: 18px;
            border: 0;
            border-radius: 12px;
            font-weight: 600;
            box-shadow: 0 8px 18px color-mix(in srgb, var(--sanad-primary) 22%, transparent);
        }

        @media (max-width: 767.98px) {
            .wa-account__head,
            .wa-account__body {
                padding: 16px;
            }

            .wa-account__actions {
                width: 100%;
                justify-content: space-between;
            }

            .wa-savebar,
            .wa-intro .btn-primary {
                width: 100%;
            }

            .wa-savebar .btn-primary {
                justify-content: center;
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $hasAccounts = isset($whatsapp_settings) && $whatsapp_settings->count() > 0;

        $accounts = $hasAccounts
            ? $whatsapp_settings->map(function ($setting) {
                return [
                    'id' => $setting->id,
                    'name' => $setting->name,
                    'is_active' => (bool) $setting->is_active,
                    'api_version' => $setting->api_version ?: 'v20.0',
                    'phone_number_id' => $setting->phone_number_id,
                    'business_account_id' => $setting->business_account_id,
                    'access_token' => $setting->access_token,
                    'webhook_verify_token' => $setting->webhook_verify_token,
                    'app_secret' => $setting->app_secret,
                ];
            })->values()
            : collect();

        $accountLabels = json_encode([
            'account' => __('whatsapp_account'),
            'accountName' => __('whatsapp_account_name'),
            'active' => __('is_active'),
            'remove' => __('remove'),
            'addAccount' => __('whatsapp_add_account'),
            'savedPlaceholder' => __('whatsapp_saved_placeholder'),
            'apiVersion' => __('whatsapp_api_version'),
            'phoneNumberId' => __('whatsapp_phone_number_id'),
            'businessAccountId' => __('whatsapp_business_account_id'),
            'accessToken' => __('whatsapp_access_token'),
            'webhookVerifyToken' => __('whatsapp_webhook_verify_token'),
            'appSecret' => __('whatsapp_app_secret'),
            'deleteTitle' => __('whatsapp_delete_account_title'),
            'deleteText' => __('whatsapp_delete_account_confirmation'),
            'deleteConfirm' => __('whatsapp_confirm_delete_button'),
            'cancel' => __('buttons.cancel'),
            'showSecret' => __('whatsapp_show_secret'),
            'hideSecret' => __('whatsapp_hide_secret'),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    @endphp

    <div class="wa-settings">
        <div class="sanad-page-intro wa-intro">
            <div>
                <p class="sanad-page-intro__eyebrow">{{ __('whatsapp_menu') }}</p>
                <h1 class="wa-intro__title">
                    <i class="ph-duotone ph-whatsapp-logo" aria-hidden="true"></i>
                    {{ __('whatsapp_business_settings') }}
                </h1>
                <p>{{ __('whatsapp_settings_edit_hint') }}</p>
            </div>
            <button type="button" class="btn btn-primary" id="add-whatsapp-account" data-add-account>
                <i class="ph-duotone ph-plus" aria-hidden="true"></i>
                {{ __('whatsapp_add_account') }}
            </button>
        </div>

        <form class="from-submit-global" method="post" action="{{ route('crm.whatsapp_business_settings.store') }}">
            @csrf
            <div id="whatsapp-account-labels" class="d-none" data-labels='{{ $accountLabels }}'></div>

            <div id="whatsapp-accounts-list" class="wa-list">
                @foreach($accounts as $index => $account)
                    <div class="wa-account" data-account-item data-index="{{ $index }}"
                         @if($account['id']) data-delete-url="{{ route('crm.whatsapp_business_settings.destroy', $account['id']) }}" @endif>
                        <div class="wa-account__head">
                            <div class="wa-account__identity">
                                <span class="wa-account__avatar"><i class="ph-duotone ph-whatsapp-logo" aria-hidden="true"></i></span>
                                <div class="wa-account__copy">
                                    <strong class="wa-account__name" data-account-title>{{ $account['name'] ?: __('whatsapp_account') . ' ' . ($index + 1) }}</strong>
                                    <span class="wa-account__meta">{{ __('whatsapp_account') }}</span>
                                </div>
                            </div>

                            <div class="wa-account__actions">
                                <div class="form-check form-switch wa-switch">
                                    <input type="hidden" name="accounts[{{ $index }}][is_active]" value="0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                           name="accounts[{{ $index }}][is_active]"
                                           id="active_account_selector_{{ $index }}" value="1" data-active-checkbox
                                           {{ !empty($account['is_active']) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active_account_selector_{{ $index }}">
                                        {{ __('is_active') }}
                                    </label>
                                </div>

                                <button type="button" class="btn btn-sm btn-outline-danger wa-remove" data-remove-account>
                                    <i class="ph-duotone ph-trash" aria-hidden="true"></i>
                                    {{ __('remove') }}
                                </button>
                            </div>
                        </div>

                        <div class="wa-account__body">
                            <input type="hidden" name="accounts[{{ $index }}][id]" value="{{ $account['id'] }}">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="account_name_{{ $index }}">{{ __('whatsapp_account_name') }}</label>
                                    <div class="wa-field">
                                        <i class="ph-duotone ph-tag wa-field__icon" aria-hidden="true"></i>
                                        <input type="text" id="account_name_{{ $index }}" name="accounts[{{ $index }}][name]"
                                               class="form-control" value="{{ $account['name'] }}" data-account-name-input>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="account_api_version_{{ $index }}">{{ __('whatsapp_api_version') }}</label>
                                    <div class="wa-field">
                                        <i class="ph-duotone ph-code wa-field__icon" aria-hidden="true"></i>
                                        <input type="text" id="account_api_version_{{ $index }}" name="accounts[{{ $index }}][api_version]"
                                               class="form-control" value="{{ $account['api_version'] }}" dir="ltr">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="account_phone_number_id_{{ $index }}">{{ __('whatsapp_phone_number_id') }}</label>
                                    <div class="wa-field">
                                        <i class="ph-duotone ph-hash wa-field__icon" aria-hidden="true"></i>
                                        <input type="text" id="account_phone_number_id_{{ $index }}" name="accounts[{{ $index }}][phone_number_id]"
                                               class="form-control" value="{{ $account['phone_number_id'] }}" dir="ltr">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="account_business_account_id_{{ $index }}">{{ __('whatsapp_business_account_id') }}</label>
                                    <div class="wa-field">
                                        <i class="ph-duotone ph-buildings wa-field__icon" aria-hidden="true"></i>
                                        <input type="text" id="account_business_account_id_{{ $index }}" name="accounts[{{ $index }}][business_account_id]"
                                               class="form-control" value="{{ $account['business_account_id'] }}" dir="ltr">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="account_access_token_{{ $index }}">{{ __('whatsapp_access_token') }}</label>
                                    <div class="wa-field has-toggle">
                                        <i class="ph-duotone ph-key wa-field__icon" aria-hidden="true"></i>
                                        <input type="password" id="account_access_token_{{ $index }}" name="accounts[{{ $index }}][access_token]"
                                               class="form-control" value="{{ $account['access_token'] }}" dir="ltr"
                                               autocomplete="off" data-secret-input>
                                        <button type="button" class="wa-secret-toggle" data-secret-toggle
                                                aria-label="{{ __('whatsapp_show_secret') }}" title="{{ __('whatsapp_show_secret') }}">
                                            <i class="ph-duotone ph-eye" aria-hidden="true"></i>
                                        </button>
                                        <small class="form-text">{{ __('whatsapp_saved_placeholder') }}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="account_webhook_verify_token_{{ $index }}">{{ __('whatsapp_webhook_verify_token') }}</label>
                                    <div class="wa-field has-toggle">
                                        <i class="ph-duotone ph-shield-check wa-field__icon" aria-hidden="true"></i>
                                        <input type="password" id="account_webhook_verify_token_{{ $index }}" name="accounts[{{ $index }}][webhook_verify_token]"
                                               class="form-control" value="{{ $account['webhook_verify_token'] }}" dir="ltr"
                                               autocomplete="off" data-secret-input>
                                        <button type="button" class="wa-secret-toggle" data-secret-toggle
                                                aria-label="{{ __('whatsapp_show_secret') }}" title="{{ __('whatsapp_show_secret') }}">
                                            <i class="ph-duotone ph-eye" aria-hidden="true"></i>
                                        </button>
                                        <small class="form-text">{{ __('whatsapp_saved_placeholder') }}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="account_app_secret_{{ $index }}">{{ __('whatsapp_app_secret') }}</label>
                                    <div class="wa-field has-toggle">
                                        <i class="ph-duotone ph-lock-key wa-field__icon" aria-hidden="true"></i>
                                        <input type="password" id="account_app_secret_{{ $index }}" name="accounts[{{ $index }}][app_secret]"
                                               class="form-control" value="{{ $account['app_secret'] }}" dir="ltr"
                                               autocomplete="off" data-secret-input>
                                        <button type="button" class="wa-secret-toggle" data-secret-toggle
                                                aria-label="{{ __('whatsapp_show_secret') }}" title="{{ __('whatsapp_show_secret') }}">
                                            <i class="ph-duotone ph-eye" aria-hidden="true"></i>
                                        </button>
                                        <small class="form-text">{{ __('whatsapp_saved_placeholder') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="wa-empty" id="whatsapp-accounts-empty" @if($hasAccounts) hidden @endif>
                    <span class="wa-empty__icon"><i class="ph-duotone ph-whatsapp-logo" aria-hidden="true"></i></span>
                    <h3>{{ __('whatsapp_no_accounts_yet') }}</h3>
                    <p>{{ __('whatsapp_no_accounts_hint') }}</p>
                    <button type="button" class="btn btn-primary" data-add-account>
                        <i class="ph-duotone ph-plus" aria-hidden="true"></i>
                        {{ __('whatsapp_add_account') }}
                    </button>
                </div>
            </div>

            <div class="wa-savebar">
                <p class="wa-savebar__hint">
                    <i class="ph-duotone ph-info" aria-hidden="true"></i>
                    {{ __('whatsapp_saved_placeholder') }}
                </p>
                <button class="btn btn-primary" type="submit">
                    <i class="ph-duotone ph-floppy-disk" aria-hidden="true"></i>
                    {{ __('buttons.save') }}
                </button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog"></div>
    </div>
@endsection

@section('js')
    <script>
        (function () {
            const accountsList = document.getElementById('whatsapp-accounts-list');
            const labelsElement = document.getElementById('whatsapp-account-labels');
            const emptyState = document.getElementById('whatsapp-accounts-empty');

            if (!accountsList || !labelsElement) {
                return;
            }

            const labels = JSON.parse(labelsElement.dataset.labels || '{}');

            function nextIndex() {
                const items = Array.from(accountsList.querySelectorAll('[data-account-item]'));
                if (!items.length) {
                    return 0;
                }

                return Math.max(...items.map((item) => Number(item.dataset.index || 0))) + 1;
            }

            function cardMarkup(index) {
                return `
                    <div class="wa-account" data-account-item data-index="${index}">
                        <div class="wa-account__head">
                            <div class="wa-account__identity">
                                <span class="wa-account__avatar"><i class="ph-duotone ph-whatsapp-logo" aria-hidden="true"></i></span>
                                <div class="wa-account__copy">
                                    <strong class="wa-account__name" data-account-title>${labels.account} ${index + 1}</strong>
                                    <span class="wa-account__meta">${labels.account}</span>
                                </div>
                            </div>

                            <div class="wa-account__actions">
                                <div class="form-check form-switch wa-switch">
                                    <input type="hidden" name="accounts[${index}][is_active]" value="0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                           name="accounts[${index}][is_active]"
                                           id="active_account_selector_${index}" value="1" data-active-checkbox>
                                    <label class="form-check-label" for="active_account_selector_${index}">
                                        ${labels.active}
                                    </label>
                                </div>

                                <button type="button" class="btn btn-sm btn-outline-danger wa-remove" data-remove-account>
                                    <i class="ph-duotone ph-trash" aria-hidden="true"></i>
                                    ${labels.remove}
                                </button>
                            </div>
                        </div>

                        <div class="wa-account__body">
                            <input type="hidden" name="accounts[${index}][id]" value="">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="account_name_${index}">${labels.accountName}</label>
                                    <div class="wa-field">
                                        <i class="ph-duotone ph-tag wa-field__icon" aria-hidden="true"></i>
                                        <input type="text" id="account_name_${index}" name="accounts[${index}][name]" class="form-control" value="" data-account-name-input>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="account_api_version_${index}">${labels.apiVersion}</label>
                                    <div class="wa-field">
                                        <i class="ph-duotone ph-code wa-field__icon" aria-hidden="true"></i>
                                        <input type="text" id="account_api_version_${index}" name="accounts[${index}][api_version]" class="form-control" value="v20.0" dir="ltr">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="account_phone_number_id_${index}">${labels.phoneNumberId}</label>
                                    <div class="wa-field">
                                        <i class="ph-duotone ph-hash wa-field__icon" aria-hidden="true"></i>
                                        <input type="text" id="account_phone_number_id_${index}" name="accounts[${index}][phone_number_id]" class="form-control" value="" dir="ltr">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="account_business_account_id_${index}">${labels.businessAccountId}</label>
                                    <div class="wa-field">
                                        <i class="ph-duotone ph-buildings wa-field__icon" aria-hidden="true"></i>
                                        <input type="text" id="account_business_account_id_${index}" name="accounts[${index}][business_account_id]" class="form-control" value="" dir="ltr">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="account_access_token_${index}">${labels.accessToken}</label>
                                    <div class="wa-field has-toggle">
                                        <i class="ph-duotone ph-key wa-field__icon" aria-hidden="true"></i>
                                        <input type="password" id="account_access_token_${index}" name="accounts[${index}][access_token]" class="form-control" value="" dir="ltr" autocomplete="off" data-secret-input>
                                        <button type="button" class="wa-secret-toggle" data-secret-toggle aria-label="${labels.showSecret}" title="${labels.showSecret}">
                                            <i class="ph-duotone ph-eye" aria-hidden="true"></i>
                                        </button>
                                        <small class="form-text">${labels.savedPlaceholder}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="account_webhook_verify_token_${index}">${labels.webhookVerifyToken}</label>
                                    <div class="wa-field has-toggle">
                                        <i class="ph-duotone ph-shield-check wa-field__icon" aria-hidden="true"></i>
                                        <input type="password" id="account_webhook_verify_token_${index}" name="accounts[${index}][webhook_verify_token]" class="form-control" value="" dir="ltr" autocomplete="off" data-secret-input>
                                        <button type="button" class="wa-secret-toggle" data-secret-toggle aria-label="${labels.showSecret}" title="${labels.showSecret}">
                                            <i class="ph-duotone ph-eye" aria-hidden="true"></i>
                                        </button>
                                        <small class="form-text">${labels.savedPlaceholder}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="account_app_secret_${index}">${labels.appSecret}</label>
                                    <div class="wa-field has-toggle">
                                        <i class="ph-duotone ph-lock-key wa-field__icon" aria-hidden="true"></i>
                                        <input type="password" id="account_app_secret_${index}" name="accounts[${index}][app_secret]" class="form-control" value="" dir="ltr" autocomplete="off" data-secret-input>
                                        <button type="button" class="wa-secret-toggle" data-secret-toggle aria-label="${labels.showSecret}" title="${labels.showSecret}">
                                            <i class="ph-duotone ph-eye" aria-hidden="true"></i>
                                        </button>
                                        <small class="form-text">${labels.savedPlaceholder}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            function refreshAccountCards() {
                const items = Array.from(accountsList.querySelectorAll('[data-account-item]'));

                if (emptyState) {
                    emptyState.hidden = items.length > 0;
                }

                items.forEach((item, position) => {
                    const removeButton = item.querySelector('[data-remove-account]');
                    const accountTitle = item.querySelector('[data-account-title]');
                    const accountNameInput = item.querySelector('[data-account-name-input]');
                    const accountName = accountNameInput ? String(accountNameInput.value || '').trim() : '';

                    if (accountTitle) {
                        accountTitle.textContent = accountName || `${labels.account} ${position + 1}`;
                    }

                    if (removeButton) {
                        removeButton.disabled = items.length === 1;
                        removeButton.classList.toggle('d-none', items.length === 1);
                    }
                });
            }

            document.querySelectorAll('[data-add-account]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const index = nextIndex();
                    accountsList.insertAdjacentHTML('beforeend', cardMarkup(index));
                    refreshAccountCards();
                });
            });

            const csrfToken = document.querySelector('meta[name="csrf-token"]')
                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                : '';

            function deleteAccountFromServer(deleteUrl) {
                return fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                }).then(function (response) {
                    return response.json();
                }).then(function (data) {
                    if (data.code === 200 || data.code === 201) {
                        if (window.successToster) {
                            successToster('{{ __("auth.done successfully") }}');
                        }
                        return true;
                    }
                    if (window.errorToster) {
                        errorToster('{{ __("auth.an error occurred") }}');
                    }
                    return false;
                }).catch(function () {
                    if (window.errorToster) {
                        errorToster('{{ __("auth.an error occurred") }}');
                    }
                    return false;
                });
            }

            accountsList.addEventListener('click', function (event) {
                const secretToggle = event.target.closest('[data-secret-toggle]');
                if (secretToggle) {
                    const field = secretToggle.closest('.wa-field');
                    const input = field ? field.querySelector('[data-secret-input]') : null;
                    const icon = secretToggle.querySelector('i');

                    if (!input) {
                        return;
                    }

                    const willShow = input.type === 'password';
                    input.type = willShow ? 'text' : 'password';

                    if (icon) {
                        icon.className = willShow ? 'ph-duotone ph-eye-slash' : 'ph-duotone ph-eye';
                    }

                    const label = willShow ? labels.hideSecret : labels.showSecret;
                    secretToggle.setAttribute('aria-label', label);
                    secretToggle.setAttribute('title', label);
                    return;
                }

                const removeButton = event.target.closest('[data-remove-account]');
                if (!removeButton) {
                    return;
                }

                const accountCard = removeButton.closest('[data-account-item]');
                const deleteUrl = accountCard ? accountCard.dataset.deleteUrl : null;

                const confirmPromise = window.Swal
                    ? Swal.fire({
                        title: labels.deleteTitle,
                        text: labels.deleteText,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: labels.deleteConfirm,
                        cancelButtonText: labels.cancel,
                    }).then(function (result) {
                        return result.isConfirmed;
                    })
                    : Promise.resolve(window.confirm(labels.deleteText));

                confirmPromise.then(function (isConfirmed) {
                    if (!isConfirmed || !accountCard) {
                        return;
                    }

                    if (deleteUrl) {
                        deleteAccountFromServer(deleteUrl).then(function (success) {
                            if (success) {
                                accountCard.remove();
                                refreshAccountCards();
                            }
                        });
                    } else {
                        accountCard.remove();
                        refreshAccountCards();
                    }
                });
            });

            accountsList.addEventListener('input', function (event) {
                if (event.target.matches('[data-account-name-input]')) {
                    refreshAccountCards();
                }
            });

            refreshAccountCards();
        })();
    </script>
@endsection
