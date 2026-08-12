<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sms_notifications', function (Blueprint $table) {

    $table->id();

    // Mother who received the SMS
    $table->foreignId('mother_id')
          ->constrained('mothers')
          ->cascadeOnDelete();

    // Appointment related to this SMS (optional)
    $table->foreignId('appointment_id')
          ->nullable()
          ->constrained('appointments')
          ->nullOnDelete();

    // SMS Details
    $table->string('recipient_number', 20);

    $table->text('message');

    $table->enum('notification_type', [
        'Appointment Reminder',
        'Vaccination Reminder',
        'Health Tip',
        'General Announcement'
    ]);

    $table->enum('status', [
        'Pending',
        'Sent',
        'Failed'
    ])->default('Pending');

    $table->timestamp('sent_at')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_notifications');
    }
};
