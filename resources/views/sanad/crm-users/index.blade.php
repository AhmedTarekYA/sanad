@extends('sanad.layout.indexs.index')

@section('style')
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/cssbundle/dataTables.min.css">
@endsection

@section('page-title')
    {{ __('auth.crm_users') }}
@endsection

@section('page-links')
    <li class="breadcrumb-item active" aria-current="page">{{ __('auth.crm_users') }}</li>
@endsection

@section('content')
    @if(checkIfHasPermission('crm-users-create'))
        {!! addButton(route('crm-users.create'), __('auth.crm_user')) !!}
    @endif

    {{-- Filter Bar --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <div class="row g-2 align-items-end">
                <div class="col-12 col-md-3">
                    <label class="form-label mb-1 small fw-semibold">{{ __('auth.status') }}</label>
                    <select id="filter-status" class="form-select form-select-sm">
                        <option value="">{{ __('all') }}</option>
                        <option value="1">{{ __('active') }}</option>
                        <option value="0">{{ __('inactive') }}</option>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label mb-1 small fw-semibold">{{ __('auth.date_from') }}</label>
                    <input type="date" id="filter-date-from" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label mb-1 small fw-semibold">{{ __('auth.date_to') }}</label>
                    <input type="date" id="filter-date-to" class="form-control form-control-sm">
                </div>
                <div class="col-12 col-md-3 d-flex gap-2">
                    <button id="btn-filter" class="btn btn-primary btn-sm flex-grow-1">
                        <i class="ti ti-filter me-1"></i>{{ __('auth.filter') }}
                    </button>
                    <button id="btn-reset-filter" class="btn btn-outline-secondary btn-sm">
                        <i class="ti ti-refresh"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <table id="dataTableObject" class="table display dataTable table-hover" style="width:100%">
        <thead>
            <tr>
                <th>{{ __('auth.SL') }}</th>
                <th>{{ __('auth.name') }}</th>
                <th>{{ __('auth.email') }}</th>
                <th>{{ __('auth.subscription_ends_at') }}</th>
                <th>{{ __('auth.status') }}</th>
                <th>{{ __('auth.actions') }}</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
@endsection

@section('js')
    <script src="{{ asset('admin') }}/assets/js/bundle/dataTables.bundle.js"></script>
    <script>
        $(document).ready(function () {
            let columns = [
                { data: 'DT_RowIndex',           name: 'DT_RowIndex',           orderable: false, searchable: false },
                { data: 'name',                  name: 'name',                  orderable: false, searchable: true },
                { data: 'email',                 name: 'email',                 orderable: false, searchable: true },
                { data: 'subscription_ends_at',  name: 'subscription_ends_at',  orderable: true,  searchable: false },
                { data: 'is_active',             name: 'is_active',             orderable: false, searchable: false },
                { data: 'actions',               name: 'actions',               orderable: false, searchable: false },
            ];

            showDataTableWithFilters("{{ $dataTableRoute }}", columns, function () {
                return {
                    status:    $('#filter-status').val(),
                    date_from: $('#filter-date-from').val(),
                    date_to:   $('#filter-date-to').val(),
                };
            });

            $('#btn-filter').on('click', function () { window.reloadDataTable(); });
            $('#btn-reset-filter').on('click', function () {
                $('#filter-status, #filter-date-from, #filter-date-to').val('');
                window.reloadDataTable();
            });
        });
    </script>
@endsection
