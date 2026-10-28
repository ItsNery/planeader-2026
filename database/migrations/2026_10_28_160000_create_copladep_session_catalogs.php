<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesiones_copladep', function (Blueprint $table) {
            $table->id();
            $table->string('clave')->unique();
            $table->string('nombre');
            $table->string('tipo', 30)->default('ordinaria');
            $table->unsignedTinyInteger('numero')->nullable();
            $table->unsignedSmallInteger('anio');
            $table->text('descripcion')->nullable();
            $table->string('estado', 30)->default('preparacion');
            $table->timestamp('registro_inicio')->nullable();
            $table->timestamp('registro_fin')->nullable();
            $table->timestamp('fecha_evento')->nullable();
            $table->string('lugar')->nullable();
            $table->string('enlace_virtual')->nullable();
            $table->json('agenda')->nullable();
            $table->string('ruta_publica')->nullable();
            $table->timestamps();
        });

        Schema::create('cat_dependencias_copladep', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('siglas', 30)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        $primeraId = DB::table('sesiones_copladep')->insertGetId([
            'clave' => '2026-primera-ordinaria',
            'nombre' => 'Primera Sesión Ordinaria 2026',
            'tipo' => 'ordinaria',
            'numero' => 1,
            'anio' => 2026,
            'descripcion' => 'Asamblea Plenaria del COPLADEP',
            'estado' => 'concluida',
            'registro_inicio' => '2026-03-26 08:30:00',
            'registro_fin' => '2026-03-31 19:00:00',
            'fecha_evento' => '2026-03-31 17:00:00',
            'lugar' => 'Casa Puebla, Calzada de los Fuertes 106, Puebla de Zaragoza',
            'agenda' => json_encode(['Apertura de la sesión.', 'Presentación de avances en materia de planeación estatal.', 'Asuntos Generales.', 'Clausura de la sesión.']),
            'ruta_publica' => '/copladep/primera-sesion-ordinaria',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $segundaId = DB::table('sesiones_copladep')->insertGetId([
            'clave' => '2026-segunda-ordinaria',
            'nombre' => 'Segunda Sesión Ordinaria 2026',
            'tipo' => 'ordinaria',
            'numero' => 2,
            'anio' => 2026,
            'descripcion' => 'Asamblea Plenaria del COPLADEP',
            'estado' => 'preparacion',
            'registro_inicio' => '2026-10-30 00:00:00',
            'registro_fin' => '2026-11-26 13:00:00',
            'fecha_evento' => '2026-11-25 13:00:00',
            'lugar' => 'Salón SUM, Casa Puebla, Calzada de los Fuertes 106, Puebla de Zaragoza',
            'agenda' => json_encode(['Apertura de la sesión y declaración del Quórum Legal.', 'Aprobación del Orden del Día.', 'Seguimiento a los puntos de acuerdo de la sesión anterior.', 'Presentación del Funcionamiento del COPLADEP y sus Órganos Auxiliares.', 'Asuntos Generales.', 'Clausura de la sesión.']),
            'ruta_publica' => '/copladep/segunda-sesion-ordinaria',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach (DB::table('invitado_copladeps')->whereNotNull('dependencia')->select('dependencia')->distinct()->pluck('dependencia') as $nombre) {
            $nombre = trim($nombre);
            if ($nombre !== '') {
                DB::table('cat_dependencias_copladep')->insertOrIgnore([
                    'nombre' => $nombre,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        Schema::table('invitado_copladeps', function (Blueprint $table) {
            $table->foreignId('sesion_copladep_id')->nullable()->after('sesion')->constrained('sesiones_copladep');
            $table->foreignId('dependencia_id')->nullable()->after('dependencia')->constrained('cat_dependencias_copladep');
        });

        Schema::table('registro_copladeps', function (Blueprint $table) {
            $table->foreignId('sesion_copladep_id')->nullable()->after('sesion')->constrained('sesiones_copladep');
        });

        DB::table('invitado_copladeps')->where('sesion', 'primera')->update(['sesion_copladep_id' => $primeraId]);
        DB::table('invitado_copladeps')->where('sesion', 'segunda')->update(['sesion_copladep_id' => $segundaId]);
        DB::table('registro_copladeps')->where('sesion', 'primera')->update(['sesion_copladep_id' => $primeraId]);
        DB::table('registro_copladeps')->where('sesion', 'segunda')->update(['sesion_copladep_id' => $segundaId]);

        foreach (DB::table('invitado_copladeps')->whereNotNull('dependencia')->select('id', 'dependencia')->get() as $invitado) {
            $nombre = trim($invitado->dependencia);
            if ($nombre !== '') {
                $dependenciaId = DB::table('cat_dependencias_copladep')->where('nombre', $nombre)->value('id');
                DB::table('invitado_copladeps')->where('id', $invitado->id)->update(['dependencia_id' => $dependenciaId]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('registro_copladeps', function (Blueprint $table) {
            $table->dropConstrainedForeignId('sesion_copladep_id');
        });

        Schema::table('invitado_copladeps', function (Blueprint $table) {
            $table->dropConstrainedForeignId('sesion_copladep_id');
            $table->dropConstrainedForeignId('dependencia_id');
        });

        Schema::dropIfExists('cat_dependencias_copladep');
        Schema::dropIfExists('sesiones_copladep');
    }
};
