<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosSubcomitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentosSubcomites', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('anio');
            $table->string('ruta_documento');
            $table->enum('nombre_subcomite', [
                'Subcomité de Desarrollo Regional'
                ])->default('Subcomité de Desarrollo Regional')->nullable();
            $table->enum('tipo_documento', ['Informe', 'Acta', 'Programa'])->default('Informe');
            $table->enum('tipo_acta', ['Ordinaria', 'Extraordinaria'])->nullable()->default(null);
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
        Schema::dropIfExists('documentosSubcomites');
    }
}
