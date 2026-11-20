<?php

namespace Tests\Feature;

use App\Models\SesionCopladep;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentosReferenciaSesionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('sesiones_copladep', function (Blueprint $table) {
            $table->id(); $table->string('clave'); $table->string('nombre'); $table->timestamps();
        });
        Schema::create('documentos_referencia_sesion', function (Blueprint $table) {
            $table->id(); $table->unsignedBigInteger('sesion_copladep_id'); $table->string('nombre'); $table->string('ruta'); $table->timestamps();
        });
        Storage::fake('local');
    }

    public function test_upload_view_download_and_session_isolation(): void
    {
        $this->withoutMiddleware();
        $sesion = SesionCopladep::create(['clave' => 'primera', 'nombre' => 'Primera']);
        $otra = SesionCopladep::create(['clave' => 'segunda', 'nombre' => 'Segunda']);
        $this->post(route('panel-copladep-sesiones.documentos.store', $sesion), [
            'nombre' => 'Referencia', 'archivo' => UploadedFile::fake()->create('referencia.pdf', 10, 'application/pdf'),
        ])->assertSessionHasNoErrors();
        $documento = $sesion->documentosReferencia()->firstOrFail();
        Storage::disk('local')->assertExists($documento->ruta);
        $this->get(route('copladep-sesiones.documentos.ver', [$sesion, $documento]))->assertOk()->assertHeader('content-type', 'application/pdf');
        $this->get(route('copladep-sesiones.documentos.ver', [$sesion, $documento]).'?descargar=1')->assertOk()->assertHeader('content-disposition', 'attachment; filename=referencia.pdf');
        $this->get(route('copladep-sesiones.documentos.ver', [$otra, $documento]))->assertNotFound();
        $this->delete(route('panel-copladep-sesiones.documentos.destroy', [$otra, $documento]))->assertNotFound();
        $this->delete(route('panel-copladep-sesiones.documentos.destroy', [$sesion, $documento]))->assertRedirect();
        Storage::disk('local')->assertMissing($documento->ruta);
    }

    public function test_session_foreign_key_is_cast_to_integer(): void
    {
        $documento = new \App\Models\DocumentoReferenciaSesion();
        $documento->setRawAttributes(['sesion_copladep_id' => '12']);
        $this->assertSame(12, $documento->sesion_copladep_id);
    }

    public function test_rejects_non_pdf_uploads(): void
    {
        $this->withoutMiddleware();
        $sesion = SesionCopladep::create(['clave' => 'primera', 'nombre' => 'Primera']);
        $this->post(route('panel-copladep-sesiones.documentos.store', $sesion), [
            'nombre' => 'No PDF', 'archivo' => UploadedFile::fake()->create('archivo.txt', 1, 'text/plain'),
        ])->assertSessionHasErrors('archivo');
        $this->assertSame  (0, $sesion->documentosReferencia()->count());
    }
}
