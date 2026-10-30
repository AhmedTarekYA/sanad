@extends('sanad.layout.indexs.index')

@section('page-title')
    {{ trans('auth.home') }}
@endsection

@section('content')
    @php
        $authUser = getAuthUser();
        $isAr = app()->getLocale() === 'ar';

        // Format seconds → "Xm Ys"
        $avgMin = intdiv($avgSessionDuration, 60);
        $avgSec = $avgSessionDuration % 60;
        $avgLabel = $avgMin > 0 ? "{$avgMin} دق {$avgSec} ث" : "{$avgSec} ث";
        if (!$isAr) { $avgLabel = $avgMin > 0 ? "{$avgMin}m {$avgSec}s" : "{$avgSec}s"; }

        $osIcons = [
            'Android'    => ['icon' => 'ph-android-logo',  'color' => 'success'],
            'iOS'        => ['icon' => 'ph-apple-logo',    'color' => 'dark'],
            'Windows'    => ['icon' => 'ph-windows-logo',  'color' => 'primary'],
            'OS X'       => ['icon' => 'ph-apple-logo',    'color' => 'secondary'],
            'macOS'      => ['icon' => 'ph-apple-logo',    'color' => 'secondary'],
            'Linux'      => ['icon' => 'ph-linux-logo',    'color' => 'warning'],
            'Ubuntu'     => ['icon' => 'ph-linux-logo',    'color' => 'warning'],
            'Chrome OS'  => ['icon' => 'ph-google-chrome-logo', 'color' => 'info'],
        ];
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
                                <p class="mb-0">{{ $isAr ? 'إدارة مشروعك تبدأ من هنا. اختر مساحة العمل التي تريد الوصول إليها.' : 'Manage your workspace from one place. Choose where you want to start.' }}</p>
                            </div>
                            <img src="{{ asset('admin/assets/img/earth.png') }}" alt="" class="dashboard-welcome-img" aria-hidden="true">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── WhatsApp Stats ── --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-4">
                <div class="card border-0 h-100" style="border-inline-start: 4px solid #25d366 !important;">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="dashboard-tile-icon flex-shrink-0" style="background:rgba(37,211,102,.12);color:#25d366;">
                            <svg width="22" height="22" viewBox="0 0 32 32" fill="currentColor"><path d="M16 0C7.164 0 0 7.164 0 16c0 2.825.745 5.482 2.041 7.783L.057 31.72a.667.667 0 00.823.823l7.937-1.984A15.933 15.933 0 0016 32c8.836 0 16-7.164 16-16S24.836 0 16 0zm9.208 22.792c-.384.384-1.579 1.192-2.171 1.192-.592 0-1.133-.267-2.683-1.049-1.133-.571-2.563-1.429-4.272-3.136-1.707-1.709-2.565-3.139-3.136-4.272-.782-1.55-1.049-2.091-1.049-2.683 0-.592.808-1.787 1.192-2.171.272-.272.635-.397.981-.397.171 0 .333.029.469.085.171.072.363.2.573.381.389.336.853.859 1.363 1.531.653.861 1.115 1.779 1.115 2.096 0 .205-.027.353-.091.512-.085.208-.235.397-.477.717-.139.184-.304.397-.488.64-.048.064-.096.131-.141.2.4.848 1.0 1.717 1.781 2.5.784.784 1.653 1.381 2.5 1.781.069-.045.136-.093.2-.141.243-.184.456-.349.64-.488.32-.242.509-.392.717-.477.159-.064.307-.091.512-.091.317 0 1.235.462 2.096 1.115.672.51 1.195.974 1.531 1.363.181.21.309.402.381.573.056.136.085.298.085.469 0 .346-.125.709-.397.981z"/></svg>
                        </span>
                        <div>
                            <div class="fs-3 fw-bold lh-1">{{ number_format($waTotal) }}</div>
                            <div class="text-muted small mt-1">{{ $isAr ? 'إجمالي ضغطات واتساب' : 'Total WhatsApp Clicks' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card border-0 h-100">
                    <div class="card-header bg-transparent border-0 pb-0 fw-semibold d-flex align-items-center gap-2">
                        <svg width="16" height="16" viewBox="0 0 32 32" fill="#25d366"><path d="M16 0C7.164 0 0 7.164 0 16c0 2.825.745 5.482 2.041 7.783L.057 31.72a.667.667 0 00.823.823l7.937-1.984A15.933 15.933 0 0016 32c8.836 0 16-7.164 16-16S24.836 0 16 0zm9.208 22.792c-.384.384-1.579 1.192-2.171 1.192-.592 0-1.133-.267-2.683-1.049-1.133-.571-2.563-1.429-4.272-3.136-1.707-1.709-2.565-3.139-3.136-4.272-.782-1.55-1.049-2.091-1.049-2.683 0-.592.808-1.787 1.192-2.171.272-.272.635-.397.981-.397.171 0 .333.029.469.085.171.072.363.2.573.381.389.336.853.859 1.363 1.531.653.861 1.115 1.779 1.115 2.096 0 .205-.027.353-.091.512-.085.208-.235.397-.477.717-.139.184-.304.397-.488.64-.048.064-.096.131-.141.2.4.848 1.0 1.717 1.781 2.5.784.784 1.653 1.381 2.5 1.781.069-.045.136-.093.2-.141.243-.184.456-.349.64-.488.32-.242.509-.392.717-.477.159-.064.307-.091.512-.091.317 0 1.235.462 2.096 1.115.672.51 1.195.974 1.531 1.363.181.21.309.402.381.573.056.136.085.298.085.469 0 .346-.125.709-.397.981z"/></svg>
                        {{ $isAr ? 'ضغطات واتساب — آخر 7 أيام' : 'WhatsApp Clicks — Last 7 Days' }}
                    </div>
                    <div class="card-body pt-2">
                        <div class="d-flex align-items-end gap-2 h-100" style="min-height:80px;">
                            @php $waMax = max(array_values($waDailyChart) ?: [1]); @endphp
                            @foreach($waDailyChart as $day => $clicks)
                                @php
                                    $barH   = $waMax > 0 ? round($clicks / $waMax * 100) : 0;
                                    $dayLabel = \Carbon\Carbon::parse($day)->locale($isAr ? 'ar' : 'en')->isoFormat('ddd D/M');
                                    $isToday  = $day === now()->format('Y-m-d');
                                @endphp
                                <div class="d-flex flex-column align-items-center flex-fill gap-1" title="{{ $dayLabel }}: {{ $clicks }}">
                                    <span class="small fw-semibold {{ $clicks > 0 ? 'text-success' : 'text-muted' }}">{{ $clicks }}</span>
                                    <div style="width:100%;height:70px;display:flex;align-items:flex-end;">
                                        <div style="width:100%;height:{{ max($barH,4) }}%;background:{{ $isToday ? '#25d366' : '#a8e6c3' }};border-radius:4px 4px 0 0;transition:height .3s;"></div>
                                    </div>
                                    <span class="text-muted" style="font-size:.65rem;white-space:nowrap;">{{ \Carbon\Carbon::parse($day)->isoFormat('D/M') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Visitor Stats ── --}}
        <div class="dashboard-section-heading">
            <div>
                <h2>{{ $isAr ? 'إحصائيات الزوار' : 'Visitor Analytics' }}</h2>
                <p>{{ $isAr ? 'تتبع زوار الموقع في الوقت الفعلي' : 'Real-time website visitor tracking' }}</p>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="row g-3 mb-4">
            @php
                $stats = [
                    ['icon' => 'ph-eye',           'color' => 'primary',  'label' => $isAr ? 'زيارات اليوم'        : 'Today',            'value' => number_format($todayCount),  'sub' => $todayUnique.' '.($isAr?'جديد':'unique')],
                    ['icon' => 'ph-calendar-week', 'color' => 'info',     'label' => $isAr ? 'هذا الأسبوع'        : 'This Week',         'value' => number_format($weekCount),   'sub' => ''],
                    ['icon' => 'ph-calendar-dots', 'color' => 'warning',  'label' => $isAr ? 'هذا الشهر'          : 'This Month',        'value' => number_format($monthCount),  'sub' => ''],
                    ['icon' => 'ph-users-three',   'color' => 'success',  'label' => $isAr ? 'زوار جُدد'           : 'Unique Visitors',   'value' => number_format($uniqueCount), 'sub' => number_format($totalCount).' '.($isAr?'إجمالي':'total')],
                    ['icon' => 'ph-timer',         'color' => 'purple',   'label' => $isAr ? 'متوسط مدة الجلسة'  : 'Avg. Session',      'value' => $avgLabel,                   'sub' => $isAr ? 'لكل جلسة' : 'per session'],
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="col-6 col-lg">
                    <div class="card h-100 border-0">
                        <div class="card-body d-flex align-items-center gap-3">
                            <span class="dashboard-tile-icon bg-light-{{ $stat['color'] }} text-{{ $stat['color'] }} flex-shrink-0">
                                <i class="ph-duotone {{ $stat['icon'] }}" aria-hidden="true"></i>
                            </span>
                            <div class="min-w-0">
                                <div class="fs-4 fw-bold lh-1">{{ $stat['value'] }}</div>
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
                        {{ $isAr ? 'الزيارات اليومية (آخر 30 يوم)' : 'Daily Visits (last 30 days)' }}
                    </div>
                    <div class="card-body pt-2">
                        <div id="chartVisits"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card border-0 h-100">
                    <div class="card-header bg-transparent border-0 pb-0 fw-semibold">
                        {{ $isAr ? 'الأجهزة والمتصفحات' : 'Devices & Browsers' }}
                    </div>
                    <div class="card-body pt-2 d-flex flex-column gap-2 justify-content-center">
                        @php
                            $deviceTotal = array_sum($deviceBreakdown) ?: 1;
                            $deviceLabels = [
                                'desktop' => ['icon' => 'ph-monitor',        'color' => 'primary', 'ar' => 'كمبيوتر'],
                                'mobile'  => ['icon' => 'ph-device-mobile',  'color' => 'success', 'ar' => 'جوال'],
                                'tablet'  => ['icon' => 'ph-device-tablet',  'color' => 'warning', 'ar' => 'تابلت'],
                            ];
                        @endphp
                        @foreach(['desktop','mobile','tablet'] as $dev)
                            @php $cnt = $deviceBreakdown[$dev] ?? 0; $pct = round($cnt / $deviceTotal * 100); @endphp
                            <div>
                                <div class="d-flex justify-content-between mb-1 small">
                                    <span class="d-flex align-items-center gap-1">
                                        <i class="ph-duotone {{ $deviceLabels[$dev]['icon'] }} text-{{ $deviceLabels[$dev]['color'] }}"></i>
                                        {{ $isAr ? $deviceLabels[$dev]['ar'] : ucfirst($dev) }}
                                    </span>
                                    <span class="fw-semibold">{{ number_format($cnt) }} <span class="text-muted fw-normal">({{ $pct }}%)</span></span>
                                </div>
                                <div class="progress" style="height:6px">
                                    <div class="progress-bar bg-{{ $deviceLabels[$dev]['color'] }}" style="width:{{ $pct }}%"></div>
                                </div>
                            </div>
                        @endforeach

                        <hr class="my-2">
                        <div class="fw-semibold small mb-1">{{ $isAr ? 'المتصفحات' : 'Browsers' }}</div>
                        @php $browserTotal = array_sum($browserBreakdown) ?: 1; @endphp
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

        {{-- Countries + OS Breakdown --}}
        <div class="row g-3 mb-4">
            {{-- Countries with flags --}}
            <div class="col-12 col-lg-7">
                <div class="card border-0 h-100">
                    <div class="card-header bg-transparent border-0 pb-0 d-flex align-items-center justify-content-between">
                        <span class="fw-semibold">{{ $isAr ? '🌍 الدول الأكثر زيارة' : '🌍 Top Countries' }}</span>
                        <span class="badge bg-light-primary text-primary small">{{ $isAr ? 'أعلى 10' : 'Top 10' }}</span>
                    </div>
                    <div class="card-body pt-3">
                        @php $countryTotal = $countryBreakdown->sum('total') ?: 1; @endphp
                        @forelse($countryBreakdown as $index => $row)
                            @php $pct = round($row->total / $countryTotal * 100); @endphp
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <span class="fw-bold text-muted" style="width:18px;font-size:.75rem">{{ $index+1 }}</span>
                                <img src="https://flagcdn.com/w28/{{ $row->country_code }}.png"
                                     srcset="https://flagcdn.com/w56/{{ $row->country_code }}.png 2x"
                                     width="24" height="16"
                                     alt="{{ $row->country }}"
                                     style="border-radius:2px;object-fit:cover;flex-shrink:0"
                                     onerror="this.style.display='none'">
                                <div class="flex-grow-1 min-w-0">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="small fw-medium text-truncate" style="max-width:65%">{{ $row->country ?? strtoupper($row->country_code) }}</span>
                                        <span class="small text-muted flex-shrink-0">{{ number_format($row->total) }} <span class="text-muted">({{ $pct }}%)</span></span>
                                    </div>
                                    <div class="progress" style="height:5px">
                                        <div class="progress-bar bg-primary" style="width:{{ $pct }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                                <i class="ph-duotone ph-globe" style="font-size:2rem"></i>
                                <p class="small mt-2 mb-0">{{ $isAr ? 'لا توجد بيانات دول بعد — ستظهر مع الزيارات القادمة' : 'No country data yet — will appear with upcoming visits' }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- OS Breakdown --}}
            <div class="col-12 col-lg-5">
                <div class="card border-0 h-100">
                    <div class="card-header bg-transparent border-0 pb-0 fw-semibold">
                        {{ $isAr ? '📱 أنظمة التشغيل' : '📱 Operating Systems' }}
                    </div>
                    <div class="card-body pt-3">
                        @php $osTotal = array_sum($osBreakdown) ?: 1; @endphp
                        @forelse($osBreakdown as $os => $cnt)
                            @php
                                $pct = round($cnt / $osTotal * 100);
                                $osConf = $osIcons[$os] ?? ['icon' => 'ph-monitor', 'color' => 'secondary'];
                            @endphp
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="d-flex align-items-center gap-2 small fw-medium">
                                        <i class="ph-duotone {{ $osConf['icon'] }} text-{{ $osConf['color'] }}" style="font-size:1.1rem"></i>
                                        {{ $os }}
                                    </span>
                                    <span class="small text-muted">{{ number_format($cnt) }} ({{ $pct }}%)</span>
                                </div>
                                <div class="progress" style="height:6px">
                                    <div class="progress-bar bg-{{ $osConf['color'] }}" style="width:{{ $pct }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">{{ $isAr ? 'لا توجد بيانات بعد' : 'No data yet' }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Pages + Recent Visits --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-5">
                <div class="card border-0 h-100">
                    <div class="card-header bg-transparent border-0 pb-0 fw-semibold">
                        {{ $isAr ? 'أكثر الصفحات زيارة' : 'Top Pages' }}
                    </div>
                    <div class="card-body pt-2">
                        @forelse($topPages as $page)
                            <div class="d-flex justify-content-between align-items-center py-1 border-bottom gap-2">
                                <span class="text-truncate small" style="max-width:75%" title="{{ $page->url }}">{{ $page->url }}</span>
                                <span class="badge bg-light-primary text-primary flex-shrink-0">{{ number_format($page->total) }}</span>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">{{ $isAr ? 'لا توجد بيانات بعد' : 'No data yet' }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-7">
                <div class="card border-0 h-100">
                    <div class="card-header bg-transparent border-0 pb-0 fw-semibold">
                        {{ $isAr ? 'آخر الزيارات' : 'Recent Visits' }}
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>IP</th>
                                        <th>{{ $isAr ? 'الدولة' : 'Country' }}</th>
                                        <th>{{ $isAr ? 'الجهاز' : 'Device' }}</th>
                                        <th>{{ $isAr ? 'النظام' : 'OS' }}</th>
                                        <th>{{ $isAr ? 'الوقت' : 'Time' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentVisits as $visit)
                                        <tr>
                                            <td class="small font-monospace">{{ $visit->ip }}</td>
                                            <td class="small">
                                                @if($visit->country_code)
                                                    <img src="https://flagcdn.com/w20/{{ $visit->country_code }}.png" width="16" height="12" alt="{{ $visit->country }}" style="border-radius:1px" onerror="this.style.display='none'">
                                                    <span class="ms-1">{{ $visit->country ?? strtoupper($visit->country_code) }}</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="small">{{ $visit->device }}</td>
                                            <td class="small">{{ $visit->os ?? '—' }}</td>
                                            <td class="small text-muted">{{ $visit->created_at?->diffForHumans() }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-muted text-center small py-3">{{ $isAr ? 'لا توجد زيارات بعد' : 'No visits yet' }}</td></tr>
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
                <h2>{{ $isAr ? 'الوصول السريع' : 'Quick access' }}</h2>
                <p>{{ $isAr ? 'الأماكن التي تستخدمها بشكل متكرر' : 'Your most-used workspaces' }}</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card dashboard-tile h-100">
                    <div class="card-body">
                        <span class="dashboard-tile-icon bg-light-primary text-primary"><i class="ph-duotone ph-gauge" aria-hidden="true"></i></span>
                        <h3>{{ __('auth.home') }}</h3>
                        <p class="mb-0">{{ $isAr ? 'نظرة عامة على مساحة العمل' : 'Your workspace overview' }}</p>
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
                            <p class="mb-0">{{ $isAr ? 'تحكم في إعدادات الموقع والمظهر' : 'Control site settings and appearance' }}</p>
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
                            <p class="mb-0">{{ $isAr ? 'إدارة المستخدمين والأدوار والصلاحيات' : 'Manage users, roles and permissions' }}</p>
                        </div>
                    </a>
                </div>
            @endif
        </div>

    </div>
@endsection

@section('style')
    <style>
        .dashboard-tile .dashboard-tile-icon i { pointer-events: none; }
    </style>
@endsection

@section('js')
    <script src="{{ asset('admin') }}/assets/js/bundle/apexcharts.bundle.js"></script>
    <script>
    (function () {
        var dates  = @json($dailyChart['dates']);
        var counts = @json($dailyChart['counts']);

        new ApexCharts(document.querySelector('#chartVisits'), {
            chart: { type: 'area', height: 220, toolbar: { show: false } },
            series: [{ name: '{{ $isAr ? 'زيارات' : 'Visits' }}', data: counts }],
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
