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
        if (!Schema::hasColumn('registro_copladeps', 'sesion')) {
            Schema::table('registro_copladeps', function (Blueprint $table) {
                $table->string('sesion')->default('primera')->after('invitado_id');
            });
        }

        if (!Schema::hasColumn('invitado_copladeps', 'sesion')) {
            Schema::table('invitado_copladeps', function (Blueprint $table) {
                $table->string('sesion')->default('primera')->after('check_in_express');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registro_copladeps', function (Blueprint $table) {
            $table->dropColumn('sesion');
        });

        Schema::table('invitado_copladeps', function (Blueprint $table) {
            $table->dropColumn('sesion');
        });
    }
};
