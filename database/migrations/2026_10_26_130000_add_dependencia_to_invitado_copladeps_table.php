<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitado_copladeps', function (Blueprint $table) {
            $table->text('dependencia')->nullable()->after('cargo');
        });
    }

    public function down(): void
    {
        Schema::table('invitado_copladeps', function (Blueprint $table) {
            $table->dropColumn('dependencia');
        });
    }
};
