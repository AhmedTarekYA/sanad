@extends('crm.layout')

@section('page-title', $pageTitle)

@section('style')
    <link rel="stylesheet" href="{{ asset('admin/assets/cssbundle/dataTables.min.css') }}">
@endsection

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
                <div class="card mb-3">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table id="dataTableObject" class="table display dataTable table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('image') }}</th>
                                        <th>{{ __('name') }}</th>
                                        <th>{{ __('email') }}</th>
                                        <th>{{ __('phone') }}</th>
                                        <th>{{ __('role') }}</th>
                                        <th>{{ __('status') }}</th>
                                        <th>{{ __('actions') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('crm.partials.help-modal', [
        'title' => __('crm_help_users_title'),
        'description' => __('crm_help_users_desc'),
    ])
@endsection

@section('js')
    <script src="{{ asset('admin/assets/js/bundle/dataTables.bundle.js') }}"></script>
    <script>
        (function () {
            const root = document.getElementById('crm-users-root');
            const indexUrl = root.dataset.indexUrl;
            const L = {
                noData: '{{ __('whatsapp_no_results') }}',
                failed: '{{ __('whatsapp_request_failed') }}',
                edit: '{{ __('edit') }}',
                del: '{{ __('delete') }}',
                cancel: '{{ __('cancel') }}',
                confirm: '{{ __('whatsapp_delete_contact_confirm') }}',
                done: '{{ __('auth.done successfully') }}',
                admin: '{{ __('admin') }}',
                agent: '{{ __('agent') }}',
                active: '{{ __('active') }}',
                inactive: '{{ __('inactive') }}',
            };

            function esc(v) {
                return String(v ?? '').replace(/[&<>"']/g, function (c) {
                    return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[c];
                });
            }

            const columns = [
                { data: 'id' },
                {
                    data: 'image_url', orderable: false, searchable: false,
                    render: function (v) { return '<img src="' + esc(v) + '" class="rounded-circle" style="width:38px;height:38px;object-fit:cover;" alt="">'; },
                },
                { data: 'name', render: function (v) { return '<span class="fw-bold">' + esc(v) + '</span>'; } },
                { data: 'email', render: function (v) { return '<span dir="ltr">' + esc(v) + '</span>'; } },
                { data: 'phone', render: function (v) { return '<span dir="ltr">' + esc(v || '') + '</span>'; } },
                { data: 'role', render: function (v) { return esc(v === 'admin' ? L.admin : L.agent); } },
                {
                    data: 'is_active',
                    render: function (v) {
                        return v ? '<span class="badge bg-success">' + esc(L.active) + '</span>'
                                 : '<span class="badge bg-secondary">' + esc(L.inactive) + '</span>';
                    },
                },
                {
                    data: 'id', orderable: false, searchable: false,
                    render: function (id) {
                        const editUrl = root.dataset.editUrlTemplate.replace('__ID__', id);
                        return '<div class="d-flex gap-1">'
                            + '<a class="btn btn-sm btn-primary" href="' + esc(editUrl) + '"><i class="fas fa-pen"></i></a>'
                            + '<button type="button" class="btn btn-sm btn-danger" data-action="delete" data-id="' + id + '"><i class="fas fa-trash"></i></button>'
                            + '</div>';
                    },
                },
            ];

            let dt;

            function loadTable() {
                $.ajax({
                    url: indexUrl,
                    type: 'GET',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    success: function (response) {
                        const items = (response.data || {}).items || [];
                        if (dt) { dt.destroy(); }
                        dt = $('#dataTableObject').DataTable({
                            data: items,
                            columns: columns,
                            language: { emptyTable: L.noData },
                            pageLength: 25,
                        });
                    },
                    error: function () {
                        if (window.errorToster) errorToster(L.failed);
                    },
                });
            }

            loadTable();

            document.getElementById('dataTableObject').addEventListener('click', function (e) {
                const btn = e.target.closest('[data-action="delete"]');
                if (!btn) return;

                const doDelete = function () {
                    $.ajax({
                        url: root.dataset.deleteUrlTemplate.replace('__ID__', btn.dataset.id),
                        type: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                        success: function () { if (window.successToster) successToster(L.done); loadTable(); },
                        error: function () { if (window.errorToster) errorToster(L.failed); },
                    });
                };

                if (window.Swal) {
                    Swal.fire({ text: L.confirm, icon: 'warning', showCancelButton: true, confirmButtonText: L.del, cancelButtonText: L.cancel })
                        .then(function (r) { if (r.isConfirmed) doDelete(); });
                } else if (window.confirm(L.confirm)) {
                    doDelete();
                }
            });
        })();
    </script>
@endsection
