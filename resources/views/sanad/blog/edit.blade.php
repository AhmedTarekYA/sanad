<form class="from-submit-update-global" method="POST" action="{{ $updateRoute }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-3 p-1">

        {{-- Image --}}
        <div class="col-12">
            <label class="form-label fw-semibold">{{ __('auth.image') }}</label>
            <input type="file" name="image" class="dropify" accept="image/*"
                   data-default-file="{{ showFile($obj->image) }}"
                   data-max-file-size="20M" data-allowed-file-extensions="jpg jpeg png gif webp">
        </div>

        {{-- Language Tabs --}}
        <div class="col-12">
            <ul class="nav nav-tabs" id="blogEditTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" type="button" data-bs-toggle="tab"
                            data-bs-target="#blog-edit-ar" role="tab">
                        {{ __('auth.arabic') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" type="button" data-bs-toggle="tab"
                            data-bs-target="#blog-edit-en" role="tab">
                        {{ __('auth.english') }}
                    </button>
                </li>
            </ul>
            <div class="tab-content border border-top-0 rounded-bottom p-3">

                {{-- Arabic Tab --}}
                <div class="tab-pane fade show active" id="blog-edit-ar" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                {{ __('auth.title') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="ar[title]" id="be-ar-title"
                                   class="form-control"
                                   value="{{ $obj->translate('ar')?->title }}"
                                   data-validation="required">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('auth.description') }}</label>
                            <textarea name="ar[description]" class="form-control" rows="3">{{ $obj->translate('ar')?->description }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold d-flex align-items-center gap-2">
                                {{ __('auth.slug') }} <span class="text-danger">*</span>
                                <button type="button" id="be-ar-slug-reset"
                                        class="btn btn-sm btn-outline-secondary py-0 px-2 ms-auto"
                                        title="{{ __('auth.slug_reset') }}">
                                    <i class="ti ti-refresh"></i>
                                </button>
                            </label>
                            <input type="text" name="ar[slug]" id="be-ar-slug"
                                   class="form-control font-monospace"
                                   value="{{ $obj->translate('ar')?->slug }}"
                                   data-validation="required">
                            <small class="text-muted">{{ __('auth.slug_hint') }}</small>
                        </div>
                    </div>
                </div>

                {{-- English Tab --}}
                <div class="tab-pane fade" id="blog-edit-en" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('auth.title') }}</label>
                            <input type="text" name="en[title]" id="be-en-title"
                                   class="form-control" dir="ltr"
                                   value="{{ $obj->translate('en')?->title }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('auth.description') }}</label>
                            <textarea name="en[description]" class="form-control" rows="3" dir="ltr">{{ $obj->translate('en')?->description }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold d-flex align-items-center gap-2">
                                {{ __('auth.slug') }}
                                <button type="button" id="be-en-slug-reset"
                                        class="btn btn-sm btn-outline-secondary py-0 px-2 ms-auto"
                                        title="{{ __('auth.slug_reset') }}">
                                    <i class="ti ti-refresh"></i>
                                </button>
                            </label>
                            <input type="text" name="en[slug]" id="be-en-slug"
                                   class="form-control font-monospace" dir="ltr"
                                   value="{{ $obj->translate('en')?->slug }}">
                            <small class="text-muted">{{ __('auth.slug_hint') }}</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Featured --}}
        <div class="col-12">
            <div class="card border-warning">
                <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between gap-3">
                    <div>
                        <div class="fw-semibold">{{ __('auth.featured') }}</div>
                        <small class="text-muted">{{ __('auth.featured_note') }}</small>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" role="switch"
                               name="is_featured" id="be-is-featured" value="1"
                               {{ $obj->is_featured ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal-footer mt-2">
        <button class="btn btn-primary" type="submit">{{ __('buttons.save') }}</button>
        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">{{ __('buttons.close') }}</button>
    </div>
</form>

<script>
(function () {
    function slugify(text) {
        return text.trim()
            .replace(/\s+/g, '-')
            .replace(/[^؀-ۿa-zA-Z0-9\-]/g, '')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '')
            .toLowerCase();
    }

    $('#be-ar-slug-reset').on('click', function () {
        $('#be-ar-slug').val(slugify($('#be-ar-title').val()));
    });

    $('#be-en-slug-reset').on('click', function () {
        $('#be-en-slug').val(slugify($('#be-en-title').val()));
    });
})();
</script>
