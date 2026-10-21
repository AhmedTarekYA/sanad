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

    <table id="dataTableObject" class="table display dataTable table-hover" style="width:100%">
        <thead>
            <tr>
                <th>{{ __('auth.SL') }}</th>
                <th>{{ __('auth.image') }}</th>
                <th>{{ __('auth.title') }}</th>
                <th>{{ __('auth.slug') }}</th>
                <th>{{ __('auth.actions') }}</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
@endsection

@section('js')
    <script src="{{ asset('admin') }}/assets/js/bundle/dataTables.bundle.js"></script>
    @include('sanad.layout.inc._js_buttons')
    <script>
        $(document).ready(function () {
            let columns = [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'image',       name: 'image',       orderable: false, searchable: false },
                { data: 'title',       name: 'title',       orderable: false, searchable: false },
                { data: 'slug',        name: 'slug',        orderable: false, searchable: true },
                { data: 'actions',     name: 'actions',     orderable: false, searchable: false },
            ];
            showDataTable("{{ $dataTableRoute }}", columns);
        });
    </script>
@endsection
