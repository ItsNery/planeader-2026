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
        Schema::table('marco_juridico_ambitos', function (Blueprint $table) {
            $table->string('portada')->nullable()->after('orden');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marco_juridico_ambitos', function (Blueprint $table) {
            $table->dropColumn('portada');
        });
    }
};
