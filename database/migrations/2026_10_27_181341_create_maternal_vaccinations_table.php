
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maternal_vaccinations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mother_id')
                ->constrained('mothers')
                ->cascadeOnDelete();

            $table->string('vaccine_name');
            $table->string('dose');
            $table->date('date_given');
            $table->date('next_due_date')->nullable();
            $table->string('administered_by');
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maternal_vaccinations');
    }
};
