<?php

namespace Tests\Feature;

use App\Models\SesionCopladep;
use App\Models\RegistroCopladep;
use App\Services\CopladepQrService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
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
            $table->integer('anio')->nullable();
            $table->timestamp('fecha_evento')->nullable();
            $table->string('lugar')->nullable();
            $table->string('enlace_virtual')->nullable();
            $table->text('agenda')->nullable();
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
            $table->string('qr_path')->nullable();
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

    public function test_presential_registration_and_pdf_work_when_qr_backup_storage_fails(): void
    {
        $sesion = $this->sesionConInvitado();
        $sesion->update(['clave' => '2026-segunda-ordinaria', 'anio' => 2026]);
        DB::table('invitado_copladeps')->where('id', 1)->update(['modalidad' => 'presencial']);
        Storage::shouldReceive('disk')->with('local')->andThrow(new \RuntimeException('Almacenamiento no disponible'));

        $response = $this->post(route('copladep-sesiones.registro.store', $sesion), $this->datos());
        $response->assertSessionHasNoErrors()->assertRedirect();
        $registro = RegistroCopladep::firstOrFail();
        $this->assertNotEmpty($registro->token_qr);
        $this->assertNull($registro->qr_path);
        $this->assertStringStartsWith("\x89PNG\r\n\x1a\n", app(CopladepQrService::class)->imagen($registro));

        $pdf = $this->get(route('copladep-registro.pdf', $registro->token_qr));
        $pdf->assertOk()->assertHeader('Content-Type', 'application/pdf');
        $this->assertStringStartsWith('%PDF-', $pdf->getContent());
        $this->assertSame($registro->token_qr, $registro->fresh()->token_qr);

        // Los registros anteriores pueden conservar una ruta que ya no existe.
        $registro->forceFill(['qr_path' => 'qr-copladep/archivo-anterior.png'])->save();
        $this->get(route('copladep-registro.pdf', $registro->token_qr))->assertOk();
    }

    public function test_presential_registration_saves_a_qr_backup_and_reuses_it(): void
    {
        $sesion = $this->sesionConInvitado();
        $sesion->update(['clave' => '2026-segunda-ordinaria', 'anio' => 2026]);
        DB::table('invitado_copladeps')->where('id', 1)->update(['modalidad' => 'presencial']);
        $disk = \Mockery::mock();
        $disk->shouldReceive('put')->once()->with(
            \Mockery::on(fn ($path) => str_starts_with($path, 'qr-copladep/2026-segunda-ordinaria/') && str_ends_with($path, '.png')),
            \Mockery::on(fn ($data) => str_starts_with($data, "\x89PNG\r\n\x1a\n"))
        )->andReturn(true);
        $disk->shouldReceive('exists')->once()->andReturn(true);
        Storage::shouldReceive('disk')->with('local')->twice()->andReturn($disk);

        $this->post(route('copladep-sesiones.registro.store', $sesion), $this->datos())
            ->assertSessionHasNoErrors()->assertRedirect();
        $registro = RegistroCopladep::firstOrFail();
        $this->assertSame('qr-copladep/2026-segunda-ordinaria/' . $registro->token_qr . '.png', $registro->qr_path);
        $this->get(route('copladep-registro.pdf', $registro->token_qr))->assertOk();
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
