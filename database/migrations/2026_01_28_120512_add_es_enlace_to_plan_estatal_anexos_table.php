<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEsEnlaceToPlanEstatalAnexosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_estatal_anexos', function (Blueprint $table) {
            $table->boolean('es_enlace')->default(false)->after('titulo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plan_estatal_anexos', function (Blueprint $table) {
            $table->dropColumn('es_enlace');
        });
    }
}
