
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_confidentiality_acknowledgments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('policy_version', 20);
            $table->timestamp('acknowledged_at');

            $table->timestamps();

            $table->unique(
                ['user_id', 'policy_version'],
                'staff_ack_user_policy_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_confidentiality_acknowledgments');
    }
};