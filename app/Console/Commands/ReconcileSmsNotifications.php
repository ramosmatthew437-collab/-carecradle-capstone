<?php

namespace App\Console\Commands;

use App\Models\SmsNotification;
use App\Services\SmsDispatcher;
use Illuminate\Console\Command;

/**
 * Housekeeping for SMS notifications:
 * 1. interrupted sends (stuck in Sending) become Unknown for staff review;
 * 2. with --check-status, recently accepted batches are looked up on TextBee
 *    (read-only requests) to record what TextBee reports, e.g. delivered.
 * Nothing is ever re-sent by this command.
 */
class ReconcileSmsNotifications extends Command
{
    protected $signature = 'sms:reconcile {--check-status : Also look up recent TextBee batches} {--limit=25}';

    protected $description = 'Mark interrupted SMS sends for review and optionally refresh TextBee statuses';

    public function handle(SmsDispatcher $dispatcher): int
    {
        $released = $dispatcher->releaseStuck();
        $this->info("Interrupted sends marked Unknown: {$released}");

        if (! $this->option('check-status')) {
            return self::SUCCESS;
        }

        $due = SmsNotification::query()
            ->whereIn('status', ['Sent', 'Unknown'])
            ->whereNotNull('gateway_batch_id')
            ->whereNull('delivered_at')
            ->where(fn ($q) => $q->whereNull('gateway_delivery_status')->orWhereNotIn('gateway_delivery_status', ['delivered', 'failed']))
            ->where('last_attempt_at', '>=', now()->subDays(3))
            ->where(fn ($q) => $q->whereNull('delivery_checked_at')->orWhere('delivery_checked_at', '<', now()->subMinutes(30)))
            ->orderBy('last_attempt_at')
            ->limit(max(1, (int) $this->option('limit')))
            ->get();

        foreach ($due as $n) {
            $r = $dispatcher->checkStatus($n);
            $this->line("#{$n->id}: {$r['message']}");
        }

        $this->info("Status checks: {$due->count()}");

        return self::SUCCESS;
    }
}
