<form class="from-submit-global" method="POST" action="{{ $storeRoute }}" enctype="multipart/form-data">
    @csrf

    <div class="row g-3 p-1">

        {{-- Image --}}
        <div class="col-12">
            <label class="form-label fw-semibold">{{ __('auth.image') }}</label>
            <input type="file" name="image" class="dropify" accept="image/*"
               data-max-file-size="20M" data-allowed-file-extensions="jpg jpeg png gif webp">
        </div>

        {{-- Language Tabs --}}
        <div class="col-12">
            <ul class="nav nav-tabs" id="blogCreateTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" type="button" data-bs-toggle="tab"
                            data-bs-target="#blog-create-ar" role="tab">
                        {{ __('auth.arabic') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" type="button" data-bs-toggle="tab"
                            data-bs-target="#blog-create-en" role="tab">
                        {{ __('auth.english') }}
                    </button>
                </li>
            </ul>
            <div class="tab-content border border-top-0 rounded-bottom p-3">
                <div class="tab-pane fade show active" id="blog-create-ar" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                {{ __('auth.title') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="ar[title]" id="bc-ar-title"
                                   class="form-control" data-validation="required">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('auth.description') }}</label>
                            <textarea name="ar[description]" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="blog-create-en" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('auth.title') }}</label>
                            <input type="text" name="en[title]" id="bc-en-title"
                                   class="form-control" dir="ltr">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('auth.description') }}</label>
                            <textarea name="en[description]" class="form-control" rows="3" dir="ltr"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Slug --}}
        <div class="col-12">
            <label class="form-label fw-semibold d-flex align-items-center gap-2">
                {{ __('auth.slug') }} <span class="text-danger">*</span>
                <button type="button" id="bc-slug-reset"
                        class="btn btn-sm btn-outline-secondary py-0 px-2 ms-auto"
                        title="{{ __('auth.slug_reset') ?? 'إعادة توليد' }}">
                    <i class="ti ti-refresh"></i>
                </button>
            </label>
            <input type="text" name="slug" id="bc-slug"
                   class="form-control font-monospace" dir="ltr"
                   placeholder="my-blog-post" data-validation="required">
            <small class="text-muted">{{ __('auth.slug_hint') ?? 'يتم توليده تلقائياً من العنوان — يمكنك تعديله يدوياً' }}</small>
        </div>

    </div>

    <div class="modal-footer mt-2">
        <button class="btn btn-primary" type="submit">{{ __('buttons.save') }}</button>
        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">{{ __('buttons.close') }}</button>
    </div>
</form>

<script>
(function () {
    var manualSlug = false;

    function slugify(text) {
        return text.trim()
            .replace(/\s+/g, '-')
            .replace(/[^؀-ۿa-zA-Z0-9\-]/g, '')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '')
            .toLowerCase();
    }

    function updateSlug() {
        if (manualSlug) return;
        var en = $('#bc-en-title').val().trim();
        var ar = $('#bc-ar-title').val().trim();
        var source = en || ar;
        if (source) {
            $('#bc-slug').val(slugify(source));
        }
    }

    $('#bc-ar-title, #bc-en-title').on('input', updateSlug);

    $('#bc-slug').on('input', function () {
        manualSlug = !!$(this).val().trim();
    });

    $('#bc-slug-reset').on('click', function () {
        manualSlug = false;
        updateSlug();
    });
})();
</script>
