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
