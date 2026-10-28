<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $nombre = 'LXII Legislatura del Congreso de Puebla';
        DB::table('cat_dependencias_copladep')->insertOrIgnore([
            'nombre' => $nombre,
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $dependenciaId = DB::table('cat_dependencias_copladep')->where('nombre', $nombre)->value('id');
        DB::table('invitado_copladeps')
            ->where('dependencia', 'like', 'LXII LEGISLATURA DEL CONGRESO DE PUEBLA%')
            ->update(['dependencia_id' => $dependenciaId]);
    }

    public function down(): void
    {
        DB::table('invitado_copladeps')
            ->where('dependencia', 'like', 'LXII LEGISLATURA DEL CONGRESO DE PUEBLA%')
            ->update(['dependencia_id' => null]);
        DB::table('cat_dependencias_copladep')->where('nombre', 'LXII Legislatura del Congreso de Puebla')->delete();
    }
};
