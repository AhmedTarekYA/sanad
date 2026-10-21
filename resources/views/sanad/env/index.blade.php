@extends('sanad.layout.indexs.dev_index')
@section("style")

    {{-- <link rel="stylesheet" href="{{asset("admin")}}/assets/cssbundle/summernote.min.css"/> --}}
    <style>
        .tox-notification,
        .tox .tox-statusbar {
            display: none !important;
        }
    </style>
@endsection
@section('page-title')
    {{__('auth.settings_developer')}}
@endsection
@section('page-links')
    <li class="breadcrumb-item active" aria-current="page"> {{ __('auth.settings_developer') }}</li>
@endsection
@section('content')

    {!! addButton(route('env.create'),__("buttons.key")) !!}
    <form class="row g-3 from-submit-global" method="post"
          action="{{ route('env.update',1) }}" enctype="multipart/form-data">
        @method('PUT')

        @foreach($envs as $key => $env)
            <div class="col-6">
                <div class="row">
                    <div class="col-10">
                        <label for="TextInput" class="form-label"> {{ $key }}</label>
                        <input type="text" name="{{$key}}" class="form-control"
                               value="{{ $env }}">
                    </div>
                    <div class="col-2 mt-4">
                            {!! deleteButton(route('env.destroy',[1,'key'=>$key])) !!}
                    </div>
                </div>

            </div>
        @endforeach


        <div class="col-12 modal-footer">
            <button class="btn btn-primary" type="submit">{{__("buttons.save")}}</button>
        </div>

    </form>

@endsection


@section('js')
    <script src="{{asset('admin')}}/assets/js/tinymce.min.js"></script>
    {{-- <script src="{{asset("admin")}}/assets/js/bundle/summernote.bundle.js"></script>
    <script>
        $(document).ready(function () {
            $('.summernote').summernote();
        });
    </script> --}}
@endsection
