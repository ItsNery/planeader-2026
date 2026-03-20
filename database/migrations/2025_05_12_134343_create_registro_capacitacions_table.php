<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroCapacitacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_capacitacions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('sexo');
            $table->string('cargo');

            $table->unsignedBigInteger('municipio_id')->nullable(); // Permitir nulo temporalmente o si es opcional
            $table->foreign('municipio_id')
                ->references('id')->on('cat_municipios')
                ->onDelete('set null'); // O 'cascade', 'restrict' según tu lógica de negocio

            $table->string('correo_electronico')->unique();
            $table->string('telefono_oficina')->nullable();
            $table->string('telefono_celular')->nullable();
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
        Schema::dropIfExists('registro_capacitacions');
    }
}
