@extends('sanad.layout.indexs.index')

@section('style')
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/cssbundle/dataTables.min.css">
@endsection

@section('page-title')
    {{ __('auth.consultation_requests') }}
@endsection

@section('page-links')
    <li class="breadcrumb-item active" aria-current="page">{{ __('auth.consultation_requests') }}</li>
@endsection

@section('content')
    {{-- Filter Bar --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <div class="row g-2 align-items-end">
                <div class="col-12 col-md-3">
                    <label class="form-label mb-1 small fw-semibold">{{ __('auth.status') }}</label>
                    <select id="filter-is-read" class="form-select form-select-sm">
                        <option value="">{{ __('auth.all') }}</option>
                        <option value="0">{{ __('auth.unread') }}</option>
                        <option value="1">{{ __('auth.read') }}</option>
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
                <th>{{ __('auth.full_name') }}</th>
                <th>{{ __('auth.company_name') }}</th>
                <th>{{ __('auth.mobile_whatsapp') }}</th>
                <th>{{ __('auth.daily_contact_volume') }}</th>
                <th>{{ __('auth.status') }}</th>
                <th>{{ __('auth.date') }}</th>
                <th>{{ __('auth.actions') }}</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    {{-- Details Modal --}}
    <div class="modal fade" id="consultationModal" tabindex="-1" aria-labelledby="consultationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="consultationModalLabel">{{ __('auth.consultation_details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="consultationModalBody">
                    <div class="text-center py-4"><div class="spinner-border text-primary"></div></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('admin') }}/assets/js/bundle/dataTables.bundle.js"></script>

    <script>
        $(document).ready(function () {
            let columns = [
                { data: 'DT_RowIndex',          name: 'DT_RowIndex',          orderable: false, searchable: false },
                { data: 'full_name',             name: 'full_name',            orderable: false, searchable: false },
                { data: 'company_name',          name: 'company_name',         orderable: false, searchable: false },
                { data: 'mobile_whatsapp',       name: 'mobile_whatsapp',      orderable: false, searchable: false },
                { data: 'daily_contact_volume',  name: 'daily_contact_volume', orderable: false, searchable: false },
                { data: 'is_read',               name: 'is_read',              orderable: false, searchable: false },
                { data: 'created_at',            name: 'created_at',           orderable: false, searchable: false },
                { data: 'actions',               name: 'actions',              orderable: false, searchable: false },
            ];

            showDataTableWithFilters("{{ $dataTableRoute }}", columns, function () {
                return {
                    is_read:   $('#filter-is-read').val(),
                    date_from: $('#filter-date-from').val(),
                    date_to:   $('#filter-date-to').val(),
                };
            });

            $('#btn-filter').on('click', function () { window.reloadDataTable(); });

            $('#btn-reset-filter').on('click', function () {
                $('#filter-is-read, #filter-date-from, #filter-date-to').val('');
                window.reloadDataTable();
            });

            $(document).on('click', '.toggle-read-btn', function (e) {
                e.preventDefault();
                var btn = $(this);
                var id = btn.data('id');
                $.ajax({
                    url: '/dashboard/consultation-requests/' + id + '/toggle-read',
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (response) {
                        if (response.code === 200) {
                            if (response.is_read) {
                                btn.removeClass('btn-danger').addClass('btn-success').text("{{ __('auth.read') }}");
                            } else {
                                btn.removeClass('btn-success').addClass('btn-danger').text("{{ __('auth.unread') }}");
                            }
                            var badge = $('.pc-sidebar .badge.bg-danger.rounded-pill');
                            if (badge.length) {
                                if (response.unread_count > 0) {
                                    badge.text(response.unread_count);
                                } else {
                                    badge.remove();
                                }
                            } else if (response.unread_count > 0) {
                                $('.pc-sidebar .pc-item a[href*="consultation-requests"]').find('.pc-mtext').append(' <span class="badge bg-danger rounded-pill ms-1" style="font-size:10px;">' + response.unread_count + '</span>');
                            }
                        }
                    }
                });
            });
        });

        function showConsultation(id) {
            $('#consultationModalBody').html('<div class="text-center py-4"><div class="spinner-border text-primary"></div></div>');
            $('#consultationModal').modal('show');

            $.ajax({
                url: '/dashboard/consultation-requests/' + id,
                type: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (response) {
                    if (response.code === 200) {
                        $('#consultationModalBody').html(response.data.html);
                        window.reloadDataTable();
                    }
                },
                error: function () {
                    $('#consultationModalBody').html('<p class="text-danger text-center">{{ __('auth.an error occurred') }}</p>');
                }
            });
        }
    </script>
@endsection
