<form class="from-submit-global" method="POST" action="{{ $storeRoute }}">
    @csrf

    <div class="row g-3 p-1">

        {{-- Card language tabs --}}
        <div class="col-12">
            <ul class="nav nav-tabs" id="whyCreateTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" type="button" data-bs-toggle="tab"
                            data-bs-target="#why-create-ar" role="tab">
                        {{ __('auth.arabic') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" type="button" data-bs-toggle="tab"
                            data-bs-target="#why-create-en" role="tab">
                        {{ __('auth.english') }}
                    </button>
                </li>
            </ul>
            <div class="tab-content border border-top-0 rounded-bottom p-3">

                <div class="tab-pane fade show active" id="why-create-ar" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                {{ __('auth.title') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="ar[title]" class="form-control" data-validation="required">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('auth.subtitle') }}</label>
                            <input type="text" name="ar[subtitle]" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="why-create-en" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('auth.title') }}</label>
                            <input type="text" name="en[title]" class="form-control" dir="ltr">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">{{ __('auth.subtitle') }}</label>
                            <input type="text" name="en[subtitle]" class="form-control" dir="ltr">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Features --}}
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label fw-semibold mb-0">{{ __('auth.features') }}</label>
                <button type="button" class="btn btn-sm btn-outline-primary add-feature-row">
                    <i class="ti ti-plus"></i> {{ __('auth.add_feature') }}
                </button>
            </div>
            <small class="text-muted d-block mb-2">{{ __('auth.features_note') }}</small>

            <div id="features-container">
                @include('sanad.why-choose-us._feature-row', ['index' => 0, 'feature' => null])
            </div>

            <template id="feature-row-template">
                @include('sanad.why-choose-us._feature-row', ['index' => '__INDEX__', 'feature' => null])
            </template>
        </div>

    </div>

    <div class="modal-footer mt-2">
        <button class="btn btn-primary" type="submit">{{ __('buttons.save') }}</button>
        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">{{ __('buttons.close') }}</button>
    </div>
</form>
