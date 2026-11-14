<?php

namespace App\Services\Sanad;

use App\Models\CRM\CrmUser;
use App\Models\CRM\WhatsappContact;
use App\Models\CRM\WhatsappConversation;
use App\Models\CRM\WhatsappMessage;
use App\Services\MainService;
use Illuminate\Support\Carbon;

class WhatsappAnalyticsService extends MainService
{
    public function __construct(
        protected WhatsappMessage $message,
        protected WhatsappConversation $conversation,
        protected WhatsappContact $contact,
    ) {
        $this->model = $this->conversation;
        $this->fileFolder = null;
        $this->files = [];
    }

    /**
     * @return array<string, mixed>
     */
    public function summaryForUser(CrmUser $user, int $days): array
    {
        $userId = $user->id;
        $to = now();
        $from = now()->subDays($days)->startOfDay();

        $messagesQuery = fn () => $this->message->query()
            ->where('crm_user_id', $userId)
            ->whereBetween('wa_timestamp', [$from, $to]);

        $totalMessages = $messagesQuery()->count();
        $inboundMessages = $messagesQuery()->where('direction', 'in')->count();
        $outboundMessages = $messagesQuery()->where('direction', 'out')->count();

        $conversationsQuery = fn () => $this->conversation->query()
            ->where('crm_user_id', $userId);

        $totalConversations = $conversationsQuery()
            ->whereBetween('last_message_at', [$from, $to])
            ->count();

        $newConversations = $conversationsQuery()
            ->whereBetween('created_at', [$from, $to])
            ->count();

        [$responseRate, $avgResponseMinutes, $avgResponseHuman] = $this->responseStats($userId, $from, $to);

        $trend = $this->monthlyTrend($userId);

        $sourceCounts = $this->sourceBreakdown($userId, $from, $to);
        $sourceTotal = array_sum($sourceCounts);
        $sourcesPct = [];
        foreach ($sourceCounts as $source => $count) {
            $sourcesPct[$source] = $sourceTotal > 0
                ? (int) round(($count / $sourceTotal) * 100)
                : 0;
        }

        return [
            'days' => $days,
            'from' => $from->toDateTimeString(),
            'to' => $to->toDateTimeString(),
            'totalMessages' => $totalMessages,
            'inboundMessages' => $inboundMessages,
            'outboundMessages' => $outboundMessages,
            'totalConversations' => $totalConversations,
            'newConversations' => $newConversations,
            'responseRate' => $responseRate,
            'avgResponseMinutes' => $avgResponseMinutes,
            'avgResponseHuman' => $avgResponseHuman,
            'trend' => $trend,
            'sources' => $sourceCounts,
            'sourcesPct' => $sourcesPct,
        ];
    }

    /**
     * @return array{0: int|null, 1: float|null, 2: string|null}
     */
    private function responseStats(int $userId, Carbon $from, Carbon $to): array
    {
        $rows = $this->message->query()
            ->where('crm_user_id', $userId)
            ->whereBetween('wa_timestamp', [$from, $to])
            ->select('conversation_id')
            ->selectRaw("MIN(CASE WHEN direction = 'in' THEN wa_timestamp END) as first_in_at")
            ->selectRaw("MIN(CASE WHEN direction = 'out' THEN wa_timestamp END) as first_out_at")
            ->groupBy('conversation_id')
            ->get();

        $inboundConversations = 0;
        $respondedConversations = 0;
        $responseMinutesSum = 0;

        foreach ($rows as $row) {
            $firstIn = $row->first_in_at ? Carbon::parse($row->first_in_at) : null;
            $firstOut = $row->first_out_at ? Carbon::parse($row->first_out_at) : null;

            if (! $firstIn) {
                continue;
            }

            $inboundConversations++;

            if ($firstOut && $firstOut->greaterThanOrEqualTo($firstIn)) {
                $respondedConversations++;
                $responseMinutesSum += $firstOut->diffInMinutes($firstIn);
            }
        }

        $responseRate = $inboundConversations > 0
            ? (int) round(($respondedConversations / $inboundConversations) * 100)
            : null;

        $avgResponseMinutes = $respondedConversations > 0
            ? round($responseMinutesSum / $respondedConversations, 1)
            : null;

        $avgResponseHuman = $avgResponseMinutes === null
            ? null
            : ($avgResponseMinutes >= 60
                ? rtrim(rtrim(number_format($avgResponseMinutes / 60, 1, '.', ''), '0'), '.').'h'
                : rtrim(rtrim(number_format($avgResponseMinutes, 1, '.', ''), '0'), '.').'m');

        return [$responseRate, $avgResponseMinutes, $avgResponseHuman];
    }

    /**
     * @return array{labels: array<int, string>, counts: array<int, int>}
     */
    private function monthlyTrend(int $userId): array
    {
        $labels = [];
        $counts = [];

        $start = now()->startOfMonth()->subMonths(5);

        for ($i = 0; $i < 6; $i++) {
            $monthStart = $start->copy()->addMonths($i)->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();

            $labels[] = $monthStart->format('M Y');
            $counts[] = $this->conversation->query()
                ->where('crm_user_id', $userId)
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();
        }

        return ['labels' => $labels, 'counts' => $counts];
    }

    /**
     * @return array<string, int>
     */
    private function sourceBreakdown(int $userId, Carbon $from, Carbon $to): array
    {
        $rows = $this->contact->query()
            ->where('crm_user_id', $userId)
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw("COALESCE(source, '') as src")
            ->selectRaw('COUNT(*) as total')
            ->groupBy('src')
            ->get();

        $sources = [
            'organic' => 0,
            'broadcast' => 0,
            'ads' => 0,
            'other' => 0,
        ];

        foreach ($rows as $row) {
            $src = strtolower(trim((string) $row->src));
            $count = (int) $row->total;

            if ($src === '' || str_contains($src, 'organic')) {
                $sources['organic'] += $count;
            } elseif (str_contains($src, 'broadcast')) {
                $sources['broadcast'] += $count;
            } elseif (str_contains($src, 'ad') || str_contains($src, 'campaign')) {
                $sources['ads'] += $count;
            } else {
                $sources['other'] += $count;
            }
        }

        return $sources;
    }
}
