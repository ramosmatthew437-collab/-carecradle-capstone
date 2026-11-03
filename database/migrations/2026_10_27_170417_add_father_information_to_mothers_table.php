
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add father's information to the mothers table.
     */
    public function up(): void
    {
        Schema::table('mothers', function (Blueprint $table) {
            $table->string('father_first_name')->nullable();
            $table->string('father_middle_name')->nullable();
            $table->string('father_last_name')->nullable();
            $table->date('father_birth_date')->nullable();
            $table->string('father_contact_number', 20)->nullable();
            $table->string('father_occupation')->nullable();
        });
    }

    /**
     * Remove father's information columns.
     */
    public function down(): void
    {
        Schema::table('mothers', function (Blueprint $table) {
            $table->dropColumn([
                'father_first_name',
                'father_middle_name',
                'father_last_name',
                'father_birth_date',
                'father_contact_number',
                'father_occupation',
            ]);
        });
    }
};
