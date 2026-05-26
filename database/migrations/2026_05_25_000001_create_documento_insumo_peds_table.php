<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_insumo_peds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_estatal_id')->constrained('plan_estatals')->onDelete('cascade');
            $table->string('titulo', 255);
            $table->enum('tipo', ['arbol-problemas', 'fichas-indicadores']);
            $table->string('ruta_documento', 255);
            $table->enum('formato', ['pdf', 'excel']);
            $table->boolean('publicado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documento_insumo_peds');
    }
};
