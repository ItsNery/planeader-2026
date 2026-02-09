<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanEstatalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_estatals', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('periodo');
            $table->string('ruta_documento');
            $table->string('portada');
            $table->string('gobernador');
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
        Schema::dropIfExists('plan_estatals');
    }
}
