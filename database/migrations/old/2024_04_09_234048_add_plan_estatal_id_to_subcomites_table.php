<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanEstatalIdToSubcomitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subcomites', function (Blueprint $table) {
            $table->unsignedBigInteger('planestatal_id')->nullable();
            $table->foreign('planestatal_id')->references('id')->on('plan_estatals')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subcomites', function (Blueprint $table) {
            $table->dropForeign(['planestatal_id']);
            $table->dropColumn('planestatal_id');
        });
    }
}
