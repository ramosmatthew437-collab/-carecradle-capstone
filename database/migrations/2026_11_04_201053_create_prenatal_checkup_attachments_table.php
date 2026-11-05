
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prenatal_checkup_attachments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('prenatal_checkup_id')
                ->constrained('prenatal_checkups')
                ->cascadeOnDelete();

            $table->string('file_name');
            $table->string('file_path');
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('file_size');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prenatal_checkup_attachments');
    }
};
