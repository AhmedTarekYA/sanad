<?php

namespace App\Console\Commands;

use App\Services\Sanad\WhatsappBroadcastService;
use Illuminate\Console\Command;

class SendDueWhatsappBroadcasts extends Command
{
    protected $signature = 'whatsapp:send-due-broadcasts';

    protected $description = 'Send scheduled WhatsApp broadcasts that are due';

    public function handle(WhatsappBroadcastService $service): int
    {
        $sent = $service->sendDueBroadcasts();

        $this->info("Sent {$sent} due broadcast(s).");

        return self::SUCCESS;
    }
}
