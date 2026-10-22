@extends('sanad.layout.indexs.index')

@section('page-title')
    {{ trans('auth.home') }}
@endsection

@section('content')
    @php
        $authUser = getAuthUser();
    @endphp
    <div class="dashboard-home">

        {{-- Welcome Card --}}
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
                            <img src="{{ asset('admin/assets/img/earth.png') }}" alt="" class="dashboard-welcome-img" aria-hidden="true">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Visitor Stats ── --}}
        <div class="dashboard-section-heading">
            <div>
                <h2>{{ app()->getLocale() === 'ar' ? 'إحصائيات الزوار' : 'Visitor Analytics' }}</h2>
                <p>{{ app()->getLocale() === 'ar' ? 'تتبع زوار الموقع في الوقت الفعلي' : 'Real-time website visitor tracking' }}</p>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="row g-3 mb-4">
            @php
                $stats = [
                    ['icon' => 'ph-eye', 'color' => 'primary', 'label' => app()->getLocale() === 'ar' ? 'زيارات اليوم' : 'Today', 'value' => $todayCount, 'sub' => ($todayUnique).' '.( app()->getLocale() === 'ar' ? 'فريد' : 'unique')],
                    ['icon' => 'ph-calendar-week', 'color' => 'info',    'label' => app()->getLocale() === 'ar' ? 'هذا الأسبوع' : 'This Week', 'value' => $weekCount, 'sub' => ''],
                    ['icon' => 'ph-calendar-dots', 'color' => 'warning', 'label' => app()->getLocale() === 'ar' ? 'هذا الشهر' : 'This Month', 'value' => $monthCount, 'sub' => ''],
                    ['icon' => 'ph-users-three',   'color' => 'success', 'label' => app()->getLocale() === 'ar' ? 'إجمالي الزوار الفريدون' : 'Unique Visitors', 'value' => $uniqueCount, 'sub' => $totalCount.' '.( app()->getLocale() === 'ar' ? 'إجمالي' : 'total')],
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="col-6 col-lg-3">
                    <div class="card h-100 border-0">
                        <div class="card-body d-flex align-items-center gap-3">
                            <span class="dashboard-tile-icon bg-light-{{ $stat['color'] }} text-{{ $stat['color'] }} flex-shrink-0">
                                <i class="ph-duotone {{ $stat['icon'] }}" aria-hidden="true"></i>
                            </span>
                            <div class="min-w-0">
                                <div class="fs-4 fw-bold lh-1">{{ number_format($stat['value']) }}</div>
                                <div class="text-muted small mt-1">{{ $stat['label'] }}</div>
                                @if($stat['sub'])
                                    <div class="text-muted" style="font-size:.7rem">{{ $stat['sub'] }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Daily Chart + Device Breakdown --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-8">
                <div class="card border-0 h-100">
                    <div class="card-header bg-transparent border-0 pb-0 fw-semibold">
                        {{ app()->getLocale() === 'ar' ? 'الزيارات اليومية (آخر 30 يوم)' : 'Daily Visits (last 30 days)' }}
                    </div>
                    <div class="card-body pt-2">
                        <div id="chartVisits"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card border-0 h-100">
                    <div class="card-header bg-transparent border-0 pb-0 fw-semibold">
                        {{ app()->getLocale() === 'ar' ? 'توزيع الأجهزة' : 'Device Breakdown' }}
                    </div>
                    <div class="card-body pt-2 d-flex flex-column gap-2 justify-content-center">
                        @php
                            $deviceTotal = array_sum($deviceBreakdown) ?: 1;
                            $deviceLabels = ['desktop' => ['icon' => 'ph-monitor', 'color' => 'primary', 'ar' => 'سطح المكتب'],
                                             'mobile'  => ['icon' => 'ph-device-mobile', 'color' => 'success', 'ar' => 'جوال'],
                                             'tablet'  => ['icon' => 'ph-device-tablet', 'color' => 'warning', 'ar' => 'تابلت']];
                        @endphp
                        @foreach(['desktop','mobile','tablet'] as $dev)
                            @php
                                $cnt = $deviceBreakdown[$dev] ?? 0;
                            @endphp
                            @php
                                $pct = round($cnt / $deviceTotal * 100);
                            @endphp
                            <div>
                                <div class="d-flex justify-content-between mb-1 small">
                                    <span class="d-flex align-items-center gap-1">
                                        <i class="ph-duotone {{ $deviceLabels[$dev]['icon'] }} text-{{ $deviceLabels[$dev]['color'] }}"></i>
                                        {{ app()->getLocale() === 'ar' ? $deviceLabels[$dev]['ar'] : ucfirst($dev) }}
                                    </span>
                                    <span class="fw-semibold">{{ number_format($cnt) }} <span class="text-muted fw-normal">({{ $pct }}%)</span></span>
                                </div>
                                <div class="progress" style="height:6px">
                                    <div class="progress-bar bg-{{ $deviceLabels[$dev]['color'] }}" style="width:{{ $pct }}%"></div>
                                </div>
                            </div>
                        @endforeach

                        <hr class="my-2">

                        {{-- Browser breakdown --}}
                        <div class="fw-semibold small mb-1">{{ app()->getLocale() === 'ar' ? 'المتصفحات' : 'Browsers' }}</div>
                        @php
                            $browserTotal = array_sum($browserBreakdown) ?: 1;
                        @endphp
                        @foreach($browserBreakdown as $browser => $cnt)
                            <div class="d-flex justify-content-between small">
                                <span>{{ $browser }}</span>
                                <span class="text-muted">{{ number_format($cnt) }} ({{ round($cnt/$browserTotal*100) }}%)</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Pages + Recent Visits --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-5">
                <div class="card border-0 h-100">
                    <div class="card-header bg-transparent border-0 pb-0 fw-semibold">
                        {{ app()->getLocale() === 'ar' ? 'أكثر الصفحات زيارة' : 'Top Pages' }}
                    </div>
                    <div class="card-body pt-2">
                        @forelse($topPages as $page)
                            <div class="d-flex justify-content-between align-items-center py-1 border-bottom gap-2">
                                <span class="text-truncate small" style="max-width:75%" title="{{ $page->url }}">{{ $page->url }}</span>
                                <span class="badge bg-light-primary text-primary flex-shrink-0">{{ number_format($page->total) }}</span>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">{{ app()->getLocale() === 'ar' ? 'لا توجد بيانات بعد' : 'No data yet' }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-7">
                <div class="card border-0 h-100">
                    <div class="card-header bg-transparent border-0 pb-0 fw-semibold">
                        {{ app()->getLocale() === 'ar' ? 'آخر الزيارات' : 'Recent Visits' }}
                    </div>
                    <div class="card-body pt-2 p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>IP</th>
                                        <th>{{ app()->getLocale() === 'ar' ? 'الجهاز' : 'Device' }}</th>
                                        <th>{{ app()->getLocale() === 'ar' ? 'المتصفح' : 'Browser' }}</th>
                                        <th>{{ app()->getLocale() === 'ar' ? 'الوقت' : 'Time' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentVisits as $visit)
                                        <tr>
                                            <td class="small font-monospace">{{ $visit->ip }}</td>
                                            <td class="small">{{ $visit->device }}</td>
                                            <td class="small">{{ $visit->browser ?? '—' }}</td>
                                            <td class="small text-muted">{{ $visit->created_at?->diffForHumans() }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-muted text-center small py-3">{{ app()->getLocale() === 'ar' ? 'لا توجد زيارات بعد' : 'No visits yet' }}</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Access --}}
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
    <script src="{{ asset('admin') }}/assets/js/bundle/apexcharts.bundle.js"></script>
    <script>
    (function () {
        var dates  = @json($dailyChart['dates']);
        var counts = @json($dailyChart['counts']);

        new ApexCharts(document.querySelector('#chartVisits'), {
            chart: { type: 'area', height: 220, toolbar: { show: false }, sparkline: { enabled: false } },
            series: [{ name: '{{ app()->getLocale() === 'ar' ? 'زيارات' : 'Visits' }}', data: counts }],
            xaxis: { categories: dates, labels: { style: { fontSize: '11px' } } },
            yaxis: { labels: { style: { fontSize: '11px' } } },
            colors: ['#2d71f0'],
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: .35, opacityTo: .05 } },
            stroke: { curve: 'smooth', width: 2 },
            tooltip: { x: { show: true } },
            grid: { borderColor: '#f1f5f9' },
            dataLabels: { enabled: false },
        }).render();
    })();
    </script>
@endsection
