<?php

namespace Tests\Feature;

use App\Http\Controllers\HerramientaPlaneacionController;
use App\Models\HerramientaPlaneacion;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class HerramientaPlaneacionOrderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('herramientas_planeacion');
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
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('herramientas_planeacion');

        parent::tearDown();
    }

    public function test_updates_all_tools_in_the_requested_order(): void
    {
        $primera = $this->crearHerramienta('Primera', 1);
        $segunda = $this->crearHerramienta('Segunda', 2);
        $tercera = $this->crearHerramienta('Tercera', 3);

        app(HerramientaPlaneacionController::class)->actualizarOrden(Request::create('/panel-herramientas/orden', 'PUT', [
            'herramientas' => [$tercera->id, $primera->id, $segunda->id],
        ]));

        $this->assertSame(
            [$tercera->id, $primera->id, $segunda->id],
            HerramientaPlaneacion::orderBy('orden')->pluck('id')->all()
        );
        $this->assertSame([1, 2, 3], HerramientaPlaneacion::orderBy('orden')->pluck('orden')->all());
    }

    public function test_does_not_update_order_when_a_tool_is_missing(): void
    {
        $primera = $this->crearHerramienta('Primera', 1);
        $segunda = $this->crearHerramienta('Segunda', 2);

        app(HerramientaPlaneacionController::class)->actualizarOrden(Request::create('/panel-herramientas/orden', 'PUT', [
            'herramientas' => [$segunda->id],
        ]));

        $this->assertSame([$primera->id, $segunda->id], HerramientaPlaneacion::orderBy('orden')->pluck('id')->all());
    }

    private function crearHerramienta(string $titulo, int $orden): HerramientaPlaneacion
    {
        return HerramientaPlaneacion::create([
            'titulo' => $titulo,
            'archivo' => strtolower($titulo) . '.pdf',
            'orden' => $orden,
            'publicado' => true,
        ]);
    }
}
