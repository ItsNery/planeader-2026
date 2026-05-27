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
        Schema::table('registro_copladeps', function (Blueprint $table) {
            if (!Schema::hasColumn('registro_copladeps', 'tipo_asistente')) {
                $table->string('tipo_asistente', 191)->default('titular');
            }
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registro_copladeps', function (Blueprint $table) {
            $table->dropColumn('tipo_asistente');
            $table->dropForeign(['invitado_id']);
            $table->dropColumn('invitado_id');
        });
    }
};
