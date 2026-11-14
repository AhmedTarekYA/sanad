<form class="from-submit-update-global" method="POST" action="{{ $updateRoute }}">
    @csrf
    @method('PUT')

    <div class="row g-3 p-1">
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('auth.name') }} <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ $obj->name }}" data-validation="required">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('auth.email') }} <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" dir="ltr" value="{{ $obj->email }}" data-validation="required,email">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('auth.password') }}</label>
            <input type="password" name="password" class="form-control" autocomplete="new-password">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('auth.subscription_ends_at') }}</label>
            <input type="datetime-local" name="subscription_ends_at" class="form-control" dir="ltr"
                   value="{{ $obj->subscription_ends_at?->format('Y-m-d\TH:i') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('auth.status') }}</label>
            <select name="is_active" class="form-select">
                <option value="1" {{ $obj->is_active ? 'selected' : '' }}>{{ __('active') }}</option>
                <option value="0" {{ !$obj->is_active ? 'selected' : '' }}>{{ __('inactive') }}</option>
            </select>
        </div>
    </div>

    <div class="modal-footer mt-2">
        <button class="btn btn-primary" type="submit">{{ __('buttons.save') }}</button>
        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">{{ __('buttons.close') }}</button>
    </div>
</form>
