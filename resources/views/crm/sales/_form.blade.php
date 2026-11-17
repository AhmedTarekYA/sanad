@php($sale = $sale ?? null)
<form id="crm-sale-form" data-action="{{ $action }}">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div id="crm-sale-error" class="alert alert-danger d-none"></div>

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('customer_name') }}</label>
            <input type="text" name="customer_name" class="form-control" maxlength="255" value="{{ old('customer_name', $sale->customer_name ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('phone') }}</label>
            <input type="text" name="phone" class="form-control" dir="ltr" maxlength="30" value="{{ old('phone', $sale->phone ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('price') }}</label>
            <input type="number" step="0.01" min="0" name="price" class="form-control" dir="ltr" value="{{ old('price', $sale->price ?? '') }}">
        </div>
        <div class="col-12">
            <label class="form-label fw-semibold">{{ __('request_text') }}</label>
            <textarea name="request_text" class="form-control" rows="4" maxlength="5000">{{ old('request_text', $sale->request_text ?? '') }}</textarea>
        </div>
    </div>

    <div class="d-flex gap-2 mt-3">
        <button class="btn btn-primary" type="submit">{{ __('save') }}</button>
        <a href="{{ route('crm.crm_sales.index') }}" class="btn btn-outline-secondary">{{ __('cancel') }}</a>
    </div>
</form>
