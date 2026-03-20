<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentoCapacitacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_capacitacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('capacitacion_id')->constrained()->onDelete('cascade');
            $table->string('nombre_display');
            $table->string('ruta_archivo');
            $table->unsignedTinyInteger('dia_agrupador')->nullable();
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
        Schema::dropIfExists('documento_capacitacions');
    }
}
