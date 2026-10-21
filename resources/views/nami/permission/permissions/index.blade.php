@extends('nami.layout.indexs.index')
@section("style")
    <link rel="stylesheet" href="{{asset("admin")}}/assets/cssbundle/dataTables.min.css">
@endsection
@section('page-title')
    {{ $bladeTitle }}
@endsection
@section('content')
    @if (auth('admin')->user()->admin_type == \App\Enums\AdminTypeisEnum::Developer->value)
        {!! addButton($createRoute , __('permission.permissions')) !!}
    @endif
    <table id="dataTableObject" class="table display dataTable table-hover" style="width:100%">
        <thead>
        <tr>
            <th>#</th>
            <th>{{__('permission.description')}}</th>
            <th>{{__('permission.description_ar')}}</th>
            <th>{{__('permission.actions')}}</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>


@endsection
@section('js')
    <script src="{{asset("admin")}}/assets/js/bundle/dataTables.bundle.js"></script>
       @include('nami.layout.inc._js_buttons')
    <script>
        $(document).ready(function () {
            let columns = [
                {"data": 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {"data": "description", orderable: true, searchable: true},
                {"data": "description_ar", orderable: true, searchable: true},
                {"data": "actions", orderable: false, searchable: false}
            ];
            showDataTable("{{$dataTableRoute}}", columns);
        });
    </script>
@endsection
