@extends('crm.layout')

@section('page-title', $pageTitle)

@section('style')
    <style>
        .wa-tag-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 4px 10px;
            border-radius: 999px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background: rgba(0, 0, 0, 0.03);
            font-weight: 700;
            font-size: 12px;
        }

        .wa-tag-dot {
            width: 14px;
            height: 14px;
            border-radius: 5px;
            border: 1px solid rgba(0, 0, 0, 0.12);
            background: #e9ecef;
        }
    </style>
@endsection

@section('content')
    <div id="whatsapp-labels-root"
         data-store-url="{{ route('crm.whatsapp_labels.store') }}"
         data-update-url-template="{{ route('crm.whatsapp_labels.update', ['id' => '__ID__']) }}"
         data-delete-url-template="{{ route('crm.whatsapp_labels.destroy', ['id' => '__ID__']) }}"
         data-t-new-contact-tag="{{ __('whatsapp_new_contact_tag') }}"
         data-t-new-chat-tag="{{ __('whatsapp_new_chat_tag') }}"
         data-t-edit-tag="{{ __('whatsapp_edit_tag') }}"
         data-t-confirm-delete="{{ __('whatsapp_confirm_delete') }}"
         data-t-error="{{ __('auth.an error occurred') }}">

        <div class="row g-3">
            <div class="col-12 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div>
                    <h5 class="mb-1">{{ __('whatsapp_labels') }}</h5>
                    <small class="text-muted">{{ __('whatsapp_labels_hint') }}</small>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-primary" id="wa-add-contact-tag">
                        <i class="fa fa-plus"></i> {{ __('whatsapp_add_contact_tag') }}
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="wa-add-chat-tag">
                        <i class="fa fa-plus"></i> {{ __('whatsapp_add_chat_tag') }}
                    </button>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-light">
                        <strong>{{ __('whatsapp_contact_tags') }}</strong>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:60px;">#</th>
                                    <th>{{ __('whatsapp_tag') }}</th>
                                    <th style="width:130px;">{{ __('whatsapp_contacts_count') }}</th>
                                    <th style="width:170px;">{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contactTags as $tag)
                                    <tr>
                                        <td>{{ $tag->id }}</td>
                                        <td>
                                            <span class="wa-tag-chip">
                                                <span class="wa-tag-dot" data-color="{{ $tag->color ?: '#e9ecef' }}"></span>
                                                {{ $tag->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary">{{ (int) ($tag->contacts_count ?? 0) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                        data-scope="contact" data-action="edit"
                                                        data-id="{{ $tag->id }}"
                                                        data-name="{{ $tag->name }}"
                                                        data-color="{{ (string) $tag->color }}">
                                                    {{ __('edit') }}
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-scope="contact" data-action="delete"
                                                        data-id="{{ $tag->id }}">
                                                    {{ __('delete') }}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">{{ __('whatsapp_no_tags') }}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-light">
                        <strong>{{ __('whatsapp_chat_tags') }}</strong>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:60px;">#</th>
                                    <th>{{ __('whatsapp_tag') }}</th>
                                    <th style="width:150px;">{{ __('whatsapp_conversations_count') }}</th>
                                    <th style="width:170px;">{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($chatTags as $tag)
                                    <tr>
                                        <td>{{ $tag->id }}</td>
                                        <td>
                                            <span class="wa-tag-chip">
                                                <span class="wa-tag-dot" data-color="{{ $tag->color ?: '#e9ecef' }}"></span>
                                                {{ $tag->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary">{{ (int) ($tag->conversations_count ?? 0) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                        data-scope="chat" data-action="edit"
                                                        data-id="{{ $tag->id }}"
                                                        data-name="{{ $tag->name }}"
                                                        data-color="{{ (string) $tag->color }}">
                                                    {{ __('edit') }}
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-scope="chat" data-action="delete"
                                                        data-id="{{ $tag->id }}">
                                                    {{ __('delete') }}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">{{ __('whatsapp_no_tags') }}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="wa-tag-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="wa-tag-modal-title">{{ __('whatsapp_tag') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('close') }}"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="wa-tag-id" value="">
                        <input type="hidden" id="wa-tag-scope" value="">

                        <div class="mb-3">
                            <label class="form-label" for="wa-tag-name">{{ __('whatsapp_tag_name') }}</label>
                            <input type="text" class="form-control" id="wa-tag-name" maxlength="255">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="wa-tag-color">{{ __('whatsapp_tag_color') }}</label>
                            <div class="d-flex gap-2 align-items-center">
                                <input type="color" class="form-control form-control-color" id="wa-tag-color-picker" value="#6c757d">
                                <input type="text" class="form-control" id="wa-tag-color" placeholder="#6c757d" maxlength="30">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cancel') }}</button>
                        <button type="button" class="btn btn-primary" id="wa-tag-save">{{ __('save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        (function () {
            const root = document.getElementById('whatsapp-labels-root');
            if (!root) {
                return;
            }

            const storeUrl = root.dataset.storeUrl || '';
            const updateTpl = root.dataset.updateUrlTemplate || '';
            const deleteTpl = root.dataset.deleteUrlTemplate || '';
            const tNewContactTag = root.dataset.tNewContactTag || '';
            const tNewChatTag = root.dataset.tNewChatTag || '';
            const tEditTag = root.dataset.tEditTag || '';
            const tConfirmDelete = root.dataset.tConfirmDelete || '';
            const tError = root.dataset.tError || '';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')
                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                : '';

            const modalElement = document.getElementById('wa-tag-modal');
            const modal = window.bootstrap && modalElement ? new bootstrap.Modal(modalElement) : null;

            const colorValue = (color) => String(color || '').trim() || '#e9ecef';

            root.querySelectorAll('.wa-tag-dot[data-color]').forEach(function (el) {
                el.style.background = colorValue(el.getAttribute('data-color'));
            });

            function urlWithId(template, id) {
                return String(template || '').replace('__ID__', encodeURIComponent(String(id)));
            }

            function syncPickerFromText() {
                const picker = document.getElementById('wa-tag-color-picker');
                const text = document.getElementById('wa-tag-color');
                const value = String(text.value || '').trim();
                if (picker && /^#[0-9a-fA-F]{6}$/.test(value)) {
                    picker.value = value.toLowerCase();
                }
            }

            function openCreate(scope) {
                document.getElementById('wa-tag-modal-title').textContent = scope === 'chat' ? tNewChatTag : tNewContactTag;
                document.getElementById('wa-tag-id').value = '';
                document.getElementById('wa-tag-scope').value = scope;
                document.getElementById('wa-tag-name').value = '';
                document.getElementById('wa-tag-color').value = '';
                document.getElementById('wa-tag-color-picker').value = '#6c757d';
                if (modal) {
                    modal.show();
                }
            }

            function openEdit(button) {
                document.getElementById('wa-tag-modal-title').textContent = tEditTag;
                document.getElementById('wa-tag-id').value = button.getAttribute('data-id') || '';
                document.getElementById('wa-tag-scope').value = button.getAttribute('data-scope') || '';
                document.getElementById('wa-tag-name').value = button.getAttribute('data-name') || '';
                document.getElementById('wa-tag-color').value = button.getAttribute('data-color') || '';
                syncPickerFromText();
                if (modal) {
                    modal.show();
                }
            }

            function saveTag() {
                const id = String(document.getElementById('wa-tag-id').value || '').trim();
                const scope = String(document.getElementById('wa-tag-scope').value || '').trim();
                const name = String(document.getElementById('wa-tag-name').value || '').trim();
                const color = String(document.getElementById('wa-tag-color').value || '').trim();
                const isUpdate = id !== '';

                $.ajax({
                    url: isUpdate ? urlWithId(updateTpl, id) : storeUrl,
                    type: isUpdate ? 'PUT' : 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    data: { scope: scope, name: name, color: color },
                    success: function () {
                        window.location.reload();
                    },
                    error: function (xhr) {
                        const errors = xhr && xhr.responseJSON && xhr.responseJSON.data ? xhr.responseJSON.data : null;
                        const firstError = errors ? Object.values(errors)[0] : null;
                        const message = firstError && firstError[0] ? firstError[0] : tError;
                        if (window.errorToster) {
                            errorToster(message);
                        } else {
                            alert(message);
                        }
                    },
                });
            }

            function deleteTag(scope, id) {
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
                        data: { scope: scope },
                        success: function () {
                            window.location.reload();
                        },
                        error: function () {
                            if (window.errorToster) {
                                errorToster(tError);
                            } else {
                                alert(tError);
                            }
                        },
                    });
                });
            }

            document.getElementById('wa-add-contact-tag').addEventListener('click', function () {
                openCreate('contact');
            });

            document.getElementById('wa-add-chat-tag').addEventListener('click', function () {
                openCreate('chat');
            });

            document.getElementById('wa-tag-save').addEventListener('click', saveTag);

            document.getElementById('wa-tag-color-picker').addEventListener('input', function () {
                document.getElementById('wa-tag-color').value = this.value;
            });

            document.getElementById('wa-tag-color').addEventListener('input', syncPickerFromText);

            root.addEventListener('click', function (event) {
                const button = event.target.closest('[data-action]');
                if (!button) {
                    return;
                }

                const action = button.getAttribute('data-action');
                const scope = button.getAttribute('data-scope');
                const id = button.getAttribute('data-id');

                if (!id) {
                    return;
                }

                if (action === 'edit') {
                    openEdit(button);
                } else if (action === 'delete') {
                    deleteTag(scope, id);
                }
            });
        })();
    </script>
@endsection
