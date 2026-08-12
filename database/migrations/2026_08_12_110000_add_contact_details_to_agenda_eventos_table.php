<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agenda_eventos', function (Blueprint $table) {
            $table->text('correos_invitados')->nullable()->after('solicitante_telefono');
            $table->text('comentarios')->nullable()->after('observaciones_admin');
        });
    }

    public function down(): void
    {
        Schema::table('agenda_eventos', function (Blueprint $table) {
            $table->dropColumn(['correos_invitados', 'comentarios']);
        });
    }
};
