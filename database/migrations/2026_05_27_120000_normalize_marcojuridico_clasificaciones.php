<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marco_juridico_ambitos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('slug')->unique();
            $table->unsignedInteger('orden')->default(0);
            $table->timestamps();
        });

        Schema::create('marco_juridico_tipos_documento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('marco_juridico_clasificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ambito_id')->constrained('marco_juridico_ambitos')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('tipo_documento_id')->constrained('marco_juridico_tipos_documento')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
            $table->unique(['ambito_id', 'tipo_documento_id'], 'marco_juridico_clasificaciones_unique');
        });

        $ambitos = [
            ['nombre' => 'Internacional', 'slug' => 'internacional', 'orden' => 1],
            ['nombre' => 'Nacional', 'slug' => 'nacional', 'orden' => 2],
            ['nombre' => 'Estatal', 'slug' => 'estatal', 'orden' => 3],
            ['nombre' => 'Municipal', 'slug' => 'municipal', 'orden' => 4],
        ];

        $tiposDocumento = [
            ['nombre' => 'Acuerdos internacionales', 'slug' => 'acuerdos-internacionales'],
            ['nombre' => 'Constitución', 'slug' => 'constitucion'],
            ['nombre' => 'Leyes', 'slug' => 'leyes'],
            ['nombre' => 'Presupuesto', 'slug' => 'presupuesto'],
            ['nombre' => 'Reglamentos', 'slug' => 'reglamentos'],
            ['nombre' => 'Lineamientos', 'slug' => 'lineamientos'],
            ['nombre' => 'Acuerdos', 'slug' => 'acuerdos'],
            ['nombre' => 'Metodologías', 'slug' => 'metodologias'],
            ['nombre' => 'Manuales', 'slug' => 'manuales'],
            ['nombre' => 'Guías', 'slug' => 'guias'],
        ];

        DB::table('marco_juridico_ambitos')->insert($ambitos);
        DB::table('marco_juridico_tipos_documento')->insert($tiposDocumento);

        $ambitosBySlug = DB::table('marco_juridico_ambitos')->pluck('id', 'slug');
        $tiposBySlug = DB::table('marco_juridico_tipos_documento')->pluck('id', 'slug');

        $clasificaciones = [
            ['ambito' => 'internacional', 'tipo' => 'acuerdos-internacionales'],
            ['ambito' => 'nacional', 'tipo' => 'constitucion'],
            ['ambito' => 'nacional', 'tipo' => 'leyes'],
            ['ambito' => 'nacional', 'tipo' => 'presupuesto'],
            ['ambito' => 'estatal', 'tipo' => 'constitucion'],
            ['ambito' => 'estatal', 'tipo' => 'leyes'],
            ['ambito' => 'estatal', 'tipo' => 'reglamentos'],
            ['ambito' => 'estatal', 'tipo' => 'lineamientos'],
            ['ambito' => 'estatal', 'tipo' => 'acuerdos'],
            ['ambito' => 'estatal', 'tipo' => 'metodologias'],
            ['ambito' => 'estatal', 'tipo' => 'manuales'],
            ['ambito' => 'estatal', 'tipo' => 'guias'],
            ['ambito' => 'municipal', 'tipo' => 'leyes'],
            ['ambito' => 'municipal', 'tipo' => 'lineamientos'],
            ['ambito' => 'municipal', 'tipo' => 'guias'],
        ];

        DB::table('marco_juridico_clasificaciones')->insert(array_map(
            fn ($clasificacion) => [
                'ambito_id' => $ambitosBySlug[$clasificacion['ambito']],
                'tipo_documento_id' => $tiposBySlug[$clasificacion['tipo']],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            $clasificaciones
        ));

        DB::statement("ALTER TABLE marcojuridico MODIFY tipo ENUM('Federal','Internacional','Nacional','Estatal','Municipal') NULL DEFAULT 'Municipal'");
        DB::table('marcojuridico')->where('tipo', 'Federal')->update(['tipo' => 'Nacional']);

        Schema::table('marcojuridico', function (Blueprint $table) {
            $table->foreignId('marco_juridico_clasificacion_id')
                ->nullable()
                ->after('tipo')
                ->constrained('marco_juridico_clasificaciones')
                ->nullOnDelete();
        });

        DB::statement("ALTER TABLE marcojuridico MODIFY tipo ENUM('Internacional','Nacional','Estatal','Municipal') NULL DEFAULT 'Municipal'");
    }

    public function down(): void
    {
        Schema::table('marcojuridico', function (Blueprint $table) {
            $table->dropConstrainedForeignId('marco_juridico_clasificacion_id');
        });

        DB::statement("ALTER TABLE marcojuridico MODIFY tipo ENUM('Federal','Estatal','Municipal') NULL DEFAULT 'Municipal'");
        DB::table('marcojuridico')->where('tipo', 'Nacional')->update(['tipo' => 'Federal']);

        Schema::dropIfExists('marco_juridico_clasificaciones');
        Schema::dropIfExists('marco_juridico_tipos_documento');
        Schema::dropIfExists('marco_juridico_ambitos');
    }
};
