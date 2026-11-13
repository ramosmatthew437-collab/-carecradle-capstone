<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Additive: records what started each reminder run.
 * - scheduler: Laravel's scheduler (the command was called with --scheduled)
 * - cli:       someone ran the command by hand
 * Only scheduler runs count as evidence that automatic reminders are running.
 * Existing rows (if any) are treated as manual CLI runs.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sms_scheduler_runs', function (Blueprint $table) {
            $table->string('trigger', 20)->default('cli')->after('command');
            $table->index(['command', 'trigger', 'started_at'], 'sms_runs_command_trigger_started_index');
        });
    }

    public function down(): void
    {
        Schema::table('sms_scheduler_runs', function (Blueprint $table) {
            $table->dropIndex('sms_runs_command_trigger_started_index');
            $table->dropColumn('trigger');
        });
    }
};
