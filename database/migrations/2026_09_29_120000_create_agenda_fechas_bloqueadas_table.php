<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda_fechas_bloqueadas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_evento')->unique();
            $table->string('motivo', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_fechas_bloqueadas');
    }
};
