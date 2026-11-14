<form class="from-submit-global" method="POST" action="{{ $storeRoute }}" enctype="multipart/form-data">
    @csrf

    <div class="row g-3 p-1">
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('auth.name') }} <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" data-validation="required">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('auth.email') }} <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" dir="ltr" data-validation="required,email">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('auth.password') }} <span class="text-danger">*</span></label>
            <input type="password" name="password" class="form-control" autocomplete="new-password" data-validation="required,length" data-validation-length="min6">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('auth.subscription_ends_at') }}</label>
            <input type="datetime-local" name="subscription_ends_at" class="form-control" dir="ltr">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('auth.status') }}</label>
            <select name="is_active" class="form-select">
                <option value="1">{{ __('active') }}</option>
                <option value="0">{{ __('inactive') }}</option>
            </select>
        </div>
        <div class="col-12">
            <label for="image" class="form-label fw-semibold">{{ __('auth.image') }}</label>
            <input type="file" id="image" name="image" class="dropify" data-allowed-file-extensions="jpg jpeg png webp">
        </div>
    </div>

    <div class="modal-footer mt-2">
        <button class="btn btn-primary" type="submit">{{ __('buttons.save') }}</button>
        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">{{ __('buttons.close') }}</button>
    </div>
</form>
