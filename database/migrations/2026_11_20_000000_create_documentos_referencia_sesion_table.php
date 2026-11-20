<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documentos_referencia_sesion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesion_copladep_id')->constrained('sesiones_copladep')->cascadeOnDelete();
            $table->string('nombre');
            $table->string('ruta');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos_referencia_sesion');
    }
};
