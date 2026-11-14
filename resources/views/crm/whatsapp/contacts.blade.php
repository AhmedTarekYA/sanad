@extends('crm.layout')

@section('page-title', $pageTitle)

@section('style')
    <style>
        .wa-contact-tag {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            background: rgba(0, 0, 0, 0.06);
            font-size: 11px;
            font-weight: 700;
            margin: 0 2px 2px 0;
        }

        .wa-contact-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            background: #f1f3f5;
        }

        .wa-history-item {
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding: 8px 0;
        }
    </style>
@endsection

@section('content')
    <div id="whatsapp-contacts-root"
         data-index-url="{{ route('crm.whatsapp_contacts') }}"
         data-store-url="{{ route('crm.whatsapp_contacts.store') }}"
         data-import-url="{{ route('crm.whatsapp_contacts.import') }}"
         data-show-url-template="{{ route('crm.whatsapp_contacts.show', ['id' => '__ID__']) }}"
         data-update-url-template="{{ route('crm.whatsapp_contacts.update', ['id' => '__ID__']) }}"
         data-delete-url-template="{{ route('crm.whatsapp_contacts.destroy', ['id' => '__ID__']) }}"
         data-set-tags-url-template="{{ route('crm.whatsapp_contacts.tags.set', ['id' => '__ID__']) }}"
         data-tags-index-url="{{ route('crm.contact_tags.index') }}"
         data-tags-store-url="{{ route('crm.contact_tags.store') }}"
         data-tags-update-url-template="{{ route('crm.contact_tags.update', ['id' => '__ID__']) }}"
         data-tags-delete-url-template="{{ route('crm.contact_tags.destroy', ['id' => '__ID__']) }}"
         data-t-request-failed="{{ __('whatsapp_request_failed') }}"
         data-t-loading="{{ __('whatsapp_loading') }}"
         data-t-no-contacts="{{ __('whatsapp_no_contacts') }}"
         data-t-confirm-delete="{{ __('whatsapp_delete_contact_confirm') }}"
         data-t-import-done="{{ __('whatsapp_import_done') }}"
         data-t-created="{{ __('whatsapp_created') }}"
         data-t-updated="{{ __('whatsapp_updated') }}"
         data-t-failed="{{ __('failed') }}"
         data-t-no-history="{{ __('whatsapp_no_conversations_yet') }}"
         data-t-no-custom-fields="{{ __('whatsapp_no_custom_fields') }}">

        <div class="row g-3">
            <div class="col-12 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div>
                    <h5 class="mb-1">{{ __('whatsapp_contacts') }}</h5>
                    <small class="text-muted">{{ __('whatsapp_contacts_count') }}: <span id="wa-contacts-total">0</span></small>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-primary" id="wa-add-contact">
                        <i class="fa fa-plus"></i> {{ __('whatsapp_add_contact') }}
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="wa-import-open">
                        <i class="fa fa-upload"></i> {{ __('whatsapp_import') }}
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="wa-manage-tags">
                        <i class="fa fa-tags"></i> {{ __('whatsapp_manage_tags') }}
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body py-2">
                        <div class="row g-2 align-items-end">
                            <div class="col-12 col-md-5">
                                <label class="form-label mb-1 small fw-semibold">{{ __('search') }}</label>
                                <input type="text" id="wa-filter-search" class="form-control form-control-sm"
                                       placeholder="{{ __('search') }}">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label mb-1 small fw-semibold">{{ __('whatsapp_contact_tags') }}</label>
                                <select id="wa-filter-tag" class="form-select form-select-sm">
                                    <option value="">{{ __('whatsapp_all') }}</option>
                                    @foreach ($contactTags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-3 d-flex gap-2">
                                <button type="button" class="btn btn-primary btn-sm flex-grow-1" id="wa-filter-apply">
                                    <i class="fa fa-filter"></i> {{ __('auth.filter') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="wa-filter-reset" title="{{ __('whatsapp_all') }}">
                                    <i class="fa fa-refresh"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('name') }}</th>
                                    <th>{{ __('whatsapp_number') }}</th>
                                    <th>{{ __('email') }}</th>
                                    <th>{{ __('whatsapp_source') }}</th>
                                    <th>{{ __('whatsapp_contact_tags') }}</th>
                                    <th style="width:210px;">{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="wa-contacts-body">
                                <tr>
                                    <td colspan="6" class="text-center text-muted">{{ __('whatsapp_loading') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <small class="text-muted" id="wa-page-info"></small>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="wa-prev-page" disabled>
                                <i class="fa fa-angle-left"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="wa-next-page" disabled>
                                <i class="fa fa-angle-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="wa-contact-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="wa-contact-modal-title">{{ __('whatsapp_add_contact') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('close') }}"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="wa-contact-id" value="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('whatsapp_number') }}</label>
                                <input type="text" id="wa-contact-wa-id" class="form-control" dir="ltr" maxlength="30">
                                <div class="form-text">{{ __('whatsapp_number_input_hint') }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('name') }}</label>
                                <input type="text" id="wa-contact-name" class="form-control" maxlength="255">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('email') }}</label>
                                <input type="email" id="wa-contact-email" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('whatsapp_source') }}</label>
                                <input type="text" id="wa-contact-source" class="form-control" maxlength="60">
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('whatsapp_profile_pic_url') }}</label>
                                <input type="text" id="wa-contact-profile-pic" class="form-control" dir="ltr">
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('notes') }}</label>
                                <textarea id="wa-contact-note" class="form-control" rows="3" maxlength="5000"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('whatsapp_contact_tags') }}</label>
                                <select id="wa-contact-tags" class="form-select" multiple></select>
                            </div>
                        </div>
                        <div class="text-danger small mt-2 d-none" id="wa-contact-error"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('close') }}</button>
                        <button type="button" class="btn btn-primary" id="wa-contact-save">{{ __('save') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="wa-tags-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('whatsapp_tag_assign') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('close') }}"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="wa-tags-contact-id" value="">
                        <div id="wa-tags-checkboxes" class="d-flex flex-column gap-2"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('cancel') }}</button>
                        <button type="button" class="btn btn-primary" id="wa-tags-save">{{ __('whatsapp_save_tags') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="wa-details-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('whatsapp_contact_details') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('close') }}"></button>
                    </div>
                    <div class="modal-body" id="wa-details-body">
                        <div class="text-muted">{{ __('whatsapp_loading') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="wa-import-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('whatsapp_import_contacts') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('close') }}"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-light border small py-2 px-3">{{ __('whatsapp_csv_import_hint') }}</div>
                        <div class="mb-3">
                            <label class="form-label" for="wa-import-file">{{ __('whatsapp_import') }}</label>
                            <input type="file" class="form-control" id="wa-import-file" accept=".csv,text/csv,text/plain">
                        </div>
                        <div class="small text-muted d-none" id="wa-import-result"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('close') }}</button>
                        <button type="button" class="btn btn-primary" id="wa-import-save">{{ __('whatsapp_import') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="wa-manage-tags-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('whatsapp_manage_tags') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('close') }}"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2 align-items-end mb-3">
                            <div class="col-7">
                                <label class="form-label">{{ __('whatsapp_tag_name') }}</label>
                                <input type="text" id="wa-tag-name" class="form-control" maxlength="255">
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('whatsapp_tag_color') }}</label>
                                <input type="color" id="wa-tag-color" class="form-control form-control-color" value="#6c757d">
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-primary w-100" id="wa-tag-add">{{ __('whatsapp_new_tag') }}</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('whatsapp_tag_name') }}</th>
                                        <th style="width:120px;">{{ __('whatsapp_contacts_count') }}</th>
                                        <th style="width:150px;">{{ __('actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="wa-tags-body"></tbody>
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
            const root = document.getElementById('whatsapp-contacts-root');
            if (!root) {
                return;
            }

            const urls = {
                index: root.dataset.indexUrl,
                store: root.dataset.storeUrl,
                import: root.dataset.importUrl,
                showTpl: root.dataset.showUrlTemplate,
                updateTpl: root.dataset.updateUrlTemplate,
                deleteTpl: root.dataset.deleteUrlTemplate,
                setTagsTpl: root.dataset.setTagsUrlTemplate,
                tagsIndex: root.dataset.tagsIndexUrl,
                tagsStore: root.dataset.tagsStoreUrl,
                tagsUpdateTpl: root.dataset.tagsUpdateUrlTemplate,
                tagsDeleteTpl: root.dataset.tagsDeleteUrlTemplate
            };

            const t = {
                requestFailed: root.dataset.tRequestFailed || '',
                loading: root.dataset.tLoading || '',
                noContacts: root.dataset.tNoContacts || '',
                confirmDelete: root.dataset.tConfirmDelete || '',
                importDone: root.dataset.tImportDone || '',
                created: root.dataset.tCreated || '',
                updated: root.dataset.tUpdated || '',
                failed: root.dataset.tFailed || '',
                noHistory: root.dataset.tNoHistory || '',
                noCustomFields: root.dataset.tNoCustomFields || ''
            };

            const state = {
                pageUrl: urls.index,
                prevUrl: null,
                nextUrl: null,
                search: '',
                tagId: '',
                tags: []
            };

            const csrf = document.querySelector('meta[name="csrf-token"]')
                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                : '';

            const modal = (id) => {
                const element = document.getElementById(id);

                return element && window.bootstrap ? new bootstrap.Modal(element) : null;
            };

            const contactModal = modal('wa-contact-modal');
            const tagsModal = modal('wa-tags-modal');
            const detailsModal = modal('wa-details-modal');
            const importModal = modal('wa-import-modal');
            const manageTagsModal = modal('wa-manage-tags-modal');

            const escapeHtml = (value) => String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');

            const urlWithId = (template, id) => String(template || '').replace('__ID__', encodeURIComponent(String(id)));

            const errorMessage = (xhr) => {
                const data = xhr && xhr.responseJSON && xhr.responseJSON.data ? xhr.responseJSON.data : null;
                if (data) {
                    const first = Object.values(data)[0];
                    if (first && first[0]) {
                        return first[0];
                    }
                }
                return xhr && xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : t.requestFailed;
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

            const formatDate = (value) => {
                if (!value) {
                    return '';
                }
                const date = new Date(value);

                return Number.isNaN(date.getTime()) ? String(value) : date.toLocaleString();
            };

            function renderTags(tags) {
                return (tags || []).map((tag) =>
                    `<span class="wa-contact-tag">${escapeHtml(tag.name)}</span>`
                ).join('') || '<span class="text-muted small">-</span>';
            }

            function renderContacts(items) {
                const body = document.getElementById('wa-contacts-body');

                if (!items.length) {
                    body.innerHTML = `<tr><td colspan="6" class="text-center text-muted">${escapeHtml(t.noContacts)}</td></tr>`;
                    return;
                }

                body.innerHTML = items.map((contact) => {
                    const name = contact.name || contact.wa_id;
                    const avatar = contact.profile_pic
                        ? `<img src="${escapeHtml(contact.profile_pic)}" class="wa-contact-avatar me-2" alt="">`
                        : '<span class="wa-contact-avatar d-inline-flex align-items-center justify-content-center me-2"><i class="fa fa-user text-muted"></i></span>';

                    return `
                        <tr>
                            <td><div class="d-flex align-items-center">${avatar}<div><div class="fw-bold">${escapeHtml(name)}</div></div></div></td>
                            <td dir="ltr">${escapeHtml(contact.wa_id)}</td>
                            <td dir="ltr">${escapeHtml(contact.email || '')}</td>
                            <td>${escapeHtml(contact.source || '')}</td>
                            <td>${renderTags(contact.tags)}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-action="view" data-id="${contact.id}">{{ __('whatsapp_view') }}</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-action="edit" data-id="${contact.id}">{{ __('edit') }}</button>
                                    <button type="button" class="btn btn-sm btn-outline-info" data-action="tags" data-id="${contact.id}">{{ __('whatsapp_tag_assign') }}</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-action="delete" data-id="${contact.id}">{{ __('delete') }}</button>
                                </div>
                            </td>
                        </tr>
                    `;
                }).join('');
            }

            function renderPagination(pagination, items) {
                state.prevUrl = pagination.previous_page_url || null;
                state.nextUrl = pagination.next_page_url || null;
                document.getElementById('wa-prev-page').disabled = !state.prevUrl;
                document.getElementById('wa-next-page').disabled = !state.nextUrl;
                document.getElementById('wa-contacts-total').textContent = String(items.length);
                document.getElementById('wa-page-info').textContent = `#${pagination.current_page} · ${pagination.per_page}`;
            }

            function loadContacts(url) {
                const body = document.getElementById('wa-contacts-body');
                body.innerHTML = `<tr><td colspan="6" class="text-center text-muted">${escapeHtml(t.loading)}</td></tr>`;

                $.ajax({
                    url: url || urls.index,
                    type: 'GET',
                    headers: { 'Accept': 'application/json' },
                    data: { search: state.search, tag_ids: state.tagId ? [state.tagId] : [] },
                    success: function (response) {
                        const data = response.data || {};
                        state.pageUrl = url || urls.index;
                        renderContacts(data.items || []);
                        renderPagination(data.pagination || {}, data.items || []);
                    },
                    error: function (xhr) {
                        body.innerHTML = `<tr><td colspan="6" class="text-center text-danger">${escapeHtml(errorMessage(xhr))}</td></tr>`;
                    }
                });
            }

            function loadTags(callback) {
                $.ajax({
                    url: urls.tagsIndex,
                    type: 'GET',
                    headers: { 'Accept': 'application/json' },
                    success: function (response) {
                        state.tags = response.data.items || [];
                        if (callback) {
                            callback(state.tags);
                        }
                    },
                    error: notifyError
                });
            }

            function fillTagSelect(selectedIds) {
                const select = document.getElementById('wa-contact-tags');
                select.innerHTML = state.tags.map((tag) =>
                    `<option value="${tag.id}" ${selectedIds.includes(Number(tag.id)) ? 'selected' : ''}>${escapeHtml(tag.name)}</option>`
                ).join('');
            }

            function openContactModal(contact) {
                const isEdit = !!(contact && contact.id);
                document.getElementById('wa-contact-modal-title').textContent = isEdit ? '{{ __('whatsapp_edit_contact') }}' : '{{ __('whatsapp_add_contact') }}';
                document.getElementById('wa-contact-id').value = isEdit ? contact.id : '';
                document.getElementById('wa-contact-wa-id').value = isEdit ? contact.wa_id : '';
                document.getElementById('wa-contact-wa-id').readOnly = isEdit;
                document.getElementById('wa-contact-name').value = isEdit ? (contact.name || '') : '';
                document.getElementById('wa-contact-email').value = isEdit ? (contact.email || '') : '';
                document.getElementById('wa-contact-source').value = isEdit ? (contact.source || '') : '';
                document.getElementById('wa-contact-profile-pic').value = isEdit ? (contact.profile_pic || '') : '';
                document.getElementById('wa-contact-note').value = isEdit ? (contact.note || '') : '';
                document.getElementById('wa-contact-error').classList.add('d-none');

                const selectedIds = isEdit && contact.tags ? contact.tags.map((tag) => Number(tag.id)) : [];
                loadTags(function () {
                    fillTagSelect(selectedIds);
                    if (contactModal) {
                        contactModal.show();
                    }
                });
            }

            function saveContact() {
                const id = document.getElementById('wa-contact-id').value;
                const selectedTags = Array.from(document.getElementById('wa-contact-tags').selectedOptions).map((option) => Number(option.value));
                const payload = {
                    wa_id: document.getElementById('wa-contact-wa-id').value.trim(),
                    name: document.getElementById('wa-contact-name').value.trim(),
                    email: document.getElementById('wa-contact-email').value.trim(),
                    source: document.getElementById('wa-contact-source').value.trim(),
                    profile_pic: document.getElementById('wa-contact-profile-pic').value.trim(),
                    note: document.getElementById('wa-contact-note').value.trim(),
                    tag_ids: selectedTags
                };

                $.ajax({
                    url: id ? urlWithId(urls.updateTpl, id) : urls.store,
                    type: id ? 'PUT' : 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    data: payload,
                    success: function (response) {
                        if (contactModal) {
                            contactModal.hide();
                        }
                        notifySuccess(response.message);
                        loadContacts(state.pageUrl);
                        loadTags();
                    },
                    error: function (xhr) {
                        const target = document.getElementById('wa-contact-error');
                        target.textContent = errorMessage(xhr);
                        target.classList.remove('d-none');
                    }
                });
            }

            function openTagsModal(contact) {
                document.getElementById('wa-tags-contact-id').value = contact.id;
                const selected = (contact.tags || []).map((tag) => Number(tag.id));
                const wrapper = document.getElementById('wa-tags-checkboxes');

                loadTags(function (tags) {
                    if (!tags.length) {
                        wrapper.innerHTML = `<div class="text-muted">${escapeHtml('{{ __('whatsapp_no_tags_available') }}')}</div>`;
                    } else {
                        wrapper.innerHTML = tags.map((tag) => `
                            <label class="form-check d-flex align-items-center gap-2">
                                <input class="form-check-input" type="checkbox" value="${tag.id}" ${selected.includes(Number(tag.id)) ? 'checked' : ''}>
                                <span>${escapeHtml(tag.name)}</span>
                            </label>
                        `).join('');
                    }
                    if (tagsModal) {
                        tagsModal.show();
                    }
                });
            }

            function saveTags() {
                const id = document.getElementById('wa-tags-contact-id').value;
                const tagIds = Array.from(document.querySelectorAll('#wa-tags-checkboxes input:checked')).map((input) => Number(input.value));

                $.ajax({
                    url: urlWithId(urls.setTagsTpl, id),
                    type: 'PUT',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    data: { tag_ids: tagIds },
                    success: function (response) {
                        if (tagsModal) {
                            tagsModal.hide();
                        }
                        notifySuccess(response.message);
                        loadContacts(state.pageUrl);
                    },
                    error: notifyError
                });
            }

            function openDetails(id) {
                const body = document.getElementById('wa-details-body');
                body.innerHTML = `<div class="text-muted">${escapeHtml(t.loading)}</div>`;
                if (detailsModal) {
                    detailsModal.show();
                }

                $.ajax({
                    url: urlWithId(urls.showTpl, id),
                    type: 'GET',
                    headers: { 'Accept': 'application/json' },
                    success: function (response) {
                        const data = response.data || {};
                        const contact = data.contact || {};
                        const stats = data.stats || {};
                        const history = data.conversation_history || [];
                        const customFields = contact.custom_fields && Object.keys(contact.custom_fields).length
                            ? escapeHtml(JSON.stringify(contact.custom_fields))
                            : `<span class="text-muted">${escapeHtml(t.noCustomFields)}</span>`;

                        const historyHtml = history.length
                            ? history.map((message) => `
                                <div class="wa-history-item">
                                    <div class="d-flex justify-content-between">
                                        <strong>${escapeHtml(message.direction === 'out' || message.direction === 'outgoing' ? contact.wa_id : contact.wa_id)}</strong>
                                        <small class="text-muted">${escapeHtml(formatDate(message.wa_timestamp || message.created_at))}</small>
                                    </div>
                                    <div class="small">${escapeHtml(message.body || message.type || '')}</div>
                                </div>
                            `).join('')
                            : `<div class="text-muted">${escapeHtml(t.noHistory)}</div>`;

                        body.innerHTML = `
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="fw-bold">${escapeHtml(contact.name || contact.wa_id)}</div>
                                    <div class="text-muted" dir="ltr">${escapeHtml(contact.wa_id || '')}</div>
                                    <div class="mt-2">${renderTags(contact.tags)}</div>
                                </div>
                                <div class="col-md-6">
                                    <div><strong>{{ __('whatsapp_total_messages') }}:</strong> ${Number(stats.total_messages || 0)}</div>
                                    <div><strong>{{ __('whatsapp_total_conversations') }}:</strong> ${Number(stats.total_conversations || 0)}</div>
                                    <div><strong>{{ __('whatsapp_last_activity') }}:</strong> ${escapeHtml(formatDate(stats.last_activity))}</div>
                                    <div><strong>{{ __('whatsapp_registered_at') }}:</strong> ${escapeHtml(formatDate(stats.registered_at))}</div>
                                </div>
                                <div class="col-12">
                                    <strong>{{ __('notes') }}:</strong> ${escapeHtml(contact.note || '-')}
                                </div>
                                <div class="col-12">
                                    <strong>{{ __('whatsapp_custom_fields') }}:</strong> ${customFields}
                                </div>
                            </div>
                            <h6 class="mb-2">{{ __('whatsapp_conversation_history') }}</h6>
                            <div>${historyHtml}</div>
                        `;
                    },
                    error: function (xhr) {
                        body.innerHTML = `<div class="text-danger">${escapeHtml(errorMessage(xhr))}</div>`;
                    }
                });
            }

            function deleteContact(id) {
                const confirmPromise = window.Swal
                    ? Swal.fire({
                        title: t.confirmDelete,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: '{{ __('delete') }}',
                        cancelButtonText: '{{ __('cancel') }}'
                    }).then((result) => result.isConfirmed)
                    : Promise.resolve(window.confirm(t.confirmDelete));

                confirmPromise.then(function (confirmed) {
                    if (!confirmed) {
                        return;
                    }

                    $.ajax({
                        url: urlWithId(urls.deleteTpl, id),
                        type: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                        success: function (response) {
                            notifySuccess(response.message);
                            loadContacts(state.pageUrl);
                        },
                        error: notifyError
                    });
                });
            }

            function loadTagManager() {
                $.ajax({
                    url: urls.tagsIndex,
                    type: 'GET',
                    headers: { 'Accept': 'application/json' },
                    success: function (response) {
                        state.tags = response.data.items || [];
                        document.getElementById('wa-tags-body').innerHTML = state.tags.length
                            ? state.tags.map((tag) => `
                                <tr>
                                    <td>${escapeHtml(tag.name)}</td>
                                    <td>${Number(tag.contacts_count || 0)}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-tag-delete="${tag.id}">{{ __('delete') }}</button>
                                    </td>
                                </tr>
                            `).join('')
                            : `<tr><td colspan="3" class="text-center text-muted">{{ __('whatsapp_no_tags') }}</td></tr>`;

                        document.getElementById('wa-filter-tag').innerHTML =
                            `<option value="">{{ __('whatsapp_all') }}</option>` +
                            state.tags.map((tag) => `<option value="${tag.id}">${escapeHtml(tag.name)}</option>`).join('');
                        document.getElementById('wa-filter-tag').value = state.tagId;
                    },
                    error: notifyError
                });
            }

            function addTag() {
                const name = document.getElementById('wa-tag-name').value.trim();
                const color = document.getElementById('wa-tag-color').value;

                $.ajax({
                    url: urls.tagsStore,
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    data: { name: name, color: color },
                    success: function (response) {
                        document.getElementById('wa-tag-name').value = '';
                        notifySuccess(response.message);
                        loadTagManager();
                    },
                    error: notifyError
                });
            }

            function deleteTag(id) {
                const confirmPromise = window.Swal
                    ? Swal.fire({
                        title: t.confirmDelete,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: '{{ __('delete') }}',
                        cancelButtonText: '{{ __('cancel') }}'
                    }).then((result) => result.isConfirmed)
                    : Promise.resolve(window.confirm(t.confirmDelete));

                confirmPromise.then(function (confirmed) {
                    if (!confirmed) {
                        return;
                    }

                    $.ajax({
                        url: urlWithId(urls.tagsDeleteTpl, id),
                        type: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                        success: function (response) {
                            notifySuccess(response.message);
                            loadTagManager();
                            loadContacts(state.pageUrl);
                        },
                        error: notifyError
                    });
                });
            }

            function importContacts() {
                const input = document.getElementById('wa-import-file');
                if (!input.files || !input.files.length) {
                    return;
                }

                const formData = new FormData();
                formData.append('file', input.files[0]);

                $.ajax({
                    url: urls.import,
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        const data = response.data || {};
                        const result = document.getElementById('wa-import-result');
                        result.textContent = `${t.importDone} — ${t.created}: ${data.created || 0} · ${t.updated}: ${data.updated || 0} · ${t.failed}: ${data.failed || 0}`;
                        result.classList.remove('d-none');
                        notifySuccess(response.message);
                        loadContacts(urls.index);
                        loadTagManager();
                    },
                    error: notifyError
                });
            }

            document.getElementById('wa-filter-apply').addEventListener('click', function () {
                state.search = document.getElementById('wa-filter-search').value.trim();
                state.tagId = document.getElementById('wa-filter-tag').value;
                loadContacts(urls.index);
            });

            document.getElementById('wa-filter-search').addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    document.getElementById('wa-filter-apply').click();
                }
            });

            document.getElementById('wa-filter-reset').addEventListener('click', function () {
                document.getElementById('wa-filter-search').value = '';
                document.getElementById('wa-filter-tag').value = '';
                state.search = '';
                state.tagId = '';
                loadContacts(urls.index);
            });

            document.getElementById('wa-prev-page').addEventListener('click', function () {
                if (state.prevUrl) {
                    loadContacts(state.prevUrl);
                }
            });

            document.getElementById('wa-next-page').addEventListener('click', function () {
                if (state.nextUrl) {
                    loadContacts(state.nextUrl);
                }
            });

            document.getElementById('wa-add-contact').addEventListener('click', function () {
                openContactModal(null);
            });

            document.getElementById('wa-contact-save').addEventListener('click', saveContact);
            document.getElementById('wa-tags-save').addEventListener('click', saveTags);
            document.getElementById('wa-import-open').addEventListener('click', function () {
                document.getElementById('wa-import-result').classList.add('d-none');
                if (importModal) {
                    importModal.show();
                }
            });
            document.getElementById('wa-import-save').addEventListener('click', importContacts);
            document.getElementById('wa-manage-tags').addEventListener('click', function () {
                loadTagManager();
                if (manageTagsModal) {
                    manageTagsModal.show();
                }
            });
            document.getElementById('wa-tag-add').addEventListener('click', addTag);

            root.addEventListener('click', function (event) {
                const contactButton = event.target.closest('[data-action]');
                if (contactButton) {
                    const id = contactButton.getAttribute('data-id');
                    const action = contactButton.getAttribute('data-action');

                    if (action === 'delete') {
                        deleteContact(id);
                    } else if (action === 'view') {
                        openDetails(id);
                    } else if (action === 'tags') {
                        $.ajax({
                            url: urlWithId(urls.showTpl, id),
                            type: 'GET',
                            headers: { 'Accept': 'application/json' },
                            success: function (response) {
                                openTagsModal(response.data.contact || {});
                            },
                            error: notifyError
                        });
                    } else if (action === 'edit') {
                        $.ajax({
                            url: urlWithId(urls.showTpl, id),
                            type: 'GET',
                            headers: { 'Accept': 'application/json' },
                            success: function (response) {
                                openContactModal(response.data.contact || {});
                            },
                            error: notifyError
                        });
                    }
                    return;
                }

                const tagButton = event.target.closest('[data-tag-delete]');
                if (tagButton) {
                    deleteTag(tagButton.getAttribute('data-tag-delete'));
                }
            });

            loadTags();
            loadContacts(urls.index);
        })();
    </script>
@endsection
