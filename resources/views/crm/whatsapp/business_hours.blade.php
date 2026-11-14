@extends('crm.layout')

@section('page-title', $pageTitle)

@section('style')
    <style>
        .wb-day-row {
            display: grid;
            grid-template-columns: 120px 1fr 1fr;
            gap: 10px;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        .wb-day-row:last-child {
            border-bottom: 0;
        }

        .wb-day-name {
            font-weight: 700;
        }

        .wb-day-times[hidden] {
            display: none !important;
        }

        @media (max-width: 575.98px) {
            .wb-day-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div id="whatsapp-business-hours-root"
         data-update-url="{{ route('crm.whatsapp_business_hours.update') }}"
         data-t-saved="{{ __('whatsapp_save_done') }}"
         data-t-error="{{ __('auth.an error occurred') }}"
         data-t-validation-error="{{ __('whatsapp_validation_error') }}"
         data-t-saving="{{ __('whatsapp_saving') }}">

        <div class="row g-3">
            <div class="col-12 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div>
                    <h5 class="mb-1">{{ __('whatsapp_business_hours') }}</h5>
                    <small class="text-muted">{{ __('whatsapp_business_hours_hint') }}</small>
                </div>
                <button type="button" class="btn btn-primary" id="wb-save">
                    <i class="fa fa-save"></i> {{ __('save') }}
                </button>
            </div>

            <div class="col-12">
                <div class="alert d-none" id="wb-feedback" role="alert" aria-live="polite"></div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-light">
                        <strong>{{ __('whatsapp_business_hours_title') }}</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="wb-enabled"
                                   {{ $settings->business_hours_enabled ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="wb-enabled">{{ __('whatsapp_enable_business_hours') }}</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold" for="wb-timezone">{{ __('whatsapp_timezone') }}</label>
                            <input type="text" class="form-control" id="wb-timezone" maxlength="60"
                                   value="{{ $settings->timezone ?: config('app.timezone') }}">
                            <div class="form-text">{{ __('whatsapp_timezone_example') }}</div>
                        </div>

                        <div class="fw-bold mb-2">{{ __('whatsapp_working_days') }}</div>

                        @foreach (['sat' => 'saturday', 'sun' => 'sunday', 'mon' => 'monday', 'tue' => 'tuesday', 'wed' => 'wednesday', 'thu' => 'thursday', 'fri' => 'friday'] as $day => $dayKey)
                            @php $row = $settings->hours[$day] ?? ['enabled' => false, 'from' => '09:00', 'to' => '17:00']; @endphp
                            <div class="wb-day-row" data-day="{{ $day }}">
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                           data-day-enabled {{ ! empty($row['enabled']) ? 'checked' : '' }}>
                                    <label class="form-check-label wb-day-name">{{ __('whatsapp_day_' . $dayKey) }}</label>
                                </div>
                                <div class="wb-day-times d-flex align-items-center gap-2" {{ empty($row['enabled']) ? 'hidden' : '' }}>
                                    <label class="small text-muted mb-0">{{ __('whatsapp_from') }}</label>
                                    <input type="time" class="form-control form-control-sm" data-day-from
                                           value="{{ $row['from'] ?: '09:00' }}">
                                </div>
                                <div class="wb-day-times d-flex align-items-center gap-2" {{ empty($row['enabled']) ? 'hidden' : '' }}>
                                    <label class="small text-muted mb-0">{{ __('whatsapp_to') }}</label>
                                    <input type="time" class="form-control form-control-sm" data-day-to
                                           value="{{ $row['to'] ?: '17:00' }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-5">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-light">
                        <strong>{{ __('whatsapp_away_message') }}</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="wb-away-enabled"
                                   {{ $settings->away_message_enabled ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="wb-away-enabled">{{ __('whatsapp_enable_away_message') }}</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold" for="wb-away-message">{{ __('whatsapp_message') }}</label>
                            <textarea class="form-control" id="wb-away-message" rows="6" maxlength="5000">{{ $settings->away_message }}</textarea>
                            <div class="form-text">{{ __('whatsapp_away_message_webhook_hint') }}</div>
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
            const root = document.getElementById('whatsapp-business-hours-root');
            if (!root) {
                return;
            }

            const updateUrl = root.dataset.updateUrl || '';
            const tSaved = root.dataset.tSaved || '';
            const tError = root.dataset.tError || '';
            const tValidationError = root.dataset.tValidationError || tError;
            const tSaving = root.dataset.tSaving || '...';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')
                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                : '';
            const feedback = document.getElementById('wb-feedback');
            const saveButton = document.getElementById('wb-save');
            const defaultButtonHtml = saveButton ? saveButton.innerHTML : '';

            function escapeHtml(value) {
                return String(value || '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function setFeedback(type, messages) {
                if (!feedback) {
                    return;
                }

                const items = (Array.isArray(messages) ? messages : [messages]).filter(Boolean);
                feedback.className = 'alert ' + (type === 'success' ? 'alert-success' : 'alert-danger');
                feedback.innerHTML = items.map(function (item) {
                    return '<div>' + escapeHtml(item) + '</div>';
                }).join('');
            }

            function clearFeedback() {
                if (!feedback) {
                    return;
                }
                feedback.className = 'alert d-none';
                feedback.innerHTML = '';
            }

            function setSaving(isSaving) {
                if (!saveButton) {
                    return;
                }
                saveButton.disabled = isSaving;
                saveButton.innerHTML = isSaving ? escapeHtml(tSaving) : defaultButtonHtml;
            }

            function collectHours() {
                const hours = {};

                root.querySelectorAll('[data-day]').forEach(function (row) {
                    const day = row.getAttribute('data-day');
                    const enabled = row.querySelector('[data-day-enabled]');
                    const from = row.querySelector('[data-day-from]');
                    const to = row.querySelector('[data-day-to]');

                    hours[day] = {
                        enabled: enabled ? (enabled.checked ? 1 : 0) : 0,
                        from: from ? from.value : '09:00',
                        to: to ? to.value : '17:00',
                    };
                });

                return hours;
            }

            function save() {
                clearFeedback();
                setSaving(true);

                $.ajax({
                    url: updateUrl,
                    type: 'PUT',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    data: {
                        timezone: document.getElementById('wb-timezone').value,
                        business_hours_enabled: document.getElementById('wb-enabled').checked ? 1 : 0,
                        away_message_enabled: document.getElementById('wb-away-enabled').checked ? 1 : 0,
                        away_message: document.getElementById('wb-away-message').value,
                        hours: JSON.stringify(collectHours()),
                    },
                    success: function () {
                        setFeedback('success', tSaved);
                    },
                    error: function (xhr) {
                        const response = xhr && xhr.responseJSON ? xhr.responseJSON : {};
                        const errors = response.data && typeof response.data === 'object' ? response.data : null;
                        const messages = [];

                        if (errors) {
                            Object.keys(errors).forEach(function (key) {
                                const value = errors[key];
                                if (Array.isArray(value)) {
                                    value.forEach(function (item) {
                                        if (item) {
                                            messages.push(item);
                                        }
                                    });
                                } else if (value) {
                                    messages.push(String(value));
                                }
                            });
                        }

                        setFeedback('error', messages.length ? messages : (response.message || tError || tValidationError));
                    },
                    complete: function () {
                        setSaving(false);
                    },
                });
            }

            root.querySelectorAll('[data-day]').forEach(function (row) {
                const enabled = row.querySelector('[data-day-enabled]');

                if (!enabled) {
                    return;
                }

                enabled.addEventListener('change', function () {
                    row.querySelectorAll('.wb-day-times').forEach(function (cell) {
                        cell.hidden = !enabled.checked;
                    });
                });
            });

            if (saveButton) {
                saveButton.addEventListener('click', save);
            }
        })();
    </script>
@endsection
