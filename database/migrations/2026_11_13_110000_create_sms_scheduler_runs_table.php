<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * One row per real execution of the automatic reminder command: written when
 * the command starts and completed when it finishes. This is the heartbeat the
 * SMS Notifications page uses; a configured schedule alone is not evidence
 * that reminders are running. Dry runs are not recorded.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_scheduler_runs', function (Blueprint $table) {
            $table->id();
            $table->string('command', 100);
            $table->string('status', 20)->default('running'); // running | completed | failed
            $table->timestamp('started_at');
            $table->timestamp('finished_at')->nullable();
            $table->unsignedInteger('processed')->default(0);
            $table->unsignedInteger('sent')->default(0);
            $table->unsignedInteger('failed')->default(0);
            $table->unsignedInteger('unknown')->default(0);
            $table->unsignedInteger('skipped')->default(0);
            $table->string('error', 300)->nullable();
            $table->string('host', 100)->nullable();
            $table->timestamps();

            $table->index(['command', 'started_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_scheduler_runs');
    }
};
