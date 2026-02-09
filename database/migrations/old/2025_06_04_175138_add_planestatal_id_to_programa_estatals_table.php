<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanestatalIdToProgramaEstatalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programa_estatals', function (Blueprint $table) {
            $table->unsignedTinyInteger('historico')->nullable()->after('publicado');
            $table->unsignedBigInteger('planestatal_id')->nullable()->after('id');
            $table->foreign('planestatal_id')
                ->references('id')
                ->on('plan_estatals')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programa_estatals', function (Blueprint $table) {
            $table->dropForeign(['planestatal_id']);
            $table->dropColumn('planestatal_id');
            $table->dropColumn('historico');
        });
    }
}
