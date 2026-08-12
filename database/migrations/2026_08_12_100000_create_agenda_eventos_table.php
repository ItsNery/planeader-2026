<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda_eventos', function (Blueprint $table) {
            $table->id();
            $table->string('folio', 30)->unique();
            $table->string('tipo_evento', 20);
            $table->foreignId('subcomite_id')->nullable()->constrained('subcomites')->nullOnDelete();
            $table->string('tematica')->nullable();
            $table->string('institucion_organizadora');
            $table->date('fecha_evento')->unique();
            $table->time('hora_inicio');
            $table->time('hora_fin')->nullable();
            $table->string('modalidad', 20);
            $table->text('liga_videoconferencia')->nullable();
            $table->text('ubicacion')->nullable();
            $table->string('solicitante_nombre');
            $table->string('solicitante_cargo')->nullable();
            $table->string('solicitante_email');
            $table->string('solicitante_telefono', 40)->nullable();
            $table->string('estado', 20)->default('pendiente');
            $table->text('observaciones_admin')->nullable();
            $table->timestamp('confirmado_at')->nullable();
            $table->boolean('publicado')->default(true);
            $table->timestamps();

            $table->index(['estado', 'fecha_evento']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_eventos');
    }
};
