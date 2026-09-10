<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agenda_eventos', function (Blueprint $table) {
            $table->dropUnique('agenda_eventos_fecha_evento_unique');
            $table->unique(['fecha_evento', 'hora_inicio'], 'agenda_eventos_fecha_hora_unique');
        });
    }

    public function down(): void
    {
        Schema::table('agenda_eventos', function (Blueprint $table) {
            $table->dropUnique('agenda_eventos_fecha_hora_unique');
            $table->unique('fecha_evento', 'agenda_eventos_fecha_evento_unique');
        });
    }
};
