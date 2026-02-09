<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanesMunicipalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planes_municipales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('periodo');
            $table->string('ruta_documento');
            $table->string('portada');
            $table->unsignedBigInteger('municipio_id'); // Nombre del campo de la llave foránea
            $table->foreign('municipio_id')->references('id')->on('municipios'); // Definición de la llave foránea
            $table->enum('tipo', ['Ordinario', 'Extraordinario'])->nullable()->default(null);
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
        Schema::dropIfExists('planes_municipales');
    }
}
