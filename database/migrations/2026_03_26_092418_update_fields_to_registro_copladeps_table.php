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
        if (!Schema::hasColumn('registro_copladeps', 'tipo_asistente')) {
            Schema::table('registro_copladeps', function (Blueprint $table) {
                $table->string('tipo_asistente')->default('titular');
            });
        }

        if (!Schema::hasColumn('registro_copladeps', 'invitado_id')) {
            Schema::table('registro_copladeps', function (Blueprint $table) {
                $table->foreignId('invitado_id')->constrained('invitado_copladeps');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('registro_copladeps', 'invitado_id')) {
            Schema::table('registro_copladeps', function (Blueprint $table) {
                $table->dropForeign(['invitado_id']);
                $table->dropColumn('invitado_id');
            });
        }

        if (Schema::hasColumn('registro_copladeps', 'tipo_asistente')) {
            Schema::table('registro_copladeps', function (Blueprint $table) {
                $table->dropColumn('tipo_asistente');
            });
        }
    }
};
