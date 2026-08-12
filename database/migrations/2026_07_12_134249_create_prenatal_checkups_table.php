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
        Schema::create('prenatal_checkups', function (Blueprint $table) {

            $table->id();

            // Relationship
            $table->foreignId('mother_id')
                ->constrained()
                ->cascadeOnDelete();

            // Visit Information
            $table->date('visit_date');

            // Pregnancy Progress
            $table->unsignedTinyInteger('gestational_age_weeks');

            // Maternal Assessment
            $table->decimal('weight', 5, 2);

            $table->unsignedSmallInteger('systolic_bp');

            $table->unsignedSmallInteger('diastolic_bp');

            $table->decimal('fundal_height', 5, 2)->nullable();

            $table->unsignedSmallInteger('fetal_heart_rate')->nullable();

            $table->string('fetal_movement')->nullable();

            $table->string('urine_protein')->nullable();

            $table->string('urine_glucose')->nullable();

            $table->text('maternal_condition')->nullable();

            $table->text('notes')->nullable();

            $table->date('next_visit_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prenatal_checkups');
    }
};