@extends('sanad.layout.indexs.index')

@section('style')
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/cssbundle/dataTables.min.css">
@endsection

@section('page-title')
    {{ __('auth.client_reviews') }}
@endsection

@section('page-links')
    <li class="breadcrumb-item active" aria-current="page">{{ __('auth.client_reviews') }}</li>
@endsection

@section('content')
    @if (checkIfHasPermission('client-reviews-create'))
        {!! addButton(route('client-reviews.create'), __('auth.client_review')) !!}
    @endif

    {{-- Filter Bar --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <div class="row g-2 align-items-end">
                <div class="col-6 col-md-4">
                    <label class="form-label mb-1 small fw-semibold">{{ __('auth.date_from') }}</label>
                    <input type="date" id="filter-date-from" class="form-control form-control-sm">
                </div>
                <div class="col-6 col-md-4">
                    <label class="form-label mb-1 small fw-semibold">{{ __('auth.date_to') }}</label>
                    <input type="date" id="filter-date-to" class="form-control form-control-sm">
                </div>
                <div class="col-12 col-md-4 d-flex gap-2">
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
                <th>{{ __('auth.job') }}</th>
                <th>{{ __('auth.company_name') }}</th>
                <th>{{ __('auth.review_message') }}</th>
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
                { data: 'DT_RowIndex',   name: 'DT_RowIndex',   orderable: false, searchable: false },
                { data: 'name',          name: 'name',          orderable: false, searchable: true },
                { data: 'job',           name: 'job',           orderable: false, searchable: true },
                { data: 'company_name',  name: 'company_name',  orderable: false, searchable: true },
                { data: 'review_message', name: 'review_message', orderable: false, searchable: true },
                { data: 'actions',       name: 'actions',       orderable: false, searchable: false },
            ];

            showDataTableWithFilters("{{ $dataTableRoute }}", columns, function () {
                return {
                    date_from: $('#filter-date-from').val(),
                    date_to:   $('#filter-date-to').val(),
                };
            });

            $('#btn-filter').on('click', function () {
                window.reloadDataTable();
            });

            $('#btn-reset-filter').on('click', function () {
                $('#filter-date-from').val('');
                $('#filter-date-to').val('');
                window.reloadDataTable();
            });
        });
    </script>
@endsection
