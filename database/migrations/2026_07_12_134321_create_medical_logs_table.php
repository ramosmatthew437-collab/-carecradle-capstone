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
        Schema::create('medical_logs', function (Blueprint $table) {

    $table->id();

    // Relationship
    $table->foreignId('mother_id')
          ->constrained('mothers')
          ->cascadeOnDelete();

    // Medical Information
    $table->date('log_date');

    $table->string('diagnosis');

    $table->text('treatment')->nullable();

    $table->text('prescription')->nullable();

    $table->text('remarks')->nullable();

    $table->boolean('referred_to_hospital')->default(false);

    $table->string('referred_hospital')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_logs');
    }
};
