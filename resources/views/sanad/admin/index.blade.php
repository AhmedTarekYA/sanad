@extends('sanad.layout.indexs.index')
@section("style")
    <link rel="stylesheet" href="{{asset("admin")}}/assets/cssbundle/dataTables.min.css">
    <style>.admin-table-avatar{width:38px;height:38px;border-radius:50%;object-fit:cover;border:2px solid rgba(45,113,240,.15)}</style>
@endsection
@section('page-title')
    {{__("auth.users")}}
@endsection
@section('page-links')
    <li class="breadcrumb-item active" aria-current="page"> {{ __('auth.users') }}</li>
@endsection
@section('content')
    {!! addButton(route("admins.create") , __("auth.admin")) !!}
    <table id="dataTableObject" class="table display dataTable table-hover" style="width:100%">
        <thead>
        <tr>
            <th>{{ __('auth.SL') }}</th>
            <th>{{__("auth.image")}}</th>
            <th>{{__("auth.name")}}</th>
            <th>{{__("auth.phone")}}</th>
            <th>{{__("auth.email")}}</th>
            <th>{{__("auth.actions")}}</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>


@endsection
@section('js')
    <script src="{{asset("admin")}}/assets/js/bundle/dataTables.bundle.js"></script>
    <script>
        $(document).ready(function () {
            let columns = [
                {"data": 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {"data": "image", orderable: false, searchable: false},
                {"data": "name", orderable: false, searchable: false},
                {"data": "phone", orderable: false, searchable: false},
                {"data": "email", orderable: false, searchable: false},
                {"data": "actions", orderable: false, searchable: false}
            ];
            showDataTable("{{ $dataTableRoute }}", columns);
        });
    </script>
    <script>
        $(document).ajaxComplete(function() {
            $('#admin_type').change(function() {
                var adminType = $(this).val();

                if (adminType == 'department_manger') {
                    $('#department_div').show();
                    $('#employee_div').show();
                } else if (adminType == 'hr_employee' || adminType == 'employee') {
                    $('#department_div').hide();
                    $('#employee_div').show();
                } else {
                    $('#department_div').hide();
                    $('#employee_div').hide();
                }
            });
        });
    </script>
    <script>
        $(document).ajaxComplete(function () {
            $('.all').click(function () {
                $(this).closest('div').find('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
            });
        });
    </script>
@endsection
