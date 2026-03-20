<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcomitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcomites', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tipo_subcomite', ['Sectoriales', 'Especiales', 'Regional']);
            $table->text('objetivo');
            $table->string('slug')->unique();
            $table->string('conformacion'); // Aquí se puede usar 'string' si es solo para almacenar la ruta de la imagen
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
        Schema::dropIfExists('subcomites');
    }
}
