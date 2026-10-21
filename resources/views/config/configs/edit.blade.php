<form class="row g-3 from-submit-global" method="POST" action="{{ route('configs.update', $obj->id) }}">
        @csrf
        @method('PUT')
        <h5 class="mt-4">{{ __('App Mode') }}</h5>
    <div class="col-6">
        <label for="project_name" class="form-label">{{ __('Project Name') }}</label>
        <input type="text" name="name" class="form-control"
               value="{{$obj->name}}"
               data-validation="required,projectName"
        >
    </div>
    <div class="col-6">
        <label for="project_code" class="form-label">{{ __('Project Code') }}</label>
        <input type="text" name="code" class="form-control" maxlength="32"
               value="{{$obj->code}}"
               data-validation="required,projectCode"
        >
    </div>
<input type="hidden" name="is_dev" value="0">
<input type="hidden" name="is_maintenance" value="0">
<input type="hidden" name="force_update" value="0">
<input type="hidden" name="show_dialog" value="0">
         <div class="col-6">
            <label for="is_dev" class="form-label">{{ __('Is Dev') }}</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="is_dev" name="is_dev" value="1" {{ $obj->is_dev ? 'checked' : '' }}>
                <label class="form-check-label" for="is_dev">{{ __('Enable Developer Mode') }}</label>
            </div>
        </div>
        <div class="col-6">
            <label for="is_maintenance" class="form-label">{{ __('Is Maintenance') }}</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="is_maintenance" name="is_maintenance" value="1" {{ $obj->is_maintenance ? 'checked' : '' }}>
                <label class="form-check-label" for="is_maintenance">{{ __('Enable Maintenance Mode') }}</label>
            </div>
        </div>
        <div class="col-6">
            <label for="force_update" class="form-label">{{ __('Force Update') }}</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="force_update" name="force_update" value="1" {{ $obj->force_update ? 'checked' : '' }}>
                <label class="form-check-label" for="force_update">{{ __('Force Update') }}</label>
            </div>
        </div>
        <div class="col-6">
            <label for="show_dialog" class="form-label">{{ __('Show Dialog') }}</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="show_dialog" name="show_dialog" value="1" {{ $obj->show_dialog ? 'checked' : '' }}>
                <label class="form-check-label" for="show_dialog">{{ __('Show Dialog') }}</label>
            </div>
        </div>
        <h5 class="mt-4">{{ __('Update') }}</h5>
        <div class="col-6">
            <label for="latest_version_android" class="form-label">{{ __('Latest Version Android') }}</label>
            <input type="text" name="latest_version_android" class="form-control" value="{{ $obj->latest_version_android }}" required>
        </div>
        <div class="col-6">
            <label for="latest_version_ios" class="form-label">{{ __('Latest Version iOS') }}</label>
            <input type="text" name="latest_version_ios" class="form-control" value="{{ $obj->latest_version_ios }}" required>
        </div>
        <h5 class="mt-4">{{ __('API') }}</h5>
        <div class="col-6">
            <label for="api_base_url" class="form-label">{{ __('API Base URL') }}</label>
            <input type="url" name="api_base_url" class="form-control" value="{{ $obj->api_base_url }}" required>
        </div>
        <div class="col-6">
            <label for="api_image_base_url" class="form-label">{{ __('API Image Base URL') }}</label>
            <input type="url" name="api_image_base_url" class="form-control" value="{{ $obj->api_image_base_url }}" required>
        </div>
        <h5 class="mt-4">{{ __('Features') }}</h5>
        <div class="col-6">
            <label for="enable_payment" class="form-label">{{ __('Enable Payment') }}</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="enable_payment" name="enable_payment" value="1" {{ $obj->enable_payment ? 'checked' : '' }}>
                <label class="form-check-label" for="enable_payment">{{ __('Enable Payment') }}</label>
            </div>
        </div>
        <h5 class="mt-4">{{ __('Messages') }}</h5>
        <div class="col-6">
            <label for="welcome_message" class="form-label">{{ __('Welcome Message') }}</label>
            <textarea name="welcome_message" class="form-control">{{ $obj->welcome_message }}</textarea>
        </div>
        <div class="col-6">
            <label for="update_message" class="form-label">{{ __('Update Message') }}</label>
            <textarea name="update_message" class="form-control">{{ $obj->update_message }}</textarea>
        </div>
        <div class="col-6">
            <label for="maintenance_message" class="form-label">{{ __('Maintenance Message') }}</label>
            <textarea name="maintenance_message" class="form-control">{{ $obj->maintenance_message }}</textarea>
        </div>
        <div class="col-6">
            <label for="force_update_message" class="form-label">{{ __('Force Update Message') }}</label>
            <textarea name="force_update_message" class="form-control">{{ $obj->force_update_message }}</textarea>
        </div>
        <h5 class="mt-4">{{ __('Integrations') }}</h5>
        <div class="col-6">
            <label for="maps_api_key" class="form-label">{{ __('Maps API Key') }}</label>
            <input type="text" name="maps_api_key" class="form-control" value="{{ $obj->maps_api_key }}" required>
        </div>
        <div class="col-12 modal-footer">
            {!! storeButton(route('configs.update', $obj->id)) !!}
            {!! closeButton() !!}
        </div>
    </form>
<script>
    $.formUtils.addValidator({
        name: 'projectCode',
        validatorFunction: function (value, $el, config, language, $form) {
            var regex = /^[A-Za-z][A-Za-z0-9]{0,31}$/;
            return regex.test(value);
        },
        errorMessage: '{{ __("invalid project code") }}',
        errorMessageKey: 'projectCode'
    });
    $.formUtils.addValidator({
        name: 'projectName',
        validatorFunction: function (value, $el, config, language, $form) {
            var regex = /^[A-Za-z][A-Za-z0-9]*$/;
            return regex.test(value);

        },
        errorMessage: '{{ __("invalid project Name") }}',
        errorMessageKey: 'projectName'
    });
</script>
