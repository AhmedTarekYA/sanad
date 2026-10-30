@extends('sanad.layout.indexs.index')
@section("style")

    {{-- <link rel="stylesheet" href="{{asset("admin")}}/assets/cssbundle/summernote.min.css"/> --}}
    <style>
        .tox-notification,
        .tox .tox-statusbar {
            display: none !important;
        }

        .settings-page {
            max-width: 1440px;
            margin: 0 auto;
        }
        .settings-page .settings-form {
            padding: clamp(1rem, 2vw, 2rem);
            border: 1px solid #e5ebf2;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(31, 41, 55, .06);
        }
        .settings-page .settings-form > .col-3,
        .settings-page .settings-form > .col-4,
        .settings-page .settings-form > .col-6,
        .settings-page .settings-form > .col-12 {
            padding: .8rem;
        }
        .settings-page .settings-form > hr {
            width: calc(100% - 1rem);
            margin: .75rem auto;
            border-color: #e5ebf2;
            opacity: 1;
        }
        .settings-page .form-label {
            display: flex;
            min-height: 25px;
            align-items: center;
            justify-content: space-between;
            gap: .5rem;
            color: #26364d;
            font-size: .84rem;
            font-weight: 600;
        }
        .settings-page .form-icon-group { margin-top: .45rem; }
        .settings-page .form-icon-group .form-icon {
            inset-block-start: 50%;
            inset-inline-end: 0;
            transform: translateY(-50%);
            width: 40px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6a7c93;
            font-size: 1.1rem !important;
            z-index: 2;
            pointer-events: none;
        }
        .settings-page .form-icon-group .form-icon .ti {
            display: inline-block;
            font-size: 1.1rem !important;
            line-height: 1;
        }
        .settings-page .form-icon-group .form-control {
            min-height: 44px;
            padding-inline-end: 2.75rem;
            border-color: #dce5ee;
            border-radius: 10px;
            background: #f9fbfd;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }
        .settings-page .form-icon-group .form-control:focus,
        .settings-page textarea.form-control:focus,
        .settings-page select.form-select:focus {
            border-color: #0da9e9;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(13, 169, 233, .13);
        }
        .settings-page textarea.form-control {
            min-height: 150px;
            border-color: #dce5ee;
            border-radius: 10px;
            background: #f9fbfd;
            resize: vertical;
        }
        .settings-page .settings-upload-card {
            height: 100%;
            border: 1px solid #e1e8f0;
            border-radius: 14px;
            background: #f9fbfd;
            overflow: hidden;
        }
        .settings-page .settings-upload-card .card-body { padding: 1rem; }
        .settings-page .settings-upload-card h6 {
            display: flex;
            align-items: center;
            gap: .45rem;
            margin-bottom: .75rem;
            color: #26364d;
            font-weight: 700;
        }
        .settings-page .settings-upload-card h6 .ti {
            color: #0da9e9;
            font-size: 1.15rem;
        }
        .settings-page .dropify-wrapper {
            min-height: 150px;
            border: 1px dashed #b9c9d9;
            border-radius: 10px;
            background: #fff;
        }
        .settings-page .dropify-wrapper:hover { border-color: #0da9e9; }
        .settings-page .settings-save-row {
            display: flex;
            justify-content: flex-end;
            padding-top: 1.25rem !important;
        }
        .settings-page .settings-save-row .btn {
            min-width: 145px;
            min-height: 44px;
            border-radius: 10px;
            font-weight: 700;
        }

        body[data-pc-theme="dark"] .settings-page .settings-form {
            border-color: #334354;
            background: #1b2633;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
        }
        body[data-pc-theme="dark"] .settings-page .settings-form > hr { border-color: #334354; }
        body[data-pc-theme="dark"] .settings-page .form-label,
        body[data-pc-theme="dark"] .settings-page .settings-upload-card h6 { color: #e5edf6; }
        body[data-pc-theme="dark"] .settings-page .form-icon-group .form-icon { color: #9db4cc; }
        body[data-pc-theme="dark"] .settings-page .form-icon-group .form-control,
        body[data-pc-theme="dark"] .settings-page textarea.form-control,
        body[data-pc-theme="dark"] .settings-page select.form-select {
            border-color: #3a4c60;
            background: #202d3b;
            color: #e5edf6;
        }
        body[data-pc-theme="dark"] .settings-page .form-icon-group .form-control:focus,
        body[data-pc-theme="dark"] .settings-page textarea.form-control:focus,
        body[data-pc-theme="dark"] .settings-page select.form-select:focus {
            background: #243445;
        }
        body[data-pc-theme="dark"] .settings-page .settings-upload-card {
            border-color: #3a4c60;
            background: #202d3b;
        }
        body[data-pc-theme="dark"] .settings-page .dropify-wrapper {
            border-color: #50677e;
            background: #263646 !important;
        }
        body[data-pc-theme="dark"] .settings-page .dropify-wrapper .dropify-message,
        body[data-pc-theme="dark"] .settings-page .dropify-wrapper .dropify-message p,
        body[data-pc-theme="dark"] .settings-page .dropify-wrapper .file-icon::before {
            color: #a9bdd1;
        }
        @media (max-width: 767.98px) {
            .settings-page .settings-form { padding: .65rem; border-radius: 14px; }
            .settings-page .settings-form > .col-3,
            .settings-page .settings-form > .col-4,
            .settings-page .settings-form > .col-6 { padding: .55rem; }
        }
    </style>
@endsection
@section('page-title')
    {{__('auth.settings')}}
@endsection
@section('page-links')
    <li class="breadcrumb-item active" aria-current="page"> {{ __('auth.settings') }}</li>
@endsection
@section('content')

<div class="settings-page">

    @if (auth('admin')->user()->admin_type == \App\Enums\AdminTypeisEnum::Developer->value)
        <button type="button" class="btn btn-success mb-3 px-3 py-2" id="translate-all">
            <i class="ti ti-language me-1" aria-hidden="true"></i>
            {{ __('auth.change language') }}
        </button>
    @endif

    {{-- {!! addButton(route("settings.create") , __('skaeeb.settings')) !!} --}}
    <form class="row g-3 from-submit-global settings-form" method="post"
          action="{{ isset($settings) ? route('settings.update', $settings->id) : route('settings.store') }}"
          enctype="multipart/form-data">
        @if(isset($settings))
            @method('PUT')
        @endif

        @foreach (config('translatable.locales') as $locale)
            <div class="col-3 translation-group">
                <label for="TextInput" class="form-label">{{ __("auth.website_name")}} {{ getFieldLanguage($locale) }}</label>
                <fieldset class="form-icon-group right-icon position-relative">
                <div class="form-icon position-absolute">
                        <i class="ti ti-world" aria-hidden="true"></i>
                    </div>
                    <input type="text" name="{{ $locale }}[website_name]"
                        value="{{ isset($settings) && $settings ? optional($settings->translate($locale))->website_name : '' }}"
                        class="form-control translate-input">
                </fieldset>
            </div>
        @endforeach


        @foreach (config('translatable.locales') as $locale)
            <div class="col-3 translation-group">
                <label for="TextInput" class="form-label">{{ __("auth.address")}} {{ getFieldLanguage($locale) }}</label>
                <fieldset class="form-icon-group right-icon position-relative">
                    <div class="form-icon position-absolute">
                        <i class="ti ti-map-pin" aria-hidden="true"></i>
                    </div>
                    <input type="text" name="{{ $locale }}[location]"
                        value="{{ isset($settings) && $settings->translate($locale) ? $settings->translate($locale)->location : '' }}"
                        class="form-control translate-input">
                </fieldset>
            </div>
        @endforeach

        <hr>
        <div class="col-4">
            <label for="TextInput" class="form-label">{{__('auth.email')}}</label>
            <fieldset class="form-icon-group right-icon position-relative">
                <div class="form-icon position-absolute">
                    <i class="ti ti-mail" aria-hidden="true"></i>
                </div>
                <input type="email" name="email" class="form-control"
                       value="{{ isset($settings) ? optional($settings)->email : '' }}">
            </fieldset>
        </div>

        <div class="col-4">
            <label for="TextInput" class="form-label">{{__('auth.phone')}}</label>

            <fieldset class="form-icon-group right-icon position-relative">
                <div class="form-icon position-absolute">
                    <i class="ti ti-device-mobile" aria-hidden="true"></i>
                </div>
                <input type="tel" name="phone" class="form-control" placeholder="01012345678" inputmode="tel"
                       value="{{ isset($settings) ? $settings->phone : '' }}">
            </fieldset>
        </div>

        <div class="col-4">
            <label for="TextInput" class="form-label">{{__('auth.other_phone')}}</label>
            <fieldset class="form-icon-group right-icon position-relative">
                <div class="form-icon position-absolute">
                    <i class="ti ti-phone" aria-hidden="true"></i>
                </div>
                <input type="tel" name="other_phone" class="form-control" placeholder="01012345678" inputmode="tel"
                       value="{{ isset($settings) ? $settings->other_phone : '' }}">
            </fieldset>
        </div>

        <hr>
        <div class="col-3">
            <label for="TextInput" class="form-label">{{__('auth.twitter_link')}}</label>

            <fieldset class="form-icon-group right-icon position-relative">
                <div class="form-icon position-absolute">
                    <i class="ti ti-brand-twitter" aria-hidden="true"></i>
                </div>
                <input type="text" name="twitter" class="form-control"
                       value="{{ isset($settings) ? $settings->twitter : '' }}">
            </fieldset>

        </div>

        <div class="col-3">
            <label for="TextInput" class="form-label">{{__('auth.facebook_link')}}</label>

            <fieldset class="form-icon-group right-icon position-relative">
                <div class="form-icon position-absolute">
                    <i class="ti ti-brand-facebook" aria-hidden="true"></i>
                </div>
                <input type="text" name="facebook" class="form-control"
                       value="{{ isset($settings) ? $settings->facebook : '' }}">
            </fieldset>

        </div>

        <div class="col-3">
            <label for="TextInput" class="form-label">{{__('auth.instgram_link')}}</label>
            <fieldset class="form-icon-group right-icon position-relative">
                <div class="form-icon position-absolute">
                    <i class="ti ti-brand-instagram" aria-hidden="true"></i>
                </div>
                <input type="text" name="instagram" class="form-control"
                       value="{{ isset($settings) ? $settings->instagram : '' }}">
            </fieldset>
        </div>

        <div class="col-3">
            <label for="TextInput" class="form-label">{{__('auth.snapchat_link')}}</label>
            <fieldset class="form-icon-group right-icon position-relative">
                <div class="form-icon position-absolute">
                    <i class="ti ti-brand-snapchat" aria-hidden="true"></i>
                </div>
                <input type="text" name="snapchat" class="form-control"
                       value="{{ isset($settings) ? $settings->snapchat : '' }}">
            </fieldset>
        </div>


        <div class="col-3">
            <label for="TextInput" class="form-label">{{__('auth.linkedin_link')}}</label>
            <fieldset class="form-icon-group right-icon position-relative">
                <div class="form-icon position-absolute">
                    <i class="ti ti-brand-linkedin" aria-hidden="true"></i>
                </div>
                <input type="text" name="linkedin" class="form-control"
                       value="{{ isset($settings) ? $settings->linkedin : '' }}">
            </fieldset>

        </div>
        <div class="col-3">
            <label for="TextInput" class="form-label">{{__('auth.youtube_link')}}</label>
            <fieldset class="form-icon-group right-icon position-relative">
                <div class="form-icon position-absolute">
                    <i class="ti ti-brand-youtube" aria-hidden="true"></i>
                </div>
                <input type="text" name="youtube" class="form-control"
                       value="{{ isset($settings) ? $settings->youtube : '' }}">
            </fieldset>
        </div>
        <div class="col-3">
            <label for="TextInput" class="form-label">{{__('auth.whatsapp_link')}}</label>
            <fieldset class="form-icon-group right-icon position-relative">
                <div class="form-icon position-absolute">
                    <i class="ti ti-brand-whatsapp" aria-hidden="true"></i>
                </div>
                <input type="text" name="whatsapp" class="form-control"
                       value="{{ isset($settings) ? $settings->whatsapp : '' }}">
            </fieldset>
        </div>
        <div class="col-3">
            <label for="TextInput" class="form-label">{{__('tiktok_link')}}</label>
            <fieldset class="form-icon-group right-icon position-relative">
                <div class="form-icon position-absolute">
                    <i class="ti ti-brand-tiktok" aria-hidden="true"></i>
                </div>
                <input type="text" name="tiktok" class="form-control"
                       value="{{ isset($settings) ? $settings->tiktok : '' }}">
            </fieldset>
        </div>

        <hr>

        @foreach (config('translatable.locales') as $locale)
            <div class="col-6 translation-group">
                <label for="TextInput" class="form-label">{{ __('auth.copyright') }} {{ getFieldLanguage($locale) }} </label>
                <fieldset class="form-icon-group right-icon position-relative">
                    <div class="form-icon position-absolute">
                        <i class="ti ti-copyright" aria-hidden="true"></i>
                    </div>
                    <input type="text" name="{{ $locale }}[copyright]" class="form-control translate-input"
                           value="{{ isset($settings) && $settings->translate($locale) ?  $settings->translate($locale)->copyright : '' }}">
                </fieldset>
            </div>
        @endforeach

        <hr>
        <div class="col-4">
            <div class="col-12">
                <div class="card settings-upload-card">
                    <div class="card-body">
                        <h6><i class="ti ti-photo" aria-hidden="true"></i>{{__('auth.logo_header')}}</h6>
                        <input type="file"
                               data-default-file="{{ isset($settings) ? showFile($settings->logo_header): '' }}"
                               name="logo_header" class="dropify">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="col-12">
                <div class="card settings-upload-card">
                    <div class="card-body">
                        <h6><i class="ti ti-photo" aria-hidden="true"></i>{{__('auth.logo_footer')}}</h6>
                        <input type="file"
                               data-default-file="{{ isset($settings) ? showFile($settings->logo_footer): '' }}"
                               name="logo_footer" class="dropify">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="col-12">
                <div class="card settings-upload-card">
                    <div class="card-body">
                        <h6><i class="ti ti-photo" aria-hidden="true"></i>{{__('auth.favicon')}}</h6>
                        <input type="file" data-default-file="{{ isset($settings) ? showFile($settings->favicon): '' }}"
                               name="favicon" class="dropify">
                    </div>
                </div>
            </div>
        </div>
        <hr>


        @foreach (config('translatable.locales') as $locale)
            <div class="col-6 translation-group">
                <label for="TextInput" class="form-label">{{__('auth.footer_text')}} {{ getFieldLanguage($locale) }}</label>
                <textarea class="form-control translate-input mytextarea" rows="10"
                        name="{{ $locale }}[footer_text]">{{ isset($settings) && $settings->translate($locale) ? $settings->translate($locale)->footer_text : '' }}</textarea>
            </div>
        @endforeach

        {{-- @foreach (config('translatable.locales') as $locale)
            <div class="col-6 translation-group">
                <label for="TextInput" class="form-label">{{ __('auth.privacy_policy')}} {{ getFieldLanguage($locale) }}</label>
                <textarea class="mytextarea " rows="10"
                          name="{{ $locale }}[privacy]">{{ isset($settings) && $settings->translate($locale) ? $settings->translate($locale)->privacy : '' }}</textarea>
            </div>
        @endforeach --}}

        <div class="col-12 modal-footer settings-save-row">
            <button class="btn btn-primary" type="submit"><i class="ti ti-device-floppy me-1" aria-hidden="true"></i>{{__("buttons.save")}}</button>
        </div>

    </form>
</div>

@endsection


@section('js')
    <script src="{{asset('admin')}}/assets/js/tinymce.min.js"></script>
    <script>
        $(function () {
            // Dropify is also needed on the initial settings page, not only in Ajax modals.
            if (typeof $.fn.dropify === 'function') {
                $('.settings-page .dropify').each(function () {
                    if (!$(this).closest('.dropify-wrapper').length) {
                        $(this).dropify({
                            messages: {
                                default: @json(__('auth.default')),
                                replace: @json(__('auth.replace')),
                                remove: @json(__('auth.remove')),
                                error: @json(__('auth.error'))
                            }
                        });
                    }
                });
            }
        });

        $(document).ready(function () {
            if (window.tinymce && document.querySelector('.settings-page .mytextarea')) {
                tinymce.remove('.settings-page .mytextarea');
                tinymce.init({
                    selector: '.settings-page .mytextarea',
                    menubar: false,
                    branding: false,
                    promotion: false,
                    height: 260,
                    toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | removeformat',
                    directionality: document.documentElement.dir === 'rtl' ? 'rtl' : 'ltr',
                    content_style: document.body.getAttribute('data-pc-theme') === 'dark'
                        ? 'body { background: #202d3b; color: #e5edf6; padding: 12px; }'
                        : 'body { padding: 12px; }',
                });
            }
        });
    </script>
    {{-- <script src="{{asset("admin")}}/assets/js/bundle/summernote.bundle.js"></script>
    <script>
        $(document).ready(function () {
            $('.summernote').summernote();
        });
    </script> --}}
@endsection
