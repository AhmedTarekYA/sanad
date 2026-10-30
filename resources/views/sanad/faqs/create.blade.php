<form class="from-submit-global" method="POST" action="{{ $storeRoute }}">
    @csrf

    <div class="row g-3 p-1">

        {{-- Language Tabs --}}
        <div class="col-12">
            <ul class="nav nav-tabs" id="faqCreateTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" type="button" data-bs-toggle="tab"
                            data-bs-target="#faq-create-ar" role="tab">
                        {{ __('auth.arabic') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" type="button" data-bs-toggle="tab"
                            data-bs-target="#faq-create-en" role="tab">
                        {{ __('auth.english') }}
                    </button>
                </li>
            </ul>
            <div class="tab-content border border-top-0 rounded-bottom p-3">

                <div class="tab-pane fade show active" id="faq-create-ar" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                {{ __('auth.question') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="ar[question]" class="form-control" data-validation="required">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                {{ __('auth.answer') }} <span class="text-danger">*</span>
                            </label>
                            <textarea name="ar[answer]" class="form-control" rows="4" data-validation="required"></textarea>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="faq-create-en" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('auth.question') }}</label>
                            <input type="text" name="en[question]" class="form-control" dir="ltr">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('auth.answer') }}</label>
                            <textarea name="en[answer]" class="form-control" rows="4" dir="ltr"></textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Sort & Status --}}
        <div class="col-6">
            <label class="form-label fw-semibold">{{ __('auth.sort_order') }}</label>
            <input type="number" name="sort_order" class="form-control" value="0" min="0">
        </div>
        <div class="col-6">
            <label class="form-label fw-semibold">{{ __('auth.status') }}</label>
            <select name="is_active" class="form-select">
                <option value="1">{{ __('active') }}</option>
                <option value="0">{{ __('inactive') }}</option>
            </select>
        </div>

    </div>

    <div class="modal-footer mt-2">
        <button class="btn btn-primary" type="submit">{{ __('buttons.save') }}</button>
        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">{{ __('buttons.close') }}</button>
    </div>
</form>
