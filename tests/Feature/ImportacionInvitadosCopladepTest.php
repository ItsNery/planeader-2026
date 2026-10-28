<?php

namespace Tests\Feature;

use App\Models\SesionCopladep;
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
            $table->id(); $table->string('clave'); $table->string('nombre'); $table->integer('numero'); $table->timestamps();
        });
        Schema::create('cat_dependencias_copladep', function (Blueprint $table) {
            $table->id(); $table->string('nombre'); $table->boolean('activo'); $table->timestamps();
        });
        Schema::create('cat_municipios', function (Blueprint $table) {
            $table->id(); $table->string('nombre_municipio');
        });
        Schema::create('invitado_copladeps', function (Blueprint $table) {
            $table->id(); $table->string('nombre_completo'); $table->string('sexo'); $table->string('cargo');
            $table->unsignedBigInteger('dependencia_id')->nullable(); $table->unsignedBigInteger('municipio_id');
            $table->string('sesion'); $table->unsignedBigInteger('sesion_copladep_id'); $table->string('modalidad')->nullable();
            $table->timestamps();
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

    private function sesion(): SesionCopladep
    {
        return SesionCopladep::create(['clave' => 'prueba', 'nombre' => 'Sesión de prueba', 'numero' => 2]);
    }
}
