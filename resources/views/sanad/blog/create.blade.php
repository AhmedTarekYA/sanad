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

                {{-- Arabic Tab --}}
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
                        <div class="col-12">
                            <label class="form-label fw-semibold d-flex align-items-center gap-2">
                                {{ __('auth.slug') }} <span class="text-danger">*</span>
                                <button type="button" id="bc-ar-slug-reset"
                                        class="btn btn-sm btn-outline-secondary py-0 px-2 ms-auto"
                                        title="{{ __('auth.slug_reset') }}">
                                    <i class="ti ti-refresh"></i>
                                </button>
                            </label>
                            <input type="text" name="ar[slug]" id="bc-ar-slug"
                                   class="form-control font-monospace"
                                   placeholder="مقال-جديد" data-validation="required">
                            <small class="text-muted">{{ __('auth.slug_hint') }}</small>
                        </div>
                    </div>
                </div>

                {{-- English Tab --}}
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
                        <div class="col-12">
                            <label class="form-label fw-semibold d-flex align-items-center gap-2">
                                {{ __('auth.slug') }}
                                <button type="button" id="bc-en-slug-reset"
                                        class="btn btn-sm btn-outline-secondary py-0 px-2 ms-auto"
                                        title="{{ __('auth.slug_reset') }}">
                                    <i class="ti ti-refresh"></i>
                                </button>
                            </label>
                            <input type="text" name="en[slug]" id="bc-en-slug"
                                   class="form-control font-monospace" dir="ltr"
                                   placeholder="new-post">
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
                               name="is_featured" id="bc-is-featured" value="1">
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

    // Arabic slug auto-fill
    var arManual = false;
    $('#bc-ar-title').on('input', function () {
        if (!arManual) {
            $('#bc-ar-slug').val(slugify($(this).val()));
        }
    });
    $('#bc-ar-slug').on('input', function () {
        arManual = !!$(this).val().trim();
    });
    $('#bc-ar-slug-reset').on('click', function () {
        arManual = false;
        $('#bc-ar-slug').val(slugify($('#bc-ar-title').val()));
    });

    // English slug auto-fill
    var enManual = false;
    $('#bc-en-title').on('input', function () {
        if (!enManual) {
            $('#bc-en-slug').val(slugify($(this).val()));
        }
    });
    $('#bc-en-slug').on('input', function () {
        enManual = !!$(this).val().trim();
    });
    $('#bc-en-slug-reset').on('click', function () {
        enManual = false;
        $('#bc-en-slug').val(slugify($('#bc-en-title').val()));
    });
})();
</script>
