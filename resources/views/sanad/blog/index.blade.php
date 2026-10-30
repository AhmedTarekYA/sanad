@extends('sanad.layout.indexs.index')

@section('style')
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/cssbundle/dataTables.min.css">
@endsection

@section('page-title')
    {{ __('auth.blogs') }}
@endsection

@section('page-links')
    <li class="breadcrumb-item active" aria-current="page">{{ __('auth.blogs') }}</li>
@endsection

@section('content')
    @if (checkIfHasPermission('blogs-create'))
        {!! addButton(route('blogs.create'), __('auth.blog')) !!}
    @endif

    {{-- Filter Bar --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <div class="row g-2 align-items-end">
                <div class="col-12 col-md-3">
                    <label class="form-label mb-1 small fw-semibold">{{ __('auth.featured') }}</label>
                    <select id="filter-featured" class="form-select form-select-sm">
                        <option value="">{{ __('auth.all') }}</option>
                        <option value="1">{{ __('auth.featured') }}</option>
                        <option value="0">{{ __('auth.not_featured') }}</option>
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
                <th>{{ __('auth.image') }}</th>
                <th>{{ __('auth.title') }}</th>
                <th>{{ __('auth.slug') }}</th>
                <th>{{ __('auth.featured') }}</th>
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
                { data: 'DT_RowIndex',  name: 'DT_RowIndex',  orderable: false, searchable: false },
                { data: 'image',        name: 'image',        orderable: false, searchable: false },
                { data: 'title',        name: 'title',        orderable: false, searchable: false },
                { data: 'slug',         name: 'slug',         orderable: false, searchable: false },
                { data: 'is_featured',  name: 'is_featured',  orderable: false, searchable: false },
                { data: 'actions',      name: 'actions',      orderable: false, searchable: false },
            ];

            showDataTableWithFilters("{{ $dataTableRoute }}", columns, function () {
                return {
                    is_featured: $('#filter-featured').val(),
                    date_from:   $('#filter-date-from').val(),
                    date_to:     $('#filter-date-to').val(),
                };
            });

            $('#btn-filter').on('click', function () {
                window.reloadDataTable();
            });

            $('#btn-reset-filter').on('click', function () {
                $('#filter-featured').val('');
                $('#filter-date-from').val('');
                $('#filter-date-to').val('');
                window.reloadDataTable();
            });
        });
    </script>
@endsection
