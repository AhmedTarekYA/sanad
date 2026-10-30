@extends('sanad.layout.indexs.index')

@section('style')
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/cssbundle/dataTables.min.css">
@endsection

@section('page-title')
    {{ __('auth.faqs') }}
@endsection

@section('page-links')
    <li class="breadcrumb-item active" aria-current="page">{{ __('auth.faqs') }}</li>
@endsection

@section('content')
    @if(checkIfHasPermission('faqs-create'))
        {!! addButton(route('faqs.create'), __('auth.faq')) !!}
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
                <th>{{ __('auth.question') }}</th>
                <th>{{ __('auth.answer') }}</th>
                <th>{{ __('auth.sort_order') }}</th>
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
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'question',    name: 'question',    orderable: false, searchable: true },
                { data: 'answer',      name: 'answer',      orderable: false, searchable: true },
                { data: 'sort_order',  name: 'sort_order',  orderable: true,  searchable: false },
                { data: 'is_active',   name: 'is_active',   orderable: false, searchable: false },
                { data: 'actions',     name: 'actions',     orderable: false, searchable: false },
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
