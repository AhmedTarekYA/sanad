@php
    $isRtl = app()->getLocale() === 'ar';
@endphp

<button type="button" class="crm-help-fab" data-bs-toggle="modal" data-bs-target="#crmHelpModal"
        aria-label="{{ __('crm_help_how_it_works') }}" title="{{ __('crm_help_how_it_works') }}"
        style="position:fixed;bottom:24px;{{ $isRtl ? 'right' : 'left' }}:24px;width:48px;height:48px;border-radius:50%;background:#2D71F0;color:#fff;z-index:1055;box-shadow:0 8px 24px rgba(45,113,240,0.45);border:0;display:flex;align-items:center;justify-content:center;font-size:22px;">
    <i class="ti ti-help"></i>
</button>

<div class="modal fade" id="crmHelpModal" tabindex="-1" aria-labelledby="crmHelpModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crmHelpModalTitle">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('buttons.close') }}"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">{{ $description }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ __('buttons.close') }}</button>
            </div>
        </div>
    </div>
</div>
