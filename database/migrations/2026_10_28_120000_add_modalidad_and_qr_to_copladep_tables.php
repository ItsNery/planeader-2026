<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('invitado_copladeps', function (Blueprint $table) {
            $table->string('modalidad', 20)->nullable()->after('sesion');
        });

        Schema::table('registro_copladeps', function (Blueprint $table) {
            $table->string('modalidad', 20)->nullable()->after('sesion');
            $table->string('token_qr', 64)->nullable()->unique()->after('modalidad');
            $table->string('qr_path')->nullable()->after('token_qr');
            $table->timestamp('check_in_at')->nullable()->after('qr_path');
        });
    }

    public function down(): void
    {
        Schema::table('registro_copladeps', function (Blueprint $table) {
            $table->dropUnique(['token_qr']);
            $table->dropColumn(['modalidad', 'token_qr', 'qr_path', 'check_in_at']);
        });
        Schema::table('invitado_copladeps', fn (Blueprint $table) => $table->dropColumn('modalidad'));
    }
};
