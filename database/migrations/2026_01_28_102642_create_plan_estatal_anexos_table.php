<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanEstatalAnexosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_estatal_anexos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_estatal_id')->constrained('plan_estatals')->onDelete('cascade');
            $table->string('titulo');
            $table->string('ruta_documento');
            $table->string('imagen')->nullable();
            $table->integer('orden')->default(0);
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
        Schema::dropIfExists('plan_estatal_anexos');
    }
}
