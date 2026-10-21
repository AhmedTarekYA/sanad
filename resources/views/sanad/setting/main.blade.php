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
    {{ $bladeTitle }}
@endsection
@section('page-links')
    <li class="breadcrumb-item active" aria-current="page"> {{ $bladeTitle }}</li>
@endsection
@section('content')

    {{-- {!! addButton(route("settings.create") , __('skaeeb.settings')) !!} --}}
    @php
      $submitRoute = isset($main_settings) ? route('main-settings.update', $main_settings->id) : route('main-settings.store') ;
    @endphp
    <form class="row g-3 from-submit-global" method="post"
          action="{{ $submitRoute }}"
          enctype="multipart/form-data">
        @if(isset($main_settings))
            @method('PUT')
        @endif

        @foreach (config('translatable.locales') as $locale)
            <div class="col-6">
                <label for="TextInput"
                       class="form-label">{{ trans('auth.sidebar_text') }} {{ getFieldLanguage($locale) }}</label>
                <fieldset class="form-icon-group right-icon position-relative">
                    <div class="form-icon position-absolute">
                        <i class="fa fa-sidebar "></i>
                    </div>
                    <input type="text" name="{{ $locale }}[sidebar_text]"
                           value="{{ isset($main_settings) && $main_settings ? optional($main_settings->translate($locale))->sidebar_text : '' }}"
                           class="form-control">
                </fieldset>
            </div>
        @endforeach


        @foreach (config('translatable.locales') as $locale)
            <div class="col-6">
                <label for="TextInput"
                       class="form-label">{{ trans('auth.copyright_text') }} {{ getFieldLanguage($locale) }}</label>
                <fieldset class="form-icon-group right-icon position-relative">
                    <div class="form-icon position-absolute">
                        <i class="fa fa-copyright"></i>
                    </div>
                    <input type="text" name="{{ $locale }}[copyright_text]"
                           value="{{ isset($main_settings) && $main_settings->translate($locale) ? $main_settings->translate($locale)->copyright_text : '' }}"
                           class="form-control">
                </fieldset>
            </div>
        @endforeach

         @foreach (config('translatable.locales') as $locale)
            <div class="col-6">
                <label for="TextInput"
                       class="form-label">{{ trans('auth.company_name') }} {{ getFieldLanguage($locale) }}</label>
                <fieldset class="form-icon-group right-icon position-relative">
                    <div class="form-icon position-absolute">
                        <i class="fa fa-copyright"></i>
                    </div>
                    <input type="text" name="{{ $locale }}[company_name]"
                           value="{{ isset($main_settings) && $main_settings->translate($locale) ? $main_settings->translate($locale)->company_name : '' }}"
                           class="form-control">
                </fieldset>
            </div>
        @endforeach

        <div class="col-6">
            <label for="TextInput" class="form-label">{{ trans('auth.link') }} </label>
            <fieldset class="form-icon-group right-icon position-relative">
                <div class="form-icon position-absolute">
                    <i class="fa fa-link"></i>
                </div>
                <input type="text" name="link" class="form-control"
                        value="{{ isset($main_settings) ? $main_settings->link : '' }}">
            </fieldset>
        </div>


        <div class="col-6">
            <label for="TextInput" class="form-label">{{ trans('auth.loading_background_color') }} </label>
            <fieldset class="form-icon-group right-icon position-relative">
                <div class="form-icon position-absolute">
                    <i class="fa fa-image"></i>
                </div>
                <input type="color" name="loading_background_color" class="form-control"
                        value="{{ isset($main_settings) ? $main_settings->loading_background_color : '' }}">
            </fieldset>
        </div>

        <div class="col-6">
            <label for="TextInput" class="form-label">{{ trans('auth.copyright_link') }} </label>
            <fieldset class="form-icon-group right-icon position-relative">
                <div class="form-icon position-absolute">
                    <i class="fa fa-image"></i>
                </div>
                <input type="text" name="copyright_link" class="form-control"
                       value="{{ isset($main_settings) ? $main_settings->copyright_link : '' }}">
            </fieldset>
        </div>
        <div class="col-6">
            <label for="TextInput" class="form-label">{{ trans('auth.footer_logo') }} </label>
            <fieldset class="form-icon-group right-icon position-relative">
                <div class="form-icon position-absolute">
                    <i class="fa fa-image"></i>
                </div>
                <input type="file" name="footer_logo"  data-default-file="{{ isset($main_settings) ? showFile($main_settings->footer_logo) : '' }}"
                       class="dropify">
            </fieldset>
        </div>



        <div class="col-12 modal-footer">
            {!! submitButton( $submitRoute ) !!}
        </div>

    </form>

@endsection


@section('js')
    <script src="{{asset('admin')}}/assets/js/tinymce.min.js"></script>
    <script>
        $(document).ready(function () {
            tinymce.init({
                selector: '.mytextarea',
                plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            });
        });
    </script>
    {{-- <script src="{{asset("admin")}}/assets/js/bundle/summernote.bundle.js"></script>
    <script>
        $(document).ready(function () {
            $('.summernote').summernote();
        });
    </script> --}}
@endsection
