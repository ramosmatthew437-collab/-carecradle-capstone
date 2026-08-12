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
       Schema::create('infants', function (Blueprint $table) {

    $table->id();

    // Relationship
    $table->foreignId('mother_id')
          ->constrained('mothers')
          ->cascadeOnDelete();

    // Infant Information
    $table->string('first_name');

    $table->string('middle_name')->nullable();

    $table->string('last_name');

    $table->enum('sex', [
        'Male',
        'Female'
    ]);

    $table->date('birth_date');

    $table->decimal('birth_weight', 5, 2);

    $table->decimal('birth_length', 5, 2);

    $table->decimal('head_circumference', 5, 2)->nullable();

    $table->enum('birth_status', [
        'Alive',
        'Stillbirth'
    ])->default('Alive');

    $table->text('remarks')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infants');
    }
};
