<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * One row per submission attempt to TextBee. Recipients are stored masked,
 * and errors are stored sanitised (no credentials, no full numbers).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_notification_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sms_notification_id')->constrained('sms_notifications')->cascadeOnDelete();
            $table->unsignedSmallInteger('attempt_number');
            $table->string('source', 20);                 // manual | scheduled
            $table->string('recipient_masked', 20);
            $table->string('outcome', 20)->default('sending'); // sending | accepted | rejected | not_submitted | unknown
            $table->string('gateway_batch_id', 100)->nullable();
            $table->unsignedSmallInteger('http_status')->nullable();
            $table->string('error', 500)->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('resolved_at')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('resolution', 20)->nullable();      // confirmed_sent | confirmed_failed | cancelled | gateway_status
            $table->string('resolution_note', 500)->nullable();
            $table->timestamps();

            $table->unique(['sms_notification_id', 'attempt_number'], 'sms_attempts_notification_number_unique');
            $table->index('outcome', 'sms_attempts_outcome_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_notification_attempts');
    }
};
