<form class="from-submit-update-global" method="POST" action="{{ $updateRoute }}">
    @csrf
    @method('PUT')

    <div class="row g-3 p-1">

        {{-- Language Tabs --}}
        <div class="col-12">
            <ul class="nav nav-tabs" id="reviewEditTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" type="button" data-bs-toggle="tab"
                            data-bs-target="#review-edit-ar" role="tab">
                        {{ __('auth.arabic') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" type="button" data-bs-toggle="tab"
                            data-bs-target="#review-edit-en" role="tab">
                        {{ __('auth.english') }}
                    </button>
                </li>
            </ul>
            <div class="tab-content border border-top-0 rounded-bottom p-3">

                {{-- Arabic Tab --}}
                <div class="tab-pane fade show active" id="review-edit-ar" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold">
                                {{ __('auth.name') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="ar[name]" class="form-control"
                                   value="{{ $obj->translate('ar')?->name }}" data-validation="required">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold">{{ __('auth.job') }}</label>
                            <input type="text" name="ar[job]" class="form-control"
                                   value="{{ $obj->translate('ar')?->job }}">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold">{{ __('auth.company_name') }}</label>
                            <input type="text" name="ar[company_name]" class="form-control"
                                   value="{{ $obj->translate('ar')?->company_name }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                {{ __('auth.review_message') }} <span class="text-danger">*</span>
                            </label>
                            <textarea name="ar[review_message]" class="form-control" rows="4"
                                      data-validation="required">{{ $obj->translate('ar')?->review_message }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- English Tab --}}
                <div class="tab-pane fade" id="review-edit-en" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold">{{ __('auth.name') }}</label>
                            <input type="text" name="en[name]" class="form-control" dir="ltr"
                                   value="{{ $obj->translate('en')?->name }}">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold">{{ __('auth.job') }}</label>
                            <input type="text" name="en[job]" class="form-control" dir="ltr"
                                   value="{{ $obj->translate('en')?->job }}">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold">{{ __('auth.company_name') }}</label>
                            <input type="text" name="en[company_name]" class="form-control" dir="ltr"
                                   value="{{ $obj->translate('en')?->company_name }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('auth.review_message') }}</label>
                            <textarea name="en[review_message]" class="form-control" rows="4"
                                      dir="ltr">{{ $obj->translate('en')?->review_message }}</textarea>
                        </div>
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
