<dl class="row g-3 mb-0">
    <dt class="col-sm-4">{{ __('auth.full_name') }}</dt>
    <dd class="col-sm-8">{{ $obj->full_name }}</dd>

    <dt class="col-sm-4">{{ __('auth.company_name') }}</dt>
    <dd class="col-sm-8">{{ $obj->company_name }}</dd>

    <dt class="col-sm-4">{{ __('auth.mobile_whatsapp') }}</dt>
    <dd class="col-sm-8" dir="ltr">{{ $obj->mobile_whatsapp }}</dd>

    <dt class="col-sm-4">{{ __('auth.daily_contact_volume') }}</dt>
    <dd class="col-sm-8">{{ $obj->daily_contact_volume }}</dd>

    <dt class="col-sm-4">{{ __('auth.current_systems') }}</dt>
    <dd class="col-sm-8">{{ $obj->current_systems ?: '—' }}</dd>

    <dt class="col-sm-4">{{ __('auth.date') }}</dt>
    <dd class="col-sm-8">{{ $obj->created_at?->format('Y-m-d H:i') }}</dd>
</dl>
