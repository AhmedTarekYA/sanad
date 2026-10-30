<?php

namespace App\Http\Controllers\Sanad;

use App\Http\Controllers\Controller;
use App\Models\Sanad\WhatsAppClick;
use App\Services\Sanad\VisitService;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(VisitService $visits): View
    {
        $waTotal = WhatsAppClick::count();
        $waWeekly = WhatsAppClick::selectRaw('DATE(created_at) as day, COUNT(*) as clicks')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('clicks', 'day')
            ->toArray();

        // Fill missing days with 0
        $waDailyChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i)->format('Y-m-d');
            $waDailyChart[$day] = $waWeekly[$day] ?? 0;
        }

        $data = [
            'waTotal'     => $waTotal,
            'waDailyChart' => $waDailyChart,
            'todayCount' => $visits->todayCount(),
            'todayUnique' => $visits->todayUniqueCount(),
            'weekCount' => $visits->weekCount(),
            'monthCount' => $visits->monthCount(),
            'totalCount' => $visits->totalCount(),
            'uniqueCount' => $visits->uniqueCount(),
            'deviceBreakdown' => $visits->deviceBreakdown(),
            'browserBreakdown' => $visits->browserBreakdown(),
            'osBreakdown' => $visits->osBreakdown(),
            'topPages' => $visits->topPages(),
            'dailyChart' => $visits->dailyChart(),
            'recentVisits' => $visits->recentVisits(),
            'countryBreakdown' => $visits->countryBreakdown(),
            'avgSessionDuration' => $visits->avgSessionDuration(),
        ];

        return view('sanad.dashboard', $data);
    }
}
