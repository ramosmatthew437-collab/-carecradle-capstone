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
        Schema::create('mothers', function (Blueprint $table) {

            // Primary Key
            $table->id();

            // Login Account Relationship
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Mother Information
            $table->string('mother_code')->unique();

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');

            $table->date('birth_date');

            $table->string('contact_number', 20);

            $table->text('address');

            $table->string('barangay');

            $table->string('blood_type', 5);

            $table->string('civil_status');

            $table->string('occupation')->nullable();

            $table->string('philhealth_number')->nullable();

            // Pregnancy Information
            $table->decimal('height', 5, 2);

            $table->decimal('weight', 5, 2);

            $table->date('last_menstrual_period');

            $table->date('expected_delivery_date');

            $table->unsignedTinyInteger('pregnancy_number');

            $table->enum('status', [
                'Pregnant',
                'Delivered',
                'Referred'
            ])->default('Pregnant');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mothers');
    }
};