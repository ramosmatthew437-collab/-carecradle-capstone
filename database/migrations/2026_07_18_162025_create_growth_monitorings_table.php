<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('growth_monitorings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('infant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('date_measured');

            $table->integer('age_in_months');

            $table->decimal('weight', 5, 2);

            $table->decimal('height', 5, 2);

            $table->decimal('head_circumference', 5, 2)->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('growth_monitorings');
    }
};