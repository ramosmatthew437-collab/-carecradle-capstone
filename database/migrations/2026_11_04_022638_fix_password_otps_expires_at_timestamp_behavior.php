<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Prevent MySQL from automatically updating expires_at
        // whenever an OTP record is modified.
        DB::statement(
            'ALTER TABLE password_otps
             MODIFY expires_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        );
    }

    public function down(): void
    {
        // Restore MySQL's automatic timestamp update behavior.
        DB::statement(
            'ALTER TABLE password_otps
             MODIFY expires_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        );
    }
};