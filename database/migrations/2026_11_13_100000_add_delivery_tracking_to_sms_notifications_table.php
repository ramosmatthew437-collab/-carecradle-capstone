<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Additive only: widens the status list and adds tracking columns.
 * Existing rows keep their values (Pending / Sent / Failed are unchanged).
 *
 * "Sent" means TextBee accepted the request, not that the phone received it.
 * delivered_at is written only from a verified TextBee status response.
 */
return new class extends Migration
{
    private const OLD = ['Pending', 'Sent', 'Failed'];

    private const NEW = ['Pending', 'Sending', 'Sent', 'Failed', 'Unknown', 'Cancelled', 'Expired'];

    public function up(): void
    {
        $this->setStatuses(self::NEW);

        Schema::table('sms_notifications', function (Blueprint $table) {
            $table->unsignedSmallInteger('attempts')->default(0)->after('status');
            $table->string('attempt_token', 36)->nullable()->after('attempts');
            $table->timestamp('sending_started_at')->nullable()->after('attempt_token');
            $table->timestamp('last_attempt_at')->nullable()->after('sending_started_at');
            $table->string('gateway_batch_id', 100)->nullable()->after('last_attempt_at');
            $table->unsignedSmallInteger('gateway_status_code')->nullable()->after('gateway_batch_id');
            $table->string('gateway_delivery_status', 20)->nullable()->after('gateway_status_code');
            $table->timestamp('delivery_checked_at')->nullable()->after('gateway_delivery_status');
            $table->timestamp('delivered_at')->nullable()->after('sent_at');
            $table->string('status_note', 500)->nullable()->after('error_message');
            $table->string('closed_reason', 40)->nullable()->after('status_note');
            $table->json('appointment_snapshot')->nullable()->after('closed_reason');
            $table->foreignId('reviewed_by')->nullable()->after('appointment_snapshot')->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');

            $table->index('status');
            $table->index(['status', 'sending_started_at']);
        });
    }

    public function down(): void
    {
        $inUse = DB::table('sms_notifications')->whereNotIn('status', self::OLD)->count();

        if ($inUse > 0) {
            throw new RuntimeException("Cannot roll back: {$inUse} SMS notification(s) use the new statuses. Review them first; nothing was changed.");
        }

        Schema::table('sms_notifications', function (Blueprint $table) {
            $table->dropIndex(['status', 'sending_started_at']);
            $table->dropIndex(['status']);
            $table->dropConstrainedForeignId('reviewed_by');
            $table->dropColumn([
                'attempts', 'attempt_token', 'sending_started_at', 'last_attempt_at', 'gateway_batch_id',
                'gateway_status_code', 'gateway_delivery_status', 'delivery_checked_at', 'delivered_at',
                'status_note', 'closed_reason', 'appointment_snapshot', 'reviewed_at',
            ]);
        });

        $this->setStatuses(self::OLD);
    }

    private function setStatuses(array $statuses): void
    {
        if (in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE sms_notifications MODIFY status ENUM('" . implode("','", $statuses) . "') NOT NULL DEFAULT 'Pending'");

            return;
        }

        // Other drivers (e.g. SQLite in the test suite).
        Schema::table('sms_notifications', fn (Blueprint $table) => $table->enum('status', $statuses)->default('Pending')->change());
    }
};
