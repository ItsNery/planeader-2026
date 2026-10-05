<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agenda_eventos', function (Blueprint $table) {
            $table->dropUnique('agenda_eventos_fecha_hora_unique');
            $table->dropColumn('hora_fin');
            $table->index('fecha_evento', 'agenda_eventos_fecha_evento_index');
        });
    }

    public function down(): void
    {
        Schema::table('agenda_eventos', function (Blueprint $table) {
            $table->dropIndex('agenda_eventos_fecha_evento_index');
            $table->time('hora_fin')->nullable()->after('hora_inicio');
            $table->unique(['fecha_evento', 'hora_inicio'], 'agenda_eventos_fecha_hora_unique');
        });
    }
};
