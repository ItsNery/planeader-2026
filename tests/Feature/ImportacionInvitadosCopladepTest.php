<?php

namespace Tests\Feature;

use App\Models\SesionCopladep;
use App\Http\Controllers\InvitadoCopladepController;
use App\Http\Controllers\RegistroCopladepController;
use Illuminate\Http\Request;
use App\Services\ImportacionInvitadosCopladep;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

class ImportacionInvitadosCopladepTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('sesiones_copladep', function (Blueprint $table) {
            $table->id(); $table->string('clave'); $table->string('nombre'); $table->integer('numero'); $table->timestamp('fecha_evento')->nullable(); $table->timestamps();
        });
        Schema::create('cat_dependencias_copladep', function (Blueprint $table) {
            $table->id(); $table->string('nombre'); $table->boolean('activo'); $table->timestamps();
        });
        Schema::create('cat_municipios', function (Blueprint $table) {
            $table->id(); $table->string('nombre_municipio');
        });
        Schema::create('invitado_copladeps', function (Blueprint $table) {
            $table->id(); $table->string('nombre_completo'); $table->string('sexo'); $table->string('cargo');
            $table->unsignedBigInteger('dependencia_id')->nullable(); $table->text('dependencia')->nullable(); $table->unsignedBigInteger('municipio_id');
            $table->boolean('check_in_express')->default(false);
            $table->string('sesion'); $table->unsignedBigInteger('sesion_copladep_id'); $table->string('modalidad')->nullable();
            $table->timestamps();
        });
        Schema::create('registro_copladeps', function (Blueprint $table) {
            $table->id(); $table->unsignedBigInteger('invitado_id'); $table->unsignedBigInteger('sesion_copladep_id');
            $table->string('nombre_completo'); $table->string('tipo_asistente'); $table->string('modalidad');
            $table->string('token_qr')->nullable(); $table->timestamp('check_in_at')->nullable(); $table->timestamps();
        });
        DB::table('cat_dependencias_copladep')->insert(['id' => 1, 'nombre' => 'Dependencia de prueba', 'activo' => true]);
        DB::table('cat_municipios')->insert(['id' => 1, 'nombre_municipio' => 'Puebla']);
    }

    public function test_template_contains_current_catalogs_and_valid_rows_import(): void
    {
        $service = app(ImportacionInvitadosCopladep::class);
        $book = $service->plantilla();
        $this->assertSame('Dependencia de prueba', $book->getSheetByName('Dependencias')->getCell('B2')->getValue());
        $this->assertSame('Puebla', $book->getSheetByName('Municipios')->getCell('B2')->getValue());
        $book->getSheetByName('Invitados')->fromArray(['Persona de prueba', 'Mujer', 'Titular', 1, 1, 'presencial'], null, 'A2');
        $path = tempnam(sys_get_temp_dir(), 'copladep_');
        try {
            (new Xlsx($book))->save($path);
            $this->assertSame(1, $service->importar($path, $this->sesion()));
            $this->assertDatabaseHas('invitado_copladeps', ['nombre_completo' => 'Persona de prueba', 'municipio_id' => 1, 'modalidad' => 'presencial']);
        } finally {
            $book->disconnectWorksheets();
            unlink($path);
        }
    }

    public function test_invalid_row_prevents_every_row_from_being_saved(): void
    {
        $service = app(ImportacionInvitadosCopladep::class);
        $book = $service->plantilla();
        $book->getSheetByName('Invitados')->fromArray([
            ['Persona válida', 'Mujer', 'Titular', 1, 1, 'presencial'],
            ['Persona inválida', 'Otro', 'Titular', 1, 999, 'virtual'],
        ], null, 'A2');
        $path = tempnam(sys_get_temp_dir(), 'copladep_');
        try {
            (new Xlsx($book))->save($path);
            try {
                $service->importar($path, $this->sesion());
                $this->fail('Se aceptó un municipio inexistente.');
            } catch (ValidationException $exception) {
                $this->assertStringContainsString('Fila 3', $exception->errors()['archivo'][0]);
            }
            $this->assertDatabaseCount('invitado_copladeps', 0);
        } finally {
            $book->disconnectWorksheets();
            unlink($path);
        }
    }

    public function test_duplicate_and_formula_are_rejected_without_updating_the_existing_invitation(): void
    {
        $sesion = $this->sesion();
        $sesion->invitados()->create([
            'nombre_completo' => 'Persona existente', 'sexo' => 'Mujer', 'cargo' => 'Titular',
            'municipio_id' => 1, 'sesion' => 'segunda', 'modalidad' => 'virtual',
        ]);
        $service = app(ImportacionInvitadosCopladep::class);
        $book = $service->plantilla();
        $book->getSheetByName('Invitados')->fromArray(['Persona existente', 'Mujer', 'Titular', 1, 1, 'presencial'], null, 'A2');
        $book->getSheetByName('Invitados')->setCellValue('A3', '=1+1');
        $path = tempnam(sys_get_temp_dir(), 'copladep_');
        try {
            (new Xlsx($book))->save($path);
            try {
                $service->importar($path, $sesion);
                $this->fail('Se aceptó un duplicado y una fórmula.');
            } catch (ValidationException $exception) {
                $messages = implode(' ', $exception->errors()['archivo']);
                $this->assertStringContainsString('Fila 2', $messages);
                $this->assertStringContainsString('no se permiten fórmulas', $messages);
            }
            $this->assertDatabaseCount('invitado_copladeps', 1);
            $this->assertDatabaseHas('invitado_copladeps', ['nombre_completo' => 'Persona existente', 'modalidad' => 'virtual']);
        } finally {
            $book->disconnectWorksheets();
            unlink($path);
        }
    }

    public function test_csv_exports_only_the_selected_session_and_neutralizes_formulas(): void
    {
        $sesion = $this->sesion();
        $otraSesion = SesionCopladep::create(['clave' => 'otra', 'nombre' => 'Otra sesión', 'numero' => 1]);
        $sesion->invitados()->create([
            'nombre_completo' => '=Persona', 'sexo' => 'Mujer', 'cargo' => 'Titular; enlace',
            'municipio_id' => 1, 'dependencia_id' => 1, 'sesion' => 'segunda', 'modalidad' => 'presencial',
        ]);
        $otraSesion->invitados()->create([
            'nombre_completo' => 'Otra persona', 'sexo' => 'Hombre', 'cargo' => 'Titular',
            'municipio_id' => 1, 'sesion' => 'primera',
        ]);

        $response = app(InvitadoCopladepController::class)->exportarCsv($sesion);
        ob_start();
        $response->sendContent();
        $csv = ob_get_clean();
        $this->assertStringStartsWith("\xEF\xBB\xBF", $csv);
        $this->assertStringContainsString("'=Persona", $csv);
        $this->assertStringContainsString('"Titular; enlace"', $csv);
        $this->assertStringContainsString('"Dependencia de prueba";Puebla;presencial;Falta', $csv);
        $this->assertStringNotContainsString('Otra persona', $csv);
    }

    public function test_qr_checkin_updates_monitor_and_csv_without_changing_manual_attendance(): void
    {
        $sesion = $this->sesion();
        $sesion->fecha_evento = now()->addHour();
        $sesion->save();
        $invitado = $sesion->invitados()->create([
            'nombre_completo' => 'Persona titular', 'sexo' => 'Mujer', 'cargo' => 'Titular',
            'municipio_id' => 1, 'sesion' => 'segunda',
        ]);
        DB::table('registro_copladeps')->insert([
            ['invitado_id' => $invitado->id, 'sesion_copladep_id' => $sesion->id, 'nombre_completo' => 'Persona titular', 'tipo_asistente' => 'titular', 'modalidad' => 'presencial', 'token_qr' => 'titular', 'check_in_at' => null],
            ['invitado_id' => $invitado->id, 'sesion_copladep_id' => $sesion->id, 'nombre_completo' => 'Persona representante', 'tipo_asistente' => 'representante', 'modalidad' => 'presencial', 'token_qr' => 'representante', 'check_in_at' => null],
        ]);

        $response = app(RegistroCopladepController::class)->checkin(Request::create('/', 'POST', ['token' => 'representante']), $sesion);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertFalse($invitado->fresh()->check_in_express);
        $monitor = app(InvitadoCopladepController::class)->monitor($sesion)->getData();
        $this->assertSame(1, $monitor['asistencias']);
        $this->assertSame(0, $monitor['faltantes']);
        $this->assertSame('Persona representante', $monitor['invitados']->first()->ingresosQr->first()->nombre_completo);
        $this->assertSame('Presente', $monitor['invitados']->first()->estadoAsistencia($sesion->fecha_evento));

        ob_start();
        app(InvitadoCopladepController::class)->exportarCsv($sesion)->sendContent();
        $csv = ob_get_clean();
        $this->assertStringContainsString(';Presente', $csv);

        $controller = app(InvitadoCopladepController::class);
        $controller->toggleCheckInExpress($sesion, $invitado);
        $manualOff = $controller->toggleCheckInExpress($sesion, $invitado)->getData(true);
        $this->assertSame('Presente', $manualOff['estado_texto']);
        $this->assertStringContainsString('QR permanece', $manualOff['message']);
        $duplicate = app(RegistroCopladepController::class)->checkin(Request::create('/', 'POST', ['token' => 'representante']), $sesion);
        $this->assertSame(422, $duplicate->getStatusCode());
    }

    public function test_manual_checkin_is_scoped_to_session_and_rejects_duplicates_and_virtual_attendees(): void
    {
        $sesion = $this->sesion();
        $otra = SesionCopladep::create(['clave' => 'otra', 'nombre' => 'Otra', 'numero' => 1]);
        $base = ['invitado_id' => 1, 'nombre_completo' => 'Persona', 'tipo_asistente' => 'titular', 'check_in_at' => null];
        $presencial = DB::table('registro_copladeps')->insertGetId($base + ['sesion_copladep_id' => $sesion->id, 'modalidad' => 'presencial']);
        $virtual = DB::table('registro_copladeps')->insertGetId($base + ['sesion_copladep_id' => $sesion->id, 'modalidad' => 'virtual']);
        $ajeno = DB::table('registro_copladeps')->insertGetId($base + ['sesion_copladep_id' => $otra->id, 'modalidad' => 'presencial']);
        $controller = app(RegistroCopladepController::class);
        $checkin = fn ($id) => $controller->checkin(Request::create('/', 'POST', ['registro_id' => $id]), $sesion);

        $this->assertSame(404, $checkin($ajeno)->getStatusCode());
        $this->assertSame(422, $checkin($virtual)->getStatusCode());
        $this->assertSame(200, $checkin($presencial)->getStatusCode());
        $this->assertSame(422, $checkin($presencial)->getStatusCode());
    }

    public function test_qr_download_and_delete_are_scoped_to_session(): void
    {
        $sesion = $this->sesion();
        $otra = SesionCopladep::create(['clave' => 'otra', 'nombre' => 'Otra', 'numero' => 1]);
        $id = DB::table('registro_copladeps')->insertGetId([
            'invitado_id' => 1, 'sesion_copladep_id' => $sesion->id, 'nombre_completo' => 'Persona',
            'tipo_asistente' => 'titular', 'modalidad' => 'presencial', 'token_qr' => 'token', 'check_in_at' => null,
        ]);
        $controller = app(RegistroCopladepController::class);
        $response = $controller->descargarQr($sesion, $id);
        $this->assertSame('image/png', $response->headers->get('Content-Type'));
        $this->assertStringStartsWith("\x89PNG", $response->getContent());
        try {
            $controller->destroy($otra, $id);
            $this->fail('Se eliminó un registro de otra sesión.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            $this->assertDatabaseHas('registro_copladeps', ['id' => $id]);
        }
        $controller->destroy($sesion, $id);
        $this->assertDatabaseMissing('registro_copladeps', ['id' => $id]);
    }

    private function sesion(): SesionCopladep
    {
        return SesionCopladep::create(['clave' => 'prueba', 'nombre' => 'Sesión de prueba', 'numero' => 2]);
    }
}
