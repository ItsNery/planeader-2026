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
        Schema::table('encuestas', function (Blueprint $table) {
            $table->text('comentario')->nullable()->after('satisfaccion');
            $table->string('url_evaluada')->nullable()->after('comentario');
            $table->string('resolucion')->nullable()->after('url_evaluada');
            $table->string('zona_horaria')->nullable()->after('resolucion');
            $table->string('lenguaje')->nullable()->after('zona_horaria');
            $table->string('ip')->nullable()->after('lenguaje');
            $table->text('user_agent')->nullable()->after('ip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('encuestas', function (Blueprint $table) {
            $table->dropColumn([
                'comentario',
                'url_evaluada',
                'resolucion',
                'zona_horaria',
                'lenguaje',
                'ip',
                'user_agent'
            ]);
        });
    }
};
