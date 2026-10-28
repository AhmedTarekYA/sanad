<?php

namespace App\Services\Sanad;

use App\Models\Visit;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VisitService
{
    public function todayCount(): int
    {
        return Visit::whereDate('created_at', today())->count();
    }

    public function weekCount(): int
    {
        return Visit::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
    }

    public function monthCount(): int
    {
        return Visit::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    public function totalCount(): int
    {
        return Visit::count();
    }

    public function uniqueCount(): int
    {
        return Visit::where('is_unique', true)->count();
    }

    public function todayUniqueCount(): int
    {
        return Visit::whereDate('created_at', today())->where('is_unique', true)->count();
    }

    /** @return array<string, int> */
    public function deviceBreakdown(): array
    {
        return Visit::select('device', DB::raw('count(*) as total'))
            ->groupBy('device')
            ->pluck('total', 'device')
            ->toArray();
    }

    /** @return array<string, int> */
    public function browserBreakdown(): array
    {
        return Visit::select('browser', DB::raw('count(*) as total'))
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('total')
            ->limit(6)
            ->pluck('total', 'browser')
            ->toArray();
    }

    /** @return Collection<int, object> */
    public function topPages(): Collection
    {
        return Visit::select('url', DB::raw('count(*) as total'))
            ->whereNotNull('url')
            ->groupBy('url')
            ->orderByDesc('total')
            ->limit(8)
            ->get();
    }

    /**
     * Daily visit counts for the last 30 days.
     *
     * @return array{dates: array<int, string>, counts: array<int, int>}
     */
    public function dailyChart(): array
    {
        $rows = Visit::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $dates = [];
        $counts = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates[] = now()->subDays($i)->format('d/m');
            $counts[] = $rows[$date] ?? 0;
        }

        return ['dates' => $dates, 'counts' => $counts];
    }

    /** @return Collection<int, Visit> */
    public function recentVisits(): Collection
    {
        return Visit::latest('created_at')->limit(10)->get();
    }

    /**
     * Top countries by visit count.
     *
     * @return Collection<int, object>
     */
    public function countryBreakdown(): Collection
    {
        return Visit::select('country', 'country_code', DB::raw('count(*) as total'))
            ->whereNotNull('country_code')
            ->groupBy('country', 'country_code')
            ->orderByDesc('total')
            ->limit(10)
            ->get();
    }

    /**
     * OS breakdown (Android, iOS, Windows, macOS, Linux…).
     *
     * @return array<string, int>
     */
    public function osBreakdown(): array
    {
        return Visit::select('os', DB::raw('count(*) as total'))
            ->whereNotNull('os')
            ->groupBy('os')
            ->orderByDesc('total')
            ->limit(8)
            ->pluck('total', 'os')
            ->toArray();
    }

    /**
     * Average session duration in seconds (sessions with >1 page view).
     */
    public function avgSessionDuration(): int
    {
        $result = DB::select('
            SELECT COALESCE(AVG(duration), 0) AS avg_duration
            FROM (
                SELECT session_id, TIMESTAMPDIFF(SECOND, MIN(created_at), MAX(created_at)) AS duration
                FROM visits
                WHERE session_id IS NOT NULL
                GROUP BY session_id
                HAVING COUNT(*) > 1
            ) AS sessions
        ');

        return (int) round($result[0]->avg_duration ?? 0);
    }
}
