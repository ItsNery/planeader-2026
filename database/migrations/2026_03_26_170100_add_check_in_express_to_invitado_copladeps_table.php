<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invitado_copladeps', function (Blueprint $table) {
            $table->boolean('check_in_express')->default(false)->after('municipio_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitado_copladeps', function (Blueprint $table) {
            $table->dropColumn('check_in_express');
        });
    }
};
