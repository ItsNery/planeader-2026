<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('imagen');
            $table->text('descripcion');
            $table->string('enlace');
            $table->enum('seccion', ['Inicio', 'COPLADEP', 'Programas Derivados', 'Plan Estatal'])->default('Inicio');
            $table->enum('estado', ['Activo', 'Inactivo', 'Pendiente'])->default('Pendiente');
            $table->integer('orden');
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
        Schema::dropIfExists('banners');
    }
}
