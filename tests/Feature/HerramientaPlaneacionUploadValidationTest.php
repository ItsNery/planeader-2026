<?php

namespace Tests\Feature;

use App\Http\Controllers\HerramientaPlaneacionController;
use App\Models\HerramientaPlaneacion;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class HerramientaPlaneacionUploadValidationTest extends TestCase
{
    public function test_main_pdf_larger_than_ten_megabytes_is_rejected(): void
    {
        $request = Request::create('/panel-herramientas', 'POST', [
            'titulo' => 'Herramienta de prueba',
            'orden' => 1,
        ], [], [
            'archivo' => UploadedFile::fake()->create('documento.pdf', 10241, 'application/pdf'),
        ]);

        $this->assertUploadRejected($request, 'archivo');
    }

    public function test_annex_larger_than_ten_megabytes_is_rejected(): void
    {
        $request = Request::create('/panel-herramientas', 'POST', [
            'titulo' => 'Herramienta de prueba',
            'orden' => 1,
            'anexos' => [['titulo' => 'Anexo de prueba']],
        ], [], [
            'archivo' => UploadedFile::fake()->create('documento.pdf', 100, 'application/pdf'),
            'anexos' => [[
                'archivo' => UploadedFile::fake()->create('anexo.pdf', 10241, 'application/pdf'),
            ]],
        ]);

        $this->assertUploadRejected($request, 'anexos.0.archivo');
    }

    public function test_successful_store_redirects_to_a_relative_index_url(): void
    {
        Schema::create('herramientas_planeacion', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->string('archivo');
            $table->integer('orden');
            $table->boolean('publicado');
            $table->timestamps();
        });

        $herramienta = null;

        try {
            $request = Request::create('/panel-herramientas', 'POST', [
                'titulo' => 'Herramienta de prueba',
                'orden' => 1,
            ], [], [
                'archivo' => UploadedFile::fake()->create('documento.pdf', 600, 'application/pdf'),
            ]);

            $response = app(HerramientaPlaneacionController::class)->store($request);
            $herramienta = HerramientaPlaneacion::first();

            $this->assertSame('/panel-herramientas', $response->getTargetUrl());
        } finally {
            if ($herramienta) {
                @unlink(public_path('documentos/herramientas/' . $herramienta->archivo));
            }

            Schema::dropIfExists('herramientas_planeacion');
        }
    }

    public function test_store_accepts_zip_annex(): void
    {
        Schema::create('herramientas_planeacion', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->string('archivo');
            $table->integer('orden');
            $table->boolean('publicado');
            $table->timestamps();
        });
        Schema::create('herramientas_planeacion_anexos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('herramienta_id')->constrained('herramientas_planeacion')->onDelete('cascade');
            $table->string('titulo');
            $table->string('archivo');
            $table->integer('orden')->default(0);
            $table->timestamps();
        });

        $herramienta = null;
        $anexo = null;

        try {
            $request = Request::create('/panel-herramientas', 'POST', [
                'titulo' => 'Herramienta con anexo zip',
                'orden' => 1,
                'anexos' => [['titulo' => 'Anexo zip']],
            ], [], [
                'archivo' => UploadedFile::fake()->create('documento.pdf', 100, 'application/pdf'),
                'anexos' => [[
                    'archivo' => UploadedFile::fake()->create('datos.zip', 100, 'application/zip'),
                ]],
            ]);

            app(HerramientaPlaneacionController::class)->store($request);

            $herramienta = HerramientaPlaneacion::first();
            $anexo = $herramienta->anexos()->first();

            $this->assertNotNull($anexo);
            $this->assertStringEndsWith('.zip', $anexo->archivo);
        } finally {
            if ($anexo) {
                @unlink(public_path('documentos/herramientas/anexos/' . $anexo->archivo));
            }
            if ($herramienta) {
                @unlink(public_path('documentos/herramientas/' . $herramienta->archivo));
            }

            Schema::dropIfExists('herramientas_planeacion_anexos');
            Schema::dropIfExists('herramientas_planeacion');
        }
    }

    private function assertUploadRejected(Request $request, string $field): void
    {
        try {
            app(HerramientaPlaneacionController::class)->store($request);
            $this->fail('La carga excedida no fue rechazada.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey($field, $exception->errors());
        }
    }
}
