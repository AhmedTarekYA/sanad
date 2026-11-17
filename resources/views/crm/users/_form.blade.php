@php($user = $user ?? null)
@php($selectedPermissions = old('permissions', $user->permissions ?? []))
<form id="crm-user-form" class="from-submit-global" data-action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <div id="crm-user-error" class="alert alert-danger d-none"></div>

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('name') }} <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" data-validation="required">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('email') }} <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" dir="ltr" value="{{ old('email', $user->email ?? '') }}" data-validation="required,email">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('phone') }}</label>
            <input type="text" name="phone" class="form-control" dir="ltr" value="{{ old('phone', $user->phone ?? '') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('password') }} @if(! $user)<span class="text-danger">*</span>@endif</label>
            <input type="password" name="password" class="form-control" dir="ltr" autocomplete="new-password" @if(! $user) data-validation="required,length" data-validation-length="min6" @endif>
            @if($user)
                <div class="form-text">{{ __('password') }} — {{ __('all') }}: {{ __('optional') }}</div>
            @endif
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('role') }} <span class="text-danger">*</span></label>
            <select name="role" class="form-select">
                <option value="agent" @selected(old('role', $user->role ?? 'agent') === 'agent')>{{ __('agent') }}</option>
                <option value="admin" @selected(old('role', $user->role ?? 'agent') === 'admin')>{{ __('admin') }}</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">{{ __('status') }}</label>
            <select name="is_active" class="form-select">
                <option value="1" @selected((string) old('is_active', (int) ($user->is_active ?? 1)) === '1')>{{ __('active') }}</option>
                <option value="0" @selected((string) old('is_active', (int) ($user->is_active ?? 1)) === '0')>{{ __('inactive') }}</option>
            </select>
        </div>
        <div class="col-12">
            <label for="image" class="form-label fw-semibold">{{ __('image') }}</label>
            <input type="file" id="image" name="image" class="dropify" data-allowed-file-extensions="jpg jpeg png webp"
                   @if($user && $user->image) data-default-file="{{ $user->image_url }}" @endif>
        </div>
        <div class="col-12">
            <label class="form-label fw-semibold">{{ __('permissions') }}</label>
            <div class="row g-2">
                @foreach($permissionPages as $page)
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $page }}"
                                   id="permission-{{ $page }}" @checked(in_array($page, $selectedPermissions, true))>
                            <label class="form-check-label" for="permission-{{ $page }}">{{ __($page) }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="form-text">{{ __('admin') }}: {{ __('permissions') }} — {{ __('all') }}</div>
        </div>
    </div>

    <div class="d-flex gap-2 mt-3">
        <button class="btn btn-primary" type="submit">{{ __('save') }}</button>
        <a href="{{ route('crm.users.index') }}" class="btn btn-outline-secondary">{{ __('cancel') }}</a>
    </div>
</form>
