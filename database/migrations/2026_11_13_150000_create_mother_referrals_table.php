<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Additive: referral history for mothers.
 *
 * Referral is separate from pregnancy status (mothers.status stays
 * Pregnant / Delivered). A mother is "Referred" while she has an Active
 * referral. Referrals are never deleted through the application; a mistake is
 * marked "Entered in error" with a reason.
 *
 * Existing records are not changed. The one legacy mother whose
 * mothers.status is 'Referred' keeps that value (pregnancy status unknown);
 * no referral row, date or facility is invented for her.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mother_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mother_id')->constrained('mothers')->cascadeOnDelete();

            $table->date('referred_at');
            $table->text('reason');
            $table->string('receiving_facility', 255);
            $table->foreignId('referred_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('referred_by_name', 255)->nullable(); // kept if the account is later removed
            $table->text('notes')->nullable();

            $table->string('status', 20)->default('Active'); // Active | Closed | Entered in error

            // Follow-up (free text; no fixed clinical outcome list).
            $table->date('outcome_at')->nullable();
            $table->text('outcome_notes')->nullable();
            $table->string('outcome_source', 255)->nullable(); // where the follow-up information came from

            $table->timestamp('closed_at')->nullable();
            $table->foreignId('closed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('closed_by_name', 255)->nullable();

            $table->string('voided_reason', 500)->nullable();
            $table->timestamp('voided_at')->nullable();
            $table->foreignId('voided_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('voided_by_name', 255)->nullable();

            $table->timestamps();

            $table->index(['mother_id', 'status'], 'mother_referrals_mother_status_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mother_referrals');
    }
};
