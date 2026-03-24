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
        Schema::create('registro_copladeps', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('sexo');
            $table->string('cargo');
            $table->foreignId('municipio_id')->constrained('cat_municipios')->nullable();
            $table->string('correo_electronico');
            $table->string('telefono_oficina')->nullable();
            $table->string('telefono_celular');
            $table->longText('firma')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_copladeps');
    }
};
