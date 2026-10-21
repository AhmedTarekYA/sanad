<table class="table table-bordered">
    <tbody>
    {{-- App Mode --}}
    <tr>
        <th colspan="2" class="bg-light">{{ __('App Mode') }}</th>
    </tr>
    <tr>
        <td>{{ __('Is Dev') }}</td>
        <td>{{ $obj->is_dev ? __('Yes') : __('No') }}</td>
    </tr>
    <tr>
        <td>{{ __('Is Maintenance') }}</td>
        <td>{{ $obj->is_maintenance ? __('Yes') : __('No') }}</td>
    </tr>
    <tr>
        <td>{{ __('Force Update') }}</td>
        <td>{{ $obj->force_update ? __('Yes') : __('No') }}</td>
    </tr>
    <tr>
        <td>{{ __('Show Dialog') }}</td>
        <td>{{ $obj->show_dialog ? __('Yes') : __('No') }}</td>
    </tr>

    {{-- Update --}}
    <tr>
        <th colspan="2" class="bg-light">{{ __('Update') }}</th>
    </tr>
    <tr>
        <td>{{ __('Latest Version Android') }}</td>
        <td>{{ $obj->latest_version_android }}</td>
    </tr>
    <tr>
        <td>{{ __('Latest Version iOS') }}</td>
        <td>{{ $obj->latest_version_ios }}</td>
    </tr>

    {{-- API --}}
    <tr>
        <th colspan="2" class="bg-light">{{ __('API') }}</th>
    </tr>
    <tr>
        <td>{{ __('API Base URL') }}</td>
        <td>{{ $obj->api_base_url }}</td>
    </tr>
    <tr>
        <td>{{ __('API Image Base URL') }}</td>
        <td>{{ $obj->api_image_base_url }}</td>
    </tr>

    {{-- Features --}}
    <tr>
        <th colspan="2" class="bg-light">{{ __('Features') }}</th>
    </tr>
    <tr>
        <td>{{ __('Enable Payment') }}</td>
        <td>{{ $obj->enable_payment ? __('Yes') : __('No') }}</td>
    </tr>

    {{-- Messages --}}
    <tr>
        <th colspan="2" class="bg-light">{{ __('Messages') }}</th>
    </tr>
    <tr>
        <td>{{ __('Welcome Message') }}</td>
        <td>{{ $obj->welcome_message }}</td>
    </tr>
    <tr>
        <td>{{ __('Update Message') }}</td>
        <td>{{ $obj->update_message }}</td>
    </tr>
    <tr>
        <td>{{ __('Maintenance Message') }}</td>
        <td>{{ $obj->maintenance_message }}</td>
    </tr>
    <tr>
        <td>{{ __('Force Update Message') }}</td>
        <td>{{ $obj->force_update_message }}</td>
    </tr>

    {{-- Integrations --}}
    <tr>
        <th colspan="2" class="bg-light">{{ __('Integrations') }}</th>
    </tr>
    <tr>
        <td>{{ __('Maps API Key') }}</td>
        <td>{{ $obj->maps_api_key }}</td>
    </tr>
    </tbody>
</table>
