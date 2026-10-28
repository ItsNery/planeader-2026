<?php

namespace Tests\Feature;

use App\Models\SesionCopladep;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class RegistroCopladepTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('sesiones_copladep', function (Blueprint $table) {
            $table->id();
            $table->string('clave');
            $table->string('nombre');
            $table->integer('numero')->nullable();
            $table->timestamp('registro_inicio')->nullable();
            $table->timestamp('registro_fin')->nullable();
            $table->timestamps();
        });
        Schema::create('invitado_copladeps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sesion_copladep_id');
            $table->string('modalidad')->nullable();
        });
        Schema::create('cat_municipios', function (Blueprint $table) {
            $table->id();
        });
        Schema::create('registro_copladeps', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('sexo');
            $table->string('cargo');
            $table->unsignedBigInteger('municipio_id');
            $table->string('correo_electronico');
            $table->string('telefono_oficina')->nullable();
            $table->string('telefono_celular');
            $table->string('tipo_asistente');
            $table->unsignedBigInteger('invitado_id');
            $table->string('sesion');
            $table->unsignedBigInteger('sesion_copladep_id');
            $table->string('modalidad')->nullable();
            $table->string('token_qr')->nullable();
            $table->timestamps();
        });
    }

    public function test_registration_accepts_an_empty_optional_office_phone(): void
    {
        $sesion = $this->sesionConInvitado();

        $response = $this->post(route('copladep-sesiones.registro.store', $sesion), $this->datos());

        $response->assertSessionHasNoErrors()->assertRedirect();
        $this->assertDatabaseHas('registro_copladeps', [
            'correo_electronico' => 'persona@example.test',
            'telefono_oficina' => null,
        ]);
    }

    public function test_required_cellphone_and_municipality_have_clear_errors(): void
    {
        $sesion = $this->sesionConInvitado();
        $response = $this->post(route('copladep-sesiones.registro.store', $sesion), array_merge($this->datos(), [
            'municipio_id' => '',
            'telefono_celular' => '',
        ]));

        $response->assertSessionHasErrors([
            'municipio_id' => 'Completa el campo municipio.',
            'telefono_celular' => 'Completa el campo teléfono celular.',
        ]);
        $this->assertDatabaseCount('registro_copladeps', 0);
    }

    private function sesionConInvitado(): SesionCopladep
    {
        $sesion = SesionCopladep::create([
            'clave' => 'prueba', 'nombre' => 'Sesión de prueba', 'numero' => 2,
            'registro_inicio' => now()->subDay(), 'registro_fin' => now()->addDay(),
        ]);
        DB::table('invitado_copladeps')->insert(['id' => 1, 'sesion_copladep_id' => $sesion->id, 'modalidad' => 'virtual']);
        DB::table('cat_municipios')->insert(['id' => 1]);

        return $sesion;
    }

    private function datos(): array
    {
        return [
            'tipo_asistente' => 'representante', 'invitado_id' => 1,
            'nombre_completo' => 'Persona de prueba', 'sexo' => 'Mujer', 'cargo' => 'Representante',
            'municipio_id' => 1, 'correo_electronico' => 'persona@example.test',
            'telefono_oficina' => '', 'telefono_celular' => '221 123 4567',
        ];
    }
}
