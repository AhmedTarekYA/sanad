@extends('nami.layout.indexs.index')
@section("style")
    <link rel="stylesheet" href="{{asset("admin")}}/assets/cssbundle/dataTables.min.css">
@endsection
@section('page-title')
    {{ $bladeTitle }}
@endsection

@section('content')
        <div class="card-header">
            <h4 class="card-title">
            </h4>
            {{--            @can('اضافة صلاحية')--}}
            {{--                {!! addButton(__('admin.role')) !!}--}}
            <div class="justify-content-end">
                <a href="{{route('roles.create')}}" class="btn btn-rounded btn-outline-info"
                   title="{{__('permission.role')}}">
                    <span class="btn-icon-start text-info"><i
                            class="fa fa-plus color-info"></i></span>{{__('permission.add role')}}
                </a>
            </div>
            {{--            @endcan--}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTableObject" class="table display dataTable table-hover" style="width:100%">
                    <thead>
                    <tr>
                        <th></th>
                        <th>{{__('permission.name')}}</th>
                        <th>{{__('permission.display_name')}}</th>
                        <th>{{__('permission.description')}}</th>
                        <th>{{__('permission.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

@endsection
@section('js')
    <script src="{{asset("admin")}}/assets/js/bundle/dataTables.bundle.js"></script>
    @include('nami.layout.inc._js_buttons')
    <script>
        $(document).ready(function () {
            var columns = [
                {"data": 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name',orderable: false,searchable: true},
                {data: 'display_name', name: 'display_name',orderable: false,searchable: true},
                {data: 'description', name: 'description',orderable: false,searchable: true},
                {data: 'actions', name: 'actions',orderable: false,searchable: false},
            ];
            showDataTable("{{route("roles.index")}}", columns);
        });
    </script>
@endsection

