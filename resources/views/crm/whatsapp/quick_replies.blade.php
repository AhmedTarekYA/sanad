@extends('crm.layout')

@section('page-title', $pageTitle)

@section('content')
    <div id="whatsapp-quick-replies-root"
         data-store-url="{{ route('crm.whatsapp_quick_replies.store') }}"
         data-update-url-template="{{ route('crm.whatsapp_quick_replies.update', ['id' => '__ID__']) }}"
         data-delete-url-template="{{ route('crm.whatsapp_quick_replies.destroy', ['id' => '__ID__']) }}"
         data-t-new="{{ __('whatsapp_new_quick_reply') }}"
         data-t-edit="{{ __('whatsapp_edit_quick_reply') }}"
         data-t-confirm-delete="{{ __('whatsapp_confirm_delete') }}"
         data-t-error="{{ __('auth.an error occurred') }}">

        <div class="row g-3">
            <div class="col-12 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div>
                    <h5 class="mb-1">{{ __('whatsapp_quick_replies') }}</h5>
                    <small class="text-muted">{{ __('whatsapp_quick_replies_hint') }}</small>
                </div>
                <button type="button" class="btn btn-primary" id="wa-qr-add">
                    <i class="fa fa-plus"></i> {{ __('whatsapp_add_quick_reply') }}
                </button>
            </div>

            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:60px;">#</th>
                                    <th>{{ __('whatsapp_quick_reply_title') }}</th>
                                    <th style="width:160px;">{{ __('whatsapp_quick_reply_shortcut') }}</th>
                                    <th style="width:110px;">{{ __('whatsapp_quick_reply_status') }}</th>
                                    <th style="width:190px;">{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $item->title }}</div>
                                            <small class="text-muted">{{ \Illuminate\Support\Str::limit($item->body, 90) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $item->shortcut ?: '—' }}</span>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                       data-active-toggle
                                                       data-id="{{ $item->id }}"
                                                       data-title="{{ $item->title }}"
                                                       data-shortcut="{{ (string) $item->shortcut }}"
                                                       data-body="{{ $item->body }}"
                                                       {{ $item->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label small">{{ $item->is_active ? __('active') : __('whatsapp_disabled') }}</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                        data-action="edit"
                                                        data-id="{{ $item->id }}"
                                                        data-title="{{ $item->title }}"
                                                        data-shortcut="{{ (string) $item->shortcut }}"
                                                        data-body="{{ $item->body }}"
                                                        data-active="{{ $item->is_active ? '1' : '0' }}">
                                                    {{ __('edit') }}
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-action="delete"
                                                        data-id="{{ $item->id }}">
                                                    {{ __('delete') }}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted">{{ __('whatsapp_no_quick_replies') }}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="wa-qr-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="wa-qr-modal-title">{{ __('whatsapp_quick_reply') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('close') }}"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="wa-qr-id" value="">

                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="form-label" for="wa-qr-title">{{ __('whatsapp_quick_reply_title') }}</label>
                                <input type="text" class="form-control" id="wa-qr-title" maxlength="160">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label" for="wa-qr-shortcut">{{ __('whatsapp_quick_reply_shortcut') }}</label>
                                <input type="text" class="form-control" id="wa-qr-shortcut" maxlength="60">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="wa-qr-body">{{ __('whatsapp_quick_reply_body') }}</label>
                                <textarea class="form-control" id="wa-qr-body" rows="5" maxlength="10000"></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="wa-qr-active" checked>
                                    <label class="form-check-label" for="wa-qr-active">{{ __('is_active') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cancel') }}</button>
                        <button type="button" class="btn btn-primary" id="wa-qr-save">{{ __('save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        (function () {
            const root = document.getElementById('whatsapp-quick-replies-root');
            if (!root) {
                return;
            }

            const storeUrl = root.dataset.storeUrl || '';
            const updateTpl = root.dataset.updateUrlTemplate || '';
            const deleteTpl = root.dataset.deleteUrlTemplate || '';
            const tNew = root.dataset.tNew || '';
            const tEdit = root.dataset.tEdit || '';
            const tConfirmDelete = root.dataset.tConfirmDelete || '';
            const tError = root.dataset.tError || '';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')
                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                : '';

            const modalElement = document.getElementById('wa-qr-modal');
            const modal = window.bootstrap && modalElement ? new bootstrap.Modal(modalElement) : null;

            function urlWithId(template, id) {
                return String(template || '').replace('__ID__', encodeURIComponent(String(id)));
            }

            function payload(fields) {
                return {
                    title: String(fields.title || '').trim(),
                    shortcut: String(fields.shortcut || '').trim(),
                    body: String(fields.body || '').trim(),
                    is_active: fields.is_active ? 1 : 0,
                };
            }

            function handleError(xhr) {
                const errors = xhr && xhr.responseJSON && xhr.responseJSON.data ? xhr.responseJSON.data : null;
                const firstError = errors ? Object.values(errors)[0] : null;
                const message = firstError && firstError[0] ? firstError[0] : tError;

                if (window.errorToster) {
                    errorToster(message);
                } else {
                    alert(message);
                }
            }

            function openCreate() {
                document.getElementById('wa-qr-modal-title').textContent = tNew;
                document.getElementById('wa-qr-id').value = '';
                document.getElementById('wa-qr-title').value = '';
                document.getElementById('wa-qr-shortcut').value = '';
                document.getElementById('wa-qr-body').value = '';
                document.getElementById('wa-qr-active').checked = true;
                if (modal) {
                    modal.show();
                }
            }

            function openEdit(button) {
                document.getElementById('wa-qr-modal-title').textContent = tEdit;
                document.getElementById('wa-qr-id').value = button.getAttribute('data-id') || '';
                document.getElementById('wa-qr-title').value = button.getAttribute('data-title') || '';
                document.getElementById('wa-qr-shortcut').value = button.getAttribute('data-shortcut') || '';
                document.getElementById('wa-qr-body').value = button.getAttribute('data-body') || '';
                document.getElementById('wa-qr-active').checked = button.getAttribute('data-active') === '1';
                if (modal) {
                    modal.show();
                }
            }

            function saveItem() {
                const id = String(document.getElementById('wa-qr-id').value || '').trim();
                const isUpdate = id !== '';

                $.ajax({
                    url: isUpdate ? urlWithId(updateTpl, id) : storeUrl,
                    type: isUpdate ? 'PUT' : 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    data: payload({
                        title: document.getElementById('wa-qr-title').value,
                        shortcut: document.getElementById('wa-qr-shortcut').value,
                        body: document.getElementById('wa-qr-body').value,
                        is_active: document.getElementById('wa-qr-active').checked,
                    }),
                    success: function () {
                        window.location.reload();
                    },
                    error: handleError,
                });
            }

            function toggleActive(checkbox) {
                $.ajax({
                    url: urlWithId(updateTpl, checkbox.getAttribute('data-id')),
                    type: 'PUT',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    data: payload({
                        title: checkbox.getAttribute('data-title'),
                        shortcut: checkbox.getAttribute('data-shortcut'),
                        body: checkbox.getAttribute('data-body'),
                        is_active: checkbox.checked,
                    }),
                    error: function (xhr) {
                        checkbox.checked = !checkbox.checked;
                        handleError(xhr);
                    },
                });
            }

            function deleteItem(id) {
                const confirmPromise = window.Swal
                    ? Swal.fire({
                        title: tConfirmDelete,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: '{{ __('delete') }}',
                        cancelButtonText: '{{ __('cancel') }}',
                    }).then(function (result) {
                        return result.isConfirmed;
                    })
                    : Promise.resolve(window.confirm(tConfirmDelete));

                confirmPromise.then(function (isConfirmed) {
                    if (!isConfirmed) {
                        return;
                    }

                    $.ajax({
                        url: urlWithId(deleteTpl, id),
                        type: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                        success: function () {
                            window.location.reload();
                        },
                        error: handleError,
                    });
                });
            }

            document.getElementById('wa-qr-add').addEventListener('click', openCreate);
            document.getElementById('wa-qr-save').addEventListener('click', saveItem);

            root.addEventListener('change', function (event) {
                if (event.target.matches('[data-active-toggle]')) {
                    toggleActive(event.target);
                }
            });

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
                } else if (action === 'delete') {
                    deleteItem(id);
                }
            });
        })();
    </script>
@endsection
