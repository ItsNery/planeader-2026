<?php

namespace Tests\Feature;

use App\Http\Controllers\PanelAgendaEventoController;
use App\Http\Controllers\AgendaCapacidadController;
use App\Models\AgendaCapacidad;
use App\Models\AgendaEvento;
use App\Models\AgendaFechaBloqueada;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AgendaDisponibilidadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('agenda_capacidades');
        Schema::dropIfExists('agenda_fechas_bloqueadas');
        Schema::dropIfExists('agenda_eventos');
        Schema::create('agenda_capacidades', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_evento')->unique();
            $table->unsignedTinyInteger('max_eventos');
            $table->json('horarios');
            $table->timestamps();
        });
        Schema::create('agenda_eventos', function (Blueprint $table) {
            $table->id();
            $table->string('folio');
            $table->string('tipo_evento');
            $table->unsignedBigInteger('subcomite_id')->nullable();
            $table->string('tematica')->nullable();
            $table->string('institucion_organizadora');
            $table->date('fecha_evento');
            $table->time('hora_inicio');
            $table->time('hora_fin')->nullable();
            $table->string('modalidad');
            $table->text('liga_videoconferencia')->nullable();
            $table->text('ubicacion')->nullable();
            $table->string('solicitante_nombre');
            $table->string('solicitante_cargo')->nullable();
            $table->string('solicitante_email');
            $table->string('solicitante_telefono')->nullable();
            $table->text('correos_invitados')->nullable();
            $table->string('estado');
            $table->text('observaciones_admin')->nullable();
            $table->text('comentarios')->nullable();
            $table->boolean('publicado')->default(true);
            $table->timestamp('confirmado_at')->nullable();
            $table->timestamps();
        });
        Schema::create('agenda_fechas_bloqueadas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_evento')->unique();
            $table->string('motivo', 500)->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('agenda_eventos');
        Schema::dropIfExists('agenda_fechas_bloqueadas');
        Schema::dropIfExists('agenda_capacidades');

        parent::tearDown();
    }

    public function test_uses_the_default_capacity_and_schedules_without_an_override(): void
    {
        $disponibilidad = AgendaEvento::disponibilidadParaFecha('2030-01-15');

        $this->assertSame(2, $disponibilidad['max_eventos']);
        $this->assertSame(['10:00', '13:00'], $disponibilidad['horarios']);
    }

    public function test_uses_the_capacity_and_schedules_configured_for_a_date(): void
    {
        AgendaCapacidad::create([
            'fecha_evento' => '2030-01-15',
            'max_eventos' => 3,
            'horarios' => ['09:00', '12:00', '15:00'],
        ]);

        $disponibilidad = AgendaEvento::disponibilidadParaFecha('2030-01-15');

        $this->assertSame(3, $disponibilidad['max_eventos']);
        $this->assertSame(['09:00', '12:00', '15:00'], $disponibilidad['horarios']);
    }

    public function test_identifies_a_date_blocked_for_public_requests(): void
    {
        AgendaFechaBloqueada::create([
            'fecha_evento' => '2030-01-15',
            'motivo' => 'Evento institucional',
        ]);

        $this->assertTrue(AgendaEvento::fechaEstaBloqueada('2030-01-15'));
        $this->assertFalse(AgendaEvento::fechaEstaBloqueada('2030-01-16'));
    }

    public function test_panel_can_create_an_event_in_a_third_configured_slot(): void
    {
        AgendaCapacidad::create([
            'fecha_evento' => '2030-01-15',
            'max_eventos' => 3,
            'horarios' => ['09:00', '12:00', '15:00'],
        ]);

        $response = app(PanelAgendaEventoController::class)->store($this->solicitudParaHorario('15:00'));
        $evento = AgendaEvento::firstOrFail();

        $this->assertStringEndsWith('/panel-agenda-eventos', $response->getTargetUrl());
        $this->assertSame('15:00', substr((string) $evento->hora_inicio, 0, 5));
        $this->assertSame('16:00', substr((string) $evento->hora_fin, 0, 5));
    }

    public function test_panel_rejects_a_time_that_is_not_configured_for_the_date(): void
    {
        try {
            app(PanelAgendaEventoController::class)->store($this->solicitudParaHorario('15:00'));
            $this->fail('El horario no configurado fue aceptado.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('hora_inicio', $exception->errors());
        }
    }

    public function test_capacity_configuration_keeps_existing_active_schedules(): void
    {
        app(PanelAgendaEventoController::class)->store($this->solicitudParaHorario('10:00'));

        $response = app(AgendaCapacidadController::class)->store(Request::create('/panel-eventos/capacidades-agenda', 'POST', [
            'fecha_evento' => '2030-01-15',
            'max_eventos' => 3,
            'horarios' => ['10:00', '13:00', '15:00'],
        ]));

        $capacidad = AgendaCapacidad::firstOrFail();

        $this->assertStringEndsWith('/panel-eventos/capacidades-agenda', $response->getTargetUrl());
        $this->assertSame(3, $capacidad->max_eventos);
        $this->assertSame(['10:00', '13:00', '15:00'], $capacidad->horarios);
    }

    private function solicitudParaHorario(string $horaInicio): Request
    {
        return Request::create('/panel-agenda-eventos', 'POST', [
            'tipo_evento' => 'mesa_tecnica',
            'institucion_organizadora' => 'Institución de prueba',
            'fecha_evento' => '2030-01-15',
            'hora_inicio' => $horaInicio,
            'modalidad' => 'virtual',
            'solicitante_nombre' => 'Persona de prueba',
            'solicitante_email' => 'prueba@example.test',
            'estado' => 'confirmado',
            'publicado' => '1',
        ]);
    }
}
