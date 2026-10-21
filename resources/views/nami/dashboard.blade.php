@extends('nami.layout.indexs.index')

@section('page-title')
    {{ trans('auth.home') }}
@endsection

@section('content')
    @php($authUser = getAuthUser())
    <div class="dashboard-home">
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card dashboard-welcome border-0">
                    <div class="card-body p-4 p-lg-5">
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div>
                                <span class="badge bg-light-primary text-primary mb-3">{{ __('auth.dashboard') }}</span>
                                <h1 class="mb-2">{{ __('auth.welcomeback') }}، {{ $authUser?->name }}</h1>
                                <p class="mb-0">{{ app()->getLocale() === 'ar' ? 'إدارة مشروعك تبدأ من هنا. اختر مساحة العمل التي تريد الوصول إليها.' : 'Manage your workspace from one place. Choose where you want to start.' }}</p>
                            </div>
                            <i class="ph-duotone ph-chart-line-up dashboard-welcome-icon" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dashboard-section-heading">
            <div>
                <h2>{{ app()->getLocale() === 'ar' ? 'الوصول السريع' : 'Quick access' }}</h2>
                <p>{{ app()->getLocale() === 'ar' ? 'الأماكن التي تستخدمها بشكل متكرر' : 'Your most-used workspaces' }}</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card dashboard-tile h-100">
                    <div class="card-body">
                        <span class="dashboard-tile-icon bg-light-primary text-primary"><i class="ph-duotone ph-gauge" aria-hidden="true"></i></span>
                        <h3>{{ __('auth.home') }}</h3>
                        <p class="mb-0">{{ app()->getLocale() === 'ar' ? 'نظرة عامة على مساحة العمل' : 'Your workspace overview' }}</p>
                    </div>
                </div>
            </div>
            @if(checkIfHasPermission('settings-read'))
                <div class="col-md-4">
                    <a href="{{ route('settings.index') }}" class="card dashboard-tile h-100 text-decoration-none">
                        <div class="card-body">
                            <span class="dashboard-tile-icon bg-light-warning text-warning"><i class="ph-duotone ph-sliders-horizontal" aria-hidden="true"></i></span>
                            <i class="ph-duotone ph-arrow-up-left dashboard-tile__arrow" aria-hidden="true"></i>
                            <h3>{{ __('auth.site_settings') }}</h3>
                            <p class="mb-0">{{ app()->getLocale() === 'ar' ? 'تحكم في إعدادات الموقع والمظهر' : 'Control site settings and appearance' }}</p>
                        </div>
                    </a>
                </div>
            @endif
            @if(checkIfHasPermission('roles-read'))
                <div class="col-md-4">
                    <a href="{{ route('roles.index') }}" class="card dashboard-tile h-100 text-decoration-none">
                        <div class="card-body">
                            <span class="dashboard-tile-icon bg-light-success text-success"><i class="ph-duotone ph-shield-check" aria-hidden="true"></i></span>
                            <i class="ph-duotone ph-arrow-up-left dashboard-tile__arrow" aria-hidden="true"></i>
                            <h3>{{ __('permission.users and roles') }}</h3>
                            <p class="mb-0">{{ app()->getLocale() === 'ar' ? 'إدارة المستخدمين والأدوار والصلاحيات' : 'Manage users, roles and permissions' }}</p>
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('style')
    <style>
        .dashboard-tile .dashboard-tile-icon i, .dashboard-welcome-icon { pointer-events: none; }
    </style>
@endsection

@section('js')
@endsection
