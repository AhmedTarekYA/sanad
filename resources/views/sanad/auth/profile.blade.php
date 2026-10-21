@extends('sanad.layout.indexs.index')

@php
    $profileImage = showFile($user->image, 'admin');
    $profileDetailsHint =
        app()->getLocale() === 'ar'
            ? 'أدر بياناتك الشخصية وصورة الملف الشخصي.'
            : 'Manage your personal details and profile photo.';
    $passwordHint =
        app()->getLocale() === 'ar'
            ? 'استخدم مزيجًا من الحروف والأرقام والرموز.'
            : 'Use a mix of letters, numbers, and symbols.';
    $imageHint =
        app()->getLocale() === 'ar'
            ? 'اختر صورة واضحة بصيغة PNG أو JPG بحجم أقصى 2 ميجابايت.'
            : 'Choose a clear photo. PNG or JPG, up to 2 MB.';
    $passwordCardHint =
        app()->getLocale() === 'ar'
            ? 'حافظ على أمان حسابك باستخدام كلمة مرور قوية.'
            : 'Keep your account protected with a strong password.';
@endphp

@section('page-links')
    <li class="breadcrumb-item active" aria-current="page">{{ $bladeTitle }}</li>
@endsection

@section('content')
    <div class="profile-page">
        <div class="row g-4 profile-content-grid">
            <div class="col-lg-8">
                <section class="profile-card" aria-labelledby="profile-details-title">
                    <div class="profile-card__header"><span class="profile-card__icon profile-card__icon--primary"
                            aria-hidden="true"><i class="ti ti-user-edit"></i></span>
                        <div>
                            <h3 id="profile-details-title">{{ __('auth.profile') }}</h3>
                            <p>{{ $profileDetailsHint }}</p>
                        </div>
                    </div>
                    <div class="profile-card__body">
                        <form method="post" class="from-submit-update-global"
                            action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
                            @method('put') @csrf
                            <div class="profile-image-picker">
                                <img id="profilePreview" src="{{ $profileImage }}" alt="{{ $user->name }}"
                                    onerror="this.src='{{ asset('admin/assets/img/profile_av.png') }}'">
                                <div class="profile-image-picker__copy">
                                    <h4>{{ __('auth.image') }}</h4>
                                    <p>{{ $imageHint }}</p><label for="file-input" class="btn btn-light-primary"><i
                                            class="ti ti-upload"
                                            aria-hidden="true"></i>{{ __('auth.image') }}</label><input type="file"
                                        class="visually-hidden" name="image" id="file-input"
                                        accept="image/png,image/jpeg,image/webp">
                                </div>
                            </div>
                            <div class="row g-3 profile-form-grid">
                                <div class="col-md-6"><label class="form-label"
                                        for="profile-name">{{ __('auth.name') }}</label><input id="profile-name"
                                        type="text" class="form-control" name="name" value="{{ $user->name }}"
                                        autocomplete="name"></div>
                                <div class="col-md-6"><label class="form-label"
                                        for="profile-email">{{ __('auth.email') }}</label><input id="profile-email"
                                        type="email" class="form-control" name="email" value="{{ $user->email }}"
                                        autocomplete="email"></div>
                                <div class="col-md-6"><label class="form-label"
                                        for="profile-phone">{{ __('auth.phone') }}</label><input id="profile-phone"
                                        type="tel" inputmode="tel" class="form-control" name="phone"
                                        value="{{ $user->phone }}" placeholder="01012345678" autocomplete="tel"></div>
                            </div>
                            <div class="profile-form-actions"><button class="btn btn-primary"
                                    type="submit"><i class="ti ti-device-floppy"
                                        aria-hidden="true"></i>{{ __('buttons.save') }}</button></div>
                        </form>
                    </div>
                </section>
            </div>

            <div class="col-lg-4">
                <section class="profile-card profile-password-card" aria-labelledby="password-title">
                    <div class="profile-card__header"><span class="profile-card__icon profile-card__icon--warning"
                            aria-hidden="true"><i class="ti ti-lock"></i></span>
                        <div>
                            <h3 id="password-title">{{ __('auth.change_password') }}</h3>
                            <p>{{ $passwordCardHint }}</p>
                        </div>
                    </div>
                    <div class="profile-card__body">
                        <form method="post" action="{{ route('change-password.update', $user->id) }}"
                            class="from-submit-update-global">
                            @method('put') @csrf
                            <div class="mb-3"><label class="form-label"
                                    for="current-password">{{ __('auth.current_password') }}</label><input
                                    id="current-password" type="password" class="form-control" name="current_password"
                                    autocomplete="current-password"></div>
                            <div class="mb-2"><label class="form-label"
                                    for="new-password">{{ __('auth.new_password') }}</label><input id="new-password"
                                    type="password" name="new_password" class="form-control password-meter-input"
                                    autocomplete="new-password" aria-describedby="password-hint"></div>
                            <div class="profile-password-meter progress mb-2" aria-hidden="true">
                                <div class="progress-bar bg-primary-gradient progress-bar-bar" role="progressbar"
                                    style="width:0%"></div>
                            </div>
                            <p id="password-hint" class="profile-helper">{{ $passwordHint }}</p>
                            <div class="mb-4"><label class="form-label"
                                    for="confirm-password">{{ __('auth.confirm_password') }}</label><input
                                    id="confirm-password" type="password" class="form-control"
                                    name="new_confirm_password" autocomplete="new-password"></div>
                            <button class="btn btn-primary w-100" type="submit"><i class="ti ti-key"
                                    aria-hidden="true"></i>{{ __('auth.change_password') }}</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        (() => {
            const fileInput = document.getElementById('file-input');
            const preview = document.getElementById('profilePreview');
            let previewUrl;
            fileInput?.addEventListener('change', (event) => {
                const file = event.target.files?.[0];
                if (!file || !preview) return;
                if (previewUrl) URL.revokeObjectURL(previewUrl);
                previewUrl = URL.createObjectURL(file);
                preview.src = previewUrl;
            });
        })();
    </script>
@endsection
