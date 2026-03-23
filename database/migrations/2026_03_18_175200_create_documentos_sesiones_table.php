<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosSesionesTable extends Migration
{
    public function up()
    {
        Schema::create('documentos_sesiones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ruta_documento');
            $table->string('portada')->nullable();
            $table->integer('orden')->default(1);
            $table->string('sesion');
            $table->boolean('publicado')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documentos_sesiones');
    }
}
