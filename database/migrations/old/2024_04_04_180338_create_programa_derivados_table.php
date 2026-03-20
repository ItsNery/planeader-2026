<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramaDerivadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programa_derivados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ruta_documento');
            $table->string('portada');
            $table->enum('tipo_derivado', ['Sectoriales', 'Especiales', 'Institucionales', 'Regionales'])->default('Sectoriales');
            $table->unsignedBigInteger('planestatal_id'); // Nombre del campo de la llave foránea
            $table->foreign('planestatal_id')->references('id')->on('plan_estatals'); // Definición de la llave foránea
            $table->boolean('publicado')->default(false);
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
        Schema::dropIfExists('programa_derivados');
    }
}
