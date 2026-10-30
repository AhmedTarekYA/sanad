@php($ar = $feature?->translate('ar'))
@php($en = $feature?->translate('en'))
<div class="feature-row border rounded p-3 mb-2 bg-light" data-feature-row>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="fw-semibold"><i class="ti ti-list"></i> {{ __('auth.feature') }}</span>
        <button type="button" class="btn btn-sm btn-outline-danger remove-feature-row">
            <i class="ti ti-trash"></i> {{ __('auth.remove_feature') }}
        </button>
    </div>
    <div class="row g-3">
        <div class="col-12 col-md-6">
            <label class="form-label fw-semibold">
                {{ __('auth.title') }} ({{ __('auth.arabic') }}) <span class="text-danger">*</span>
            </label>
            <input type="text" name="features[{{ $index }}][ar][title]" class="form-control"
                   value="{{ $ar?->title }}">
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label fw-semibold">{{ __('auth.title') }} ({{ __('auth.english') }})</label>
            <input type="text" name="features[{{ $index }}][en][title]" class="form-control" dir="ltr"
                   value="{{ $en?->title }}">
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label fw-semibold">{{ __('auth.description') }} ({{ __('auth.arabic') }})</label>
            <textarea name="features[{{ $index }}][ar][description]" class="form-control" rows="2">{{ $ar?->description }}</textarea>
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label fw-semibold">{{ __('auth.description') }} ({{ __('auth.english') }})</label>
            <textarea name="features[{{ $index }}][en][description]" class="form-control" rows="2" dir="ltr">{{ $en?->description }}</textarea>
        </div>
    </div>
</div>
