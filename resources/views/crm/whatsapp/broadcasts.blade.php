@extends('crm.layout')

@section('page-title', $pageTitle)

@section('content')
    <div id="whatsapp-broadcasts-root"
         data-store-url="{{ route('crm.whatsapp_broadcasts.store') }}"
         data-update-url-template="{{ route('crm.whatsapp_broadcasts.update', ['id' => '__ID__']) }}"
         data-send-url-template="{{ route('crm.whatsapp_broadcasts.send_now', ['id' => '__ID__']) }}"
         data-cancel-url-template="{{ route('crm.whatsapp_broadcasts.cancel', ['id' => '__ID__']) }}"
         data-report-url-template="{{ route('crm.whatsapp_broadcasts.report', ['id' => '__ID__']) }}"
         data-t-error="{{ __('whatsapp_request_failed') }}"
         data-t-confirm-send="{{ __('whatsapp_confirm_send_now') }}"
         data-t-confirm-cancel="{{ __('whatsapp_confirm_cancel') }}"
         data-t-report="{{ __('whatsapp_report_title') }}"
         data-t-no-results="{{ __('whatsapp_no_results') }}"
         data-t-loading="{{ __('whatsapp_loading') }}"
         data-t-failed="{{ __('whatsapp_failed') }}">

        <div class="row g-3">
            <div class="col-12 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div>
                    <h5 class="mb-1">{{ __('whatsapp_broadcasts') }}</h5>
                    <small class="text-muted">{{ __('whatsapp_audience') }}: {{ __('whatsapp_contacts') }}</small>
                </div>
                <button type="button" class="btn btn-primary" id="wa-bc-add">
                    <i class="fa fa-plus"></i> {{ __('whatsapp_new_broadcast') }}
                </button>
            </div>

            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:60px;">#</th>
                                    <th>{{ __('whatsapp_broadcast_title') }}</th>
                                    <th style="width:120px;">{{ __('whatsapp_status') }}</th>
                                    <th style="width:90px;">{{ __('whatsapp_audience') }}</th>
                                    <th style="width:90px;">{{ __('whatsapp_delivered') }}</th>
                                    <th style="width:90px;">{{ __('whatsapp_failed') }}</th>
                                    <th style="width:170px;">{{ __('whatsapp_scheduled_at') }}</th>
                                    <th style="width:260px;">{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($broadcasts as $broadcast)
                                    @php
                                        $statusKey = match ($broadcast->status) {
                                            'sent' => 'whatsapp_sent',
                                            'scheduled' => 'whatsapp_scheduled',
                                            'canceled' => 'whatsapp_canceled',
                                            'sending' => 'whatsapp_sending',
                                            default => 'whatsapp_draft',
                                        };
                                        $statusColor = match ($broadcast->status) {
                                            'sent' => 'success',
                                            'scheduled' => 'info',
                                            'canceled' => 'secondary',
                                            'sending' => 'warning',
                                            default => 'light text-dark',
                                        };
                                    @endphp
                                    <tr>
                                        <td>{{ $broadcast->id }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $broadcast->title }}</div>
                                            <small class="text-muted">
                                                {{ __('whatsapp_' . $broadcast->type) }}
                                                @if ($broadcast->whatsappBusinessSetting)
                                                    · {{ $broadcast->whatsappBusinessSetting->name }}
                                                @endif
                                            </small>
                                        </td>
                                        <td><span class="badge bg-{{ $statusColor }}">{{ __($statusKey) }}</span></td>
                                        <td>{{ $broadcast->audience_count }}</td>
                                        <td>{{ $broadcast->delivered_count }}</td>
                                        <td>{{ $broadcast->failed_count }}</td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $broadcast->scheduled_at?->format('Y-m-d H:i') ?: '—' }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2">
                                                @if (! in_array($broadcast->status, ['sent', 'canceled', 'sending'], true))
                                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                                            data-action="edit"
                                                            data-id="{{ $broadcast->id }}"
                                                            data-title="{{ $broadcast->title }}"
                                                            data-account-id="{{ $broadcast->whatsapp_business_setting_id }}"
                                                            data-type="{{ $broadcast->type }}"
                                                            data-message-body="{{ $broadcast->message_body }}"
                                                            data-template-name="{{ $broadcast->template_name }}"
                                                            data-template-language="{{ $broadcast->template_language }}"
                                                            data-button-ids="{{ implode(',', $broadcast->button_quick_reply_ids ?? []) }}"
                                                            data-scheduled-at="{{ $broadcast->scheduled_at?->format('Y-m-d\TH:i') }}">
                                                        {{ __('edit') }}
                                                    </button>
                                                @endif
                                                @if (! in_array($broadcast->status, ['sent', 'canceled', 'sending'], true))
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                            data-action="send" data-id="{{ $broadcast->id }}">
                                                        {{ __('whatsapp_send_now') }}
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                            data-action="cancel" data-id="{{ $broadcast->id }}">
                                                        {{ __('cancel') }}
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-sm btn-outline-dark"
                                                        data-action="report" data-id="{{ $broadcast->id }}">
                                                    {{ __('whatsapp_report') }}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center text-muted">{{ __('whatsapp_no_broadcasts') }}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="wa-bc-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="wa-bc-modal-title">{{ __('whatsapp_broadcast') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('close') }}"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="wa-bc-id" value="">
                        <div id="wa-bc-error" class="alert alert-danger d-none"></div>

                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="form-label" for="wa-bc-title">{{ __('whatsapp_broadcast_title') }}</label>
                                <input type="text" class="form-control" id="wa-bc-title" maxlength="255">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label" for="wa-bc-account">{{ __('whatsapp_choose_account') }}</label>
                                <select class="form-select" id="wa-bc-account">
                                    <option value="">{{ __('whatsapp_without_account') }}</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name ?: $account->phone_number_id }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="wa-bc-type">{{ __('whatsapp_type') }}</label>
                                <select class="form-select" id="wa-bc-type">
                                    <option value="immediate">{{ __('whatsapp_immediate') }}</option>
                                    <option value="scheduled">{{ __('whatsapp_scheduled') }}</option>
                                    <option value="template">{{ __('whatsapp_template') }}</option>
                                </select>
                            </div>
                            <div class="col-md-6" id="wa-bc-schedule-wrap">
                                <label class="form-label" for="wa-bc-scheduled-at">{{ __('whatsapp_scheduled_at') }}</label>
                                <input type="datetime-local" class="form-control" id="wa-bc-scheduled-at">
                            </div>

                            <div class="col-12" id="wa-bc-body-wrap">
                                <label class="form-label" for="wa-bc-body">{{ __('whatsapp_message_text') }}</label>
                                <textarea class="form-control" id="wa-bc-body" rows="5" maxlength="5000"></textarea>
                            </div>

                            <div class="col-md-7 d-none" id="wa-bc-template-name-wrap">
                                <label class="form-label" for="wa-bc-template-name">{{ __('whatsapp_template_name') }}</label>
                                <input type="text" class="form-control" id="wa-bc-template-name" maxlength="512">
                            </div>
                            <div class="col-md-5 d-none" id="wa-bc-template-language-wrap">
                                <label class="form-label" for="wa-bc-template-language">{{ __('whatsapp_template_language') }}</label>
                                <input type="text" class="form-control" id="wa-bc-template-language" maxlength="10" placeholder="{{ __('whatsapp_language_example') }}">
                            </div>

                            <div class="col-12" id="wa-bc-buttons-wrap">
                                <label class="form-label" for="wa-bc-buttons">{{ __('whatsapp_buttons') }}</label>
                                <select class="form-select" id="wa-bc-buttons" multiple size="5">
                                    @foreach ($quickReplies as $quickReply)
                                        <option value="{{ $quickReply->id }}">{{ $quickReply->title }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">{{ __('whatsapp_quick_reply_add_hint') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('cancel') }}</button>
                        <button type="button" class="btn btn-primary" id="wa-bc-save">{{ __('save') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="wa-bc-report-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('whatsapp_report_title') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('close') }}"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('whatsapp_contact') }}</th>
                                        <th>{{ __('whatsapp_status') }}</th>
                                        <th>WAMID</th>
                                        <th>{{ __('whatsapp_error') }}</th>
                                        <th>{{ __('whatsapp_sent') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="wa-bc-report-body">
                                    <tr><td colspan="6" class="text-center text-muted">{{ __('whatsapp_loading') }}</td></tr>
                                </tbody>
                            </table>
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
            const root = document.getElementById('whatsapp-broadcasts-root');
            if (!root) {
                return;
            }

            const csrf = document.querySelector('meta[name="csrf-token"]')
                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                : '';

            const urls = {
                store: root.dataset.storeUrl,
                update: root.dataset.updateUrlTemplate,
                send: root.dataset.sendUrlTemplate,
                cancel: root.dataset.cancelUrlTemplate,
                report: root.dataset.reportUrlTemplate,
            };

            const statusLabels = {
                sent: '{{ __('whatsapp_sent') }}',
                delivered: '{{ __('whatsapp_delivered') }}',
                failed: '{{ __('whatsapp_failed') }}',
                pending: '{{ __('whatsapp_pending') }}',
                canceled: '{{ __('whatsapp_canceled') }}',
            };

            const t = {
                error: root.dataset.tError,
                confirmSend: root.dataset.tConfirmSend,
                confirmCancel: root.dataset.tConfirmCancel,
                noResults: root.dataset.tNoResults,
                loading: root.dataset.tLoading,
                failed: root.dataset.tFailed,
            };

            const modal = (id) => {
                const element = document.getElementById(id);

                return element && window.bootstrap ? new bootstrap.Modal(element) : null;
            };

            const broadcastModal = modal('wa-bc-modal');
            const reportModal = modal('wa-bc-report-modal');

            const urlWithId = (template, id) => String(template || '').replace('__ID__', encodeURIComponent(String(id)));

            const errorMessage = (xhr) => {
                const data = xhr && xhr.responseJSON && xhr.responseJSON.data ? xhr.responseJSON.data : null;
                if (data) {
                    const first = Object.values(data)[0];
                    if (first && first[0]) {
                        return first[0];
                    }
                }
                return xhr && xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : t.error;
            };

            const notifyError = (xhr) => {
                const message = errorMessage(xhr);
                if (window.errorToster) {
                    errorToster(message);
                } else {
                    alert(message);
                }
            };

            const notifySuccess = (message) => {
                if (window.successToster) {
                    successToster(message);
                }
            };

            const escapeHtml = (value) => String(value == null ? '' : value)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');

            const formatDate = (value) => {
                if (!value) {
                    return '';
                }
                const date = new Date(value);

                return Number.isNaN(date.getTime()) ? String(value) : date.toLocaleString();
            };

            const typeSelect = document.getElementById('wa-bc-type');
            const scheduleWrap = document.getElementById('wa-bc-schedule-wrap');
            const bodyWrap = document.getElementById('wa-bc-body-wrap');
            const templateNameWrap = document.getElementById('wa-bc-template-name-wrap');
            const templateLanguageWrap = document.getElementById('wa-bc-template-language-wrap');
            const buttonsWrap = document.getElementById('wa-bc-buttons-wrap');

            function syncTypeFields() {
                const type = typeSelect.value;
                scheduleWrap.classList.toggle('d-none', type !== 'scheduled');
                bodyWrap.classList.toggle('d-none', type === 'template');
                templateNameWrap.classList.toggle('d-none', type !== 'template');
                templateLanguageWrap.classList.toggle('d-none', type !== 'template');
                buttonsWrap.classList.toggle('d-none', type === 'template');
            }

            function resetForm() {
                document.getElementById('wa-bc-id').value = '';
                document.getElementById('wa-bc-title').value = '';
                document.getElementById('wa-bc-account').value = '';
                typeSelect.value = 'immediate';
                document.getElementById('wa-bc-body').value = '';
                document.getElementById('wa-bc-template-name').value = '';
                document.getElementById('wa-bc-template-language').value = '';
                document.getElementById('wa-bc-scheduled-at').value = '';
                Array.from(document.getElementById('wa-bc-buttons').options).forEach((option) => {
                    option.selected = false;
                });
                document.getElementById('wa-bc-error').classList.add('d-none');
                syncTypeFields();
            }

            function openCreate() {
                resetForm();
                document.getElementById('wa-bc-modal-title').textContent = '{{ __('whatsapp_new_broadcast') }}';
                if (broadcastModal) {
                    broadcastModal.show();
                }
            }

            function openEdit(button) {
                resetForm();
                document.getElementById('wa-bc-modal-title').textContent = '{{ __('whatsapp_edit_broadcast') }}';
                document.getElementById('wa-bc-id').value = button.getAttribute('data-id');
                document.getElementById('wa-bc-title').value = button.getAttribute('data-title') || '';
                document.getElementById('wa-bc-account').value = button.getAttribute('data-account-id') || '';
                typeSelect.value = button.getAttribute('data-type') || 'immediate';
                document.getElementById('wa-bc-body').value = button.getAttribute('data-message-body') || '';
                document.getElementById('wa-bc-template-name').value = button.getAttribute('data-template-name') || '';
                document.getElementById('wa-bc-template-language').value = button.getAttribute('data-template-language') || '';
                document.getElementById('wa-bc-scheduled-at').value = button.getAttribute('data-scheduled-at') || '';

                const ids = (button.getAttribute('data-button-ids') || '')
                    .split(',')
                    .map((value) => value.trim())
                    .filter(Boolean);
                Array.from(document.getElementById('wa-bc-buttons').options).forEach((option) => {
                    option.selected = ids.includes(option.value);
                });

                syncTypeFields();
                if (broadcastModal) {
                    broadcastModal.show();
                }
            }

            function payload() {
                const selectedButtons = Array.from(document.getElementById('wa-bc-buttons').selectedOptions)
                    .map((option) => Number(option.value));

                return {
                    account_id: document.getElementById('wa-bc-account').value || null,
                    title: document.getElementById('wa-bc-title').value.trim(),
                    type: typeSelect.value,
                    message_body: document.getElementById('wa-bc-body').value,
                    template_name: document.getElementById('wa-bc-template-name').value,
                    template_language: document.getElementById('wa-bc-template-language').value,
                    scheduled_at: document.getElementById('wa-bc-scheduled-at').value || null,
                    button_quick_reply_ids: selectedButtons,
                };
            }

            function saveBroadcast() {
                const id = document.getElementById('wa-bc-id').value;
                const errorBox = document.getElementById('wa-bc-error');

                $.ajax({
                    url: id ? urlWithId(urls.update, id) : urls.store,
                    type: id ? 'PUT' : 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    data: payload(),
                    success: function (response) {
                        errorBox.classList.add('d-none');
                        if (broadcastModal) {
                            broadcastModal.hide();
                        }
                        notifySuccess(response.message);
                        window.location.reload();
                    },
                    error: function (xhr) {
                        errorBox.textContent = errorMessage(xhr);
                        errorBox.classList.remove('d-none');
                    },
                });
            }

            function confirmAction(message) {
                if (window.Swal) {
                    return Swal.fire({
                        title: message,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: '{{ __('whatsapp_confirm') }}',
                        cancelButtonText: '{{ __('cancel') }}',
                    }).then((result) => result.isConfirmed);
                }

                return Promise.resolve(window.confirm(message));
            }

            function sendNow(id) {
                confirmAction(t.confirmSend).then((confirmed) => {
                    if (!confirmed) {
                        return;
                    }

                    $.ajax({
                        url: urlWithId(urls.send, id),
                        type: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                        success: function (response) {
                            notifySuccess(response.message);
                            window.location.reload();
                        },
                        error: notifyError,
                    });
                });
            }

            function cancelBroadcast(id) {
                confirmAction(t.confirmCancel).then((confirmed) => {
                    if (!confirmed) {
                        return;
                    }

                    $.ajax({
                        url: urlWithId(urls.cancel, id),
                        type: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                        success: function (response) {
                            notifySuccess(response.message);
                            window.location.reload();
                        },
                        error: notifyError,
                    });
                });
            }

            function openReport(id) {
                const body = document.getElementById('wa-bc-report-body');
                body.innerHTML = '<tr><td colspan="6" class="text-center text-muted">' + escapeHtml(t.loading) + '</td></tr>';
                if (reportModal) {
                    reportModal.show();
                }

                $.ajax({
                    url: urlWithId(urls.report, id),
                    type: 'GET',
                    headers: { 'Accept': 'application/json' },
                    success: function (response) {
                        const data = response.data || {};
                        const items = data.items || [];

                        if (!items.length) {
                            body.innerHTML = '<tr><td colspan="6" class="text-center text-muted">' + escapeHtml(t.noResults) + '</td></tr>';
                            return;
                        }

                        body.innerHTML = items.map((item) => {
                            const status = item.status || '';
                            const contact = item.contact_name
                                ? escapeHtml(item.contact_name) + '<br><small class="text-muted">' + escapeHtml(item.wa_id) + '</small>'
                                : escapeHtml(item.wa_id);

                            return '<tr>'
                                + '<td>' + escapeHtml(item.id) + '</td>'
                                + '<td>' + contact + '</td>'
                                + '<td><span class="badge bg-light text-dark">' + escapeHtml(statusLabels[status] || status) + '</span></td>'
                                + '<td><small class="text-muted">' + escapeHtml(item.wamid || '—') + '</small></td>'
                                + '<td><small class="text-danger">' + escapeHtml(item.error || '—') + '</small></td>'
                                + '<td><small class="text-muted">' + escapeHtml(formatDate(item.sent_at)) + '</small></td>'
                                + '</tr>';
                        }).join('');
                    },
                    error: notifyError,
                });
            }

            document.getElementById('wa-bc-add').addEventListener('click', openCreate);
            document.getElementById('wa-bc-save').addEventListener('click', saveBroadcast);
            typeSelect.addEventListener('change', syncTypeFields);

            root.addEventListener('click', function (event) {
                const button = event.target.closest('[data-action]');
                if (!button) {
                    return;
                }

                const action = button.getAttribute('data-action');
                const id = button.getAttribute('data-id');

                if (!id) {
                    return;
                }

                if (action === 'edit') {
                    openEdit(button);
                } else if (action === 'send') {
                    sendNow(id);
                } else if (action === 'cancel') {
                    cancelBroadcast(id);
                } else if (action === 'report') {
                    openReport(id);
                }
            });

            syncTypeFields();
        })();
    </script>
@endsection
