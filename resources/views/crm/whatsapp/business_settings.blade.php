@extends('crm.layout')

@section('page-title', $pageTitle)

@section('content')

    <div class="col-12 mt-4">
        <div class="card border-0 overflow-hidden" style="background: linear-gradient(135deg, #1a56db 0%, #2D71F0 50%, #0ea5e9 100%); box-shadow: 0 8px 32px rgba(45,113,240,0.25);">
            <div class="card-body p-0">
                <div class="row g-0 align-items-center">
                    <div class="col-md-3 d-flex align-items-center justify-content-center p-4">
                        <img src="{{ asset('admin/assets/img/think.png') }}" alt="support"
                             style="max-height: 150px; max-width: 150px; object-fit: contain; filter: drop-shadow(0 4px 16px rgba(0,0,0,0.2));">
                    </div>
                    <div class="col-md-9 p-4 p-md-5">
                        <h5 class="fw-bold mb-2 text-white">تواجه صعوبة في الربط؟</h5>
                        <p class="mb-4" style="color:rgba(255,255,255,0.85); font-size:15px;">تواصل مع فريق الدعم وسنساعدك في ربط حسابك بخطوات بسيطة وسريعة.</p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="https://wa.me/201099977904" target="_blank" rel="noopener"
                               class="btn fw-bold d-flex align-items-center gap-2"
                               style="background:#25D366;color:#fff;border-radius:10px;font-size:15px;padding:10px 20px;box-shadow:0 4px 14px rgba(0,0,0,0.2);">
                                <i class="fab fa-whatsapp" style="font-size:20px;"></i>
                                +201099977904
                            </a>
                            <a href="{{ route('crm.whatsapp_setup') }}"
                               class="btn fw-bold d-flex align-items-center gap-2"
                               style="background:rgba(255,255,255,0.15);color:#fff;border:1.5px solid rgba(255,255,255,0.4);border-radius:10px;font-size:15px;padding:10px 20px;backdrop-filter:blur(4px);">
                                <i class="ti ti-plug" style="font-size:18px;"></i>
                                كيفية الربط
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            : collect([[
                'id' => null,
                'name' => '',
                'is_active' => true,
                'api_version' => 'v20.0',
                'phone_number_id' => '',
                'business_account_id' => '',
                'access_token' => '',
                'webhook_verify_token' => '',
                'app_secret' => '',
            ]]);

        $accountLabels = json_encode([
            'account' => __('whatsapp_account'),
            'accountName' => __('whatsapp_account_name'),
            'namePlaceholder' => __('whatsapp_placeholder_name'),
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
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    @endphp

    <form class="row g-3 from-submit-global" method="post" action="{{ route('crm.whatsapp_business_settings.store') }}">
        @csrf
        <div id="whatsapp-account-labels" class="d-none" data-labels='{{ $accountLabels }}'></div>

        <div class="col-12 d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <h5 class="mb-1">{{ __('whatsapp_business_settings') }}</h5>
                <small class="text-muted">{{ __('whatsapp_settings_edit_hint') }}</small>
            </div>
            <button type="button" class="btn btn-outline-primary" id="add-whatsapp-account">
                <i class="fa fa-plus"></i>
                {{ __('whatsapp_add_account') }}
            </button>
        </div>

        <div class="col-12" id="whatsapp-accounts-list">
            @foreach($accounts as $index => $account)
                <div class="card mb-3" style="border: 1px solid rgba(0,0,0,0.08); border-radius: 12px; overflow: hidden;" data-account-item data-index="{{ $index }}"
                     @if($account['id']) data-delete-url="{{ route('crm.whatsapp_business_settings.destroy', $account['id']) }}" @endif>
                    <div class="card-header bg-light d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fab fa-whatsapp text-success"></i>
                            <strong data-account-title>{{ $account['name'] ?: __('whatsapp_account') . ' ' . ($index + 1) }}</strong>
                            <div class="form-check mb-0">
                                <input type="hidden" name="accounts[{{ $index }}][is_active]" value="0">
                                <input class="form-check-input" type="checkbox" name="accounts[{{ $index }}][is_active]"
                                       id="active_account_selector_{{ $index }}" value="1" data-active-checkbox
                                       {{ !empty($account['is_active']) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active_account_selector_{{ $index }}">
                                    {{ __('is_active') }}
                                </label>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-danger" data-remove-account>
                            <i class="fa fa-trash"></i>
                            {{ __('remove') }}
                        </button>
                    </div>

                    <div class="card-body">
                        <input type="hidden" name="accounts[{{ $index }}][id]" value="{{ $account['id'] }}">

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('whatsapp_account_name') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fa fa-tag text-muted"></i></span>
                                    <input type="text" name="accounts[{{ $index }}][name]" class="form-control border-start-0"
                                           value="{{ $account['name'] }}" data-account-name-input
                                           placeholder="{{ __('whatsapp_placeholder_name') }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">{{ __('whatsapp_api_version') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fa fa-code text-muted"></i></span>
                                    <input type="text" name="accounts[{{ $index }}][api_version]" class="form-control border-start-0"
                                           value="{{ $account['api_version'] }}" placeholder="v20.0">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">{{ __('whatsapp_phone_number_id') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fa fa-hashtag text-muted"></i></span>
                                    <input type="text" name="accounts[{{ $index }}][phone_number_id]" class="form-control border-start-0"
                                           value="{{ $account['phone_number_id'] }}" placeholder="123456789012345">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">{{ __('whatsapp_business_account_id') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fa fa-building text-muted"></i></span>
                                    <input type="text" name="accounts[{{ $index }}][business_account_id]" class="form-control border-start-0"
                                           value="{{ $account['business_account_id'] }}" placeholder="987654321098765">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('whatsapp_access_token') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fa fa-key text-muted"></i></span>
                                    <input type="text" name="accounts[{{ $index }}][access_token]" class="form-control border-start-0"
                                           value="{{ $account['access_token'] }}" placeholder="EAABsbCS1234abcdXYZabcdef1234567890ABCDEFabcd">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('whatsapp_webhook_verify_token') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fa fa-key text-muted"></i></span>
                                    <input type="text" name="accounts[{{ $index }}][webhook_verify_token]" class="form-control border-start-0"
                                           value="{{ $account['webhook_verify_token'] }}" placeholder="my_secure_verify_token_2024">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('whatsapp_app_secret') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fa fa-lock text-muted"></i></span>
                                    <input type="text" name="accounts[{{ $index }}][app_secret]" class="form-control border-start-0"
                                           value="{{ $account['app_secret'] }}" placeholder="a1b2c3d4e5f6a1b2c3d4e5f6a1b2c3d4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-12 modal-footer">
            <button class="btn btn-primary" type="submit">{{ __('buttons.save') }}</button>
        </div>
    </form>

    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog"></div>
    </div>
    @include('crm.partials.help-modal', [
        'title' => __('crm_help_business_settings_title'),
        'description' => __('crm_help_business_settings_desc'),
    ])
@endsection

@section('js')
    <script>
        (function () {
            const accountsList = document.getElementById('whatsapp-accounts-list');
            const addAccountButton = document.getElementById('add-whatsapp-account');
            const labelsElement = document.getElementById('whatsapp-account-labels');

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
                    <div class="card mb-3" style="border: 1px solid rgba(0,0,0,0.08); border-radius: 12px; overflow: hidden;" data-account-item data-index="${index}">
                        <div class="card-header bg-light d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <i class="fab fa-whatsapp text-success"></i>
                                <strong data-account-title>${labels.account} ${index + 1}</strong>
                                <div class="form-check mb-0">
                                    <input type="hidden" name="accounts[${index}][is_active]" value="0">
                                    <input class="form-check-input" type="checkbox" name="accounts[${index}][is_active]"
                                           id="active_account_selector_${index}" value="1" data-active-checkbox>
                                    <label class="form-check-label" for="active_account_selector_${index}">
                                        ${labels.active}
                                    </label>
                                </div>
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-danger" data-remove-account>
                                <i class="fa fa-trash"></i>
                                ${labels.remove}
                            </button>
                        </div>

                        <div class="card-body">
                            <input type="hidden" name="accounts[${index}][id]" value="">

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">${labels.accountName}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fa fa-tag text-muted"></i></span>
                                        <input type="text" name="accounts[${index}][name]" class="form-control border-start-0" value="" data-account-name-input
                                       placeholder="${labels.namePlaceholder}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">${labels.apiVersion}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fa fa-code text-muted"></i></span>
                                        <input type="text" name="accounts[${index}][api_version]" class="form-control border-start-0" value="v20.0" placeholder="v20.0">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">${labels.phoneNumberId}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fa fa-hashtag text-muted"></i></span>
                                        <input type="text" name="accounts[${index}][phone_number_id]" class="form-control border-start-0" value="" placeholder="123456789012345">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">${labels.businessAccountId}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fa fa-building text-muted"></i></span>
                                        <input type="text" name="accounts[${index}][business_account_id]" class="form-control border-start-0" value="" placeholder="987654321098765">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">${labels.accessToken}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fa fa-key text-muted"></i></span>
                                        <input type="text" name="accounts[${index}][access_token]" class="form-control border-start-0" value="" placeholder="EAABsbCS1234abcdXYZabcdef1234567890ABCDEFabcd">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">${labels.webhookVerifyToken}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fa fa-key text-muted"></i></span>
                                        <input type="text" name="accounts[${index}][webhook_verify_token]" class="form-control border-start-0" value="" placeholder="my_secure_verify_token_2024">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">${labels.appSecret}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fa fa-lock text-muted"></i></span>
                                        <input type="text" name="accounts[${index}][app_secret]" class="form-control border-start-0" value="" placeholder="a1b2c3d4e5f6a1b2c3d4e5f6a1b2c3d4">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            function refreshAccountCards() {
                const items = Array.from(accountsList.querySelectorAll('[data-account-item]'));

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

            if (addAccountButton) addAccountButton.addEventListener('click', function () {
                const index = nextIndex();
                accountsList.insertAdjacentHTML('beforeend', cardMarkup(index));
                refreshAccountCards();
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
