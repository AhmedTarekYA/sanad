@extends('crm.layout')

@section('page-title', $pageTitle)

@section('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/cssbundle/dataTables.min.css') }}">
@endsection

@section('content')
    <div id="crm-sales-root"
         data-index-url="{{ route('crm.crm_sales.index') }}"
         data-edit-url-template="{{ route('crm.crm_sales.edit', ['id' => '__ID__']) }}"
         data-delete-url-template="{{ route('crm.crm_sales.destroy', ['id' => '__ID__']) }}">
        <div class="row g-3">
            <div class="col-12 d-flex flex-wrap align-items-center justify-content-between gap-2">
                <h5 class="mb-0">{{ __('crm_sales') }}</h5>
                <a href="{{ route('crm.crm_sales.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> {{ __('create') }}
                </a>
            </div>

            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body py-2">
                        <div class="row g-2 align-items-end">
                            <div class="col-12 col-md-4">
                                <label class="form-label mb-1 small fw-semibold">{{ __('added_by') }}</label>
                                <select id="crm-sales-filter-user" class="form-select form-select-sm">
                                    <option value="">{{ __('all') }}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="button" class="btn btn-primary btn-sm w-100" id="crm-sales-filter-apply">
                                    <i class="fa fa-filter"></i> {{ __('auth.filter') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width:60px;">#</th>
                                    <th>{{ __('customer_name') }}</th>
                                    <th>{{ __('phone') }}</th>
                                    <th>{{ __('price') }}</th>
                                    <th>{{ __('request_text') }}</th>
                                    <th>{{ __('added_by') }}</th>
                                    <th>{{ __('created_at') }}</th>
                                    <th style="width:170px;">{{ __('actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="crm-sales-body">
                                <tr><td colspan="8" class="text-center text-muted">{{ __('whatsapp_loading') }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('crm.partials.help-modal', [
        'title' => __('crm_help_sales_title'),
        'description' => __('crm_help_sales_desc'),
    ])
@endsection

@section('js')
    <script src="{{ asset('admin/assets/js/bundle/dataTables.bundle.js') }}"></script>
    <script>
        (function () {
            const root = document.getElementById('crm-sales-root');
            const body = document.getElementById('crm-sales-body');
            const indexUrl = root.dataset.indexUrl;
            const filterUser = document.getElementById('crm-sales-filter-user');
            const labels = {
                noSales: '{{ __('whatsapp_no_results') }}',
                failed: '{{ __('whatsapp_request_failed') }}',
                confirmDelete: '{{ __('whatsapp_delete_contact_confirm') }}',
            };

            function escapeHtml(value) {
                return String(value ?? '').replace(/[&<>"']/g, function (character) {
                    return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[character];
                });
            }

            function render(items) {
                if (!items.length) {
                    body.innerHTML = `<tr><td colspan="8" class="text-center text-muted">${escapeHtml(labels.noSales)}</td></tr>`;
                    return;
                }

                body.innerHTML = items.map(function (sale) {
                    const requestText = sale.request_text || '';
                    const shortText = requestText.length > 80 ? requestText.slice(0, 80) + '…' : requestText;
                    const addedBy = sale.crm_user ? sale.crm_user.name : '—';
                    const createdAt = sale.created_at ? new Date(sale.created_at).toLocaleString() : '—';

                    return `
                        <tr>
                            <td>${sale.id}</td>
                            <td>${escapeHtml(sale.customer_name || '')}</td>
                            <td dir="ltr">${escapeHtml(sale.phone || '')}</td>
                            <td>${escapeHtml(sale.price || '')}</td>
                            <td title="${escapeHtml(requestText)}">${escapeHtml(shortText)}</td>
                            <td>${escapeHtml(addedBy)}</td>
                            <td><small class="text-muted">${escapeHtml(createdAt)}</small></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a class="btn btn-sm btn-outline-primary" href="${root.dataset.editUrlTemplate.replace('__ID__', sale.id)}"><i class="fas fa-pen me-1"></i>{{ __('edit') }}</a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-action="delete" data-id="${sale.id}"><i class="fas fa-trash me-1"></i>{{ __('delete') }}</button>
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
                    data: { crm_user_id: filterUser.value },
                    success: function (response) {
                        render((response.data || {}).items || []);
                    },
                    error: function () {
                        body.innerHTML = `<tr><td colspan="8" class="text-center text-danger">${escapeHtml(labels.failed)}</td></tr>`;
                    }
                });
            }

            document.getElementById('crm-sales-filter-apply').addEventListener('click', load);

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
