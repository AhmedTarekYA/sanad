<form class="from-submit-update-global" method="POST" action="{{ $updateRoute }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-3 p-1">

        {{-- Image --}}
        <div class="col-12">
            <label class="form-label fw-semibold">{{ __('auth.image') }}</label>
            <input type="file" name="image" class="dropify" accept="image/*"
                   data-default-file="{{ showFile($obj->image) }}">
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
                    </div>
                </div>
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
                    </div>
                </div>
            </div>
        </div>

        {{-- Slug --}}
        <div class="col-12">
            <label class="form-label fw-semibold d-flex align-items-center gap-2">
                {{ __('auth.slug') }} <span class="text-danger">*</span>
                <button type="button" id="be-slug-reset"
                        class="btn btn-sm btn-outline-secondary py-0 px-2 ms-auto"
                        title="{{ __('auth.slug_reset') ?? 'إعادة توليد' }}">
                    <i class="ti ti-refresh"></i>
                </button>
            </label>
            <input type="text" name="slug" id="be-slug"
                   class="form-control font-monospace" dir="ltr"
                   value="{{ $obj->slug }}" data-validation="required">
            <small class="text-muted">{{ __('auth.slug_hint') ?? 'يمكنك تعديل الرابط المختصر — اضغط الرمز لإعادة التوليد' }}</small>
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

    function updateSlug() {
        var en = $('#be-en-title').val().trim();
        var ar = $('#be-ar-title').val().trim();
        var source = en || ar;
        if (source) {
            $('#be-slug').val(slugify(source));
        }
    }

    $('#be-slug-reset').on('click', function () {
        updateSlug();
    });
})();
</script>
