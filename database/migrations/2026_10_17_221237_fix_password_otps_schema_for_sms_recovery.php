
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add user_id only if it is missing.
        if (! Schema::hasColumn('password_otps', 'user_id')) {
            Schema::table('password_otps', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->index();
            });
        }

        // Allow SMS recovery for users without an email address.
        // Only alter email when it is currently NOT nullable.
        $emailColumn = collect(DB::select(
            "SHOW COLUMNS FROM password_otps LIKE 'email'"
        ))->first();

        if ($emailColumn && strtoupper($emailColumn->Null) === 'NO') {
            Schema::table('password_otps', function (Blueprint $table) {
                $table->string('email')->nullable()->change();
            });
        }

        // Prevent verification updates from automatically changing expires_at.
        DB::statement(
            'ALTER TABLE password_otps
             MODIFY expires_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        );
    }

    public function down(): void
    {
        // Intentionally preserve user_id and nullable email.
        // Removing these could break existing SMS recovery records.
        // Keep expires_at without ON UPDATE behavior to avoid restoring the bug.
    }
};
