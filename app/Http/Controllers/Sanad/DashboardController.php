<?php

namespace App\Http\Controllers\Sanad;

use App\Http\Controllers\Controller;
use App\Services\Sanad\VisitService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(VisitService $visits): View
    {
        $data = [
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
