<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosApoyoCoplademunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos_apoyo_coplademun', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('ruta_documento');
            $table->string('imagen');
            $table->integer('orden');
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
        Schema::dropIfExists('documentos_apoyo_coplademun');
    }
}
