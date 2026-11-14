@extends('crm.layout')

@section('page-title', $pageTitle)

@section('content')
    <div id="crm-users-root"
         data-index-url="{{ route('crm.users.index') }}"
         data-edit-url-template="{{ route('crm.users.edit', ['id' => '__ID__']) }}"
         data-delete-url-template="{{ route('crm.users.destroy', ['id' => '__ID__']) }}">
        <div class="row g-3">
            <div class="col-12 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <h5 class="mb-0">{{ __('users') }}</h5>
                <a href="{{ route('crm.users.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> {{ __('create') }}
                </a>
            </div>

            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:60px;">#</th>
                                    <th>{{ __('image') }}</th>
                                    <th>{{ __('name') }}</th>
                                    <th>{{ __('email') }}</th>
                                    <th>{{ __('phone') }}</th>
                                    <th>{{ __('role') }}</th>
                                    <th>{{ __('status') }}</th>
                                    <th style="width:170px;">{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="crm-users-body">
                                <tr><td colspan="8" class="text-center text-muted">{{ __('whatsapp_loading') }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        (function () {
            const root = document.getElementById('crm-users-root');
            const body = document.getElementById('crm-users-body');
            const indexUrl = root.dataset.indexUrl;
            const labels = {
                noUsers: '{{ __('whatsapp_no_results') }}',
                failed: '{{ __('whatsapp_request_failed') }}',
                edit: '{{ __('edit') }}',
                delete: '{{ __('delete') }}',
                confirmDelete: '{{ __('whatsapp_delete_contact_confirm') }}',
            };

            function escapeHtml(value) {
                return String(value ?? '').replace(/[&<>"']/g, function (character) {
                    return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[character];
                });
            }

            function render(items) {
                if (!items.length) {
                    body.innerHTML = `<tr><td colspan="8" class="text-center text-muted">${escapeHtml(labels.noUsers)}</td></tr>`;
                    return;
                }

                body.innerHTML = items.map(function (user) {
                    const status = user.is_active
                        ? `<span class="badge bg-success">{{ __('active') }}</span>`
                        : `<span class="badge bg-secondary">{{ __('inactive') }}</span>`;
                    const role = user.role === 'admin' ? '{{ __('admin') }}' : '{{ __('agent') }}';

                    return `
                        <tr>
                            <td>${user.id}</td>
                            <td><img src="${escapeHtml(user.image_url)}" class="rounded-circle" style="width:38px;height:38px;object-fit:cover;" alt=""></td>
                            <td class="fw-bold">${escapeHtml(user.name)}</td>
                            <td dir="ltr">${escapeHtml(user.email)}</td>
                            <td dir="ltr">${escapeHtml(user.phone || '')}</td>
                            <td>${escapeHtml(role)}</td>
                            <td>${status}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a class="btn btn-sm btn-outline-secondary" href="${root.dataset.editUrlTemplate.replace('__ID__', user.id)}">{{ __('edit') }}</a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-action="delete" data-id="${user.id}">{{ __('delete') }}</button>
                                </div>
                            </td>
                        </tr>
                    `;
                }).join('');
            }

            function load() {
                $.ajax({
                    url: indexUrl,
                    type: 'GET',
                    headers: { 'Accept': 'application/json' },
                    success: function (response) {
                        render((response.data || {}).items || []);
                    },
                    error: function () {
                        body.innerHTML = `<tr><td colspan="8" class="text-center text-danger">${escapeHtml(labels.failed)}</td></tr>`;
                    }
                });
            }

            body.addEventListener('click', function (event) {
                const button = event.target.closest('[data-action="delete"]');
                if (!button) return;

                const doDelete = function () {
                    $.ajax({
                        url: root.dataset.deleteUrlTemplate.replace('__ID__', button.dataset.id),
                        type: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                        success: function () {
                            if (window.successToster) successToster('{{ __('auth.done successfully') }}');
                            load();
                        },
                        error: function () {
                            if (window.errorToster) errorToster(labels.failed);
                        }
                    });
                };

                if (window.Swal) {
                    Swal.fire({
                        text: labels.confirmDelete,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: '{{ __('delete') }}',
                        cancelButtonText: '{{ __('cancel') }}',
                    }).then(function (result) { if (result.isConfirmed) doDelete(); });
                } else if (window.confirm(labels.confirmDelete)) {
                    doDelete();
                }
            });

            load();
        })();
    </script>
@endsection
