<?php

namespace App\Http\Controllers;

use App\Models\DocumentoReferenciaSesion;
use App\Models\SesionCopladep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoReferenciaSesionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-listado-registro-copladep')->only(['store', 'destroy']);
    }

    public function store(Request $request, SesionCopladep $sesion)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'archivo' => 'required|file|mimes:pdf|max:51200',
        ], [
            'archivo.mimes' => 'El archivo debe ser un PDF.',
            'archivo.max' => 'El archivo no puede pesar más de 50 MB.',
        ]);
        $ruta = $request->file('archivo')->store('documentos-referencia-copladep', 'local');
        if ($ruta === false) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'archivo' => 'No se pudo guardar el PDF. Inténtalo de nuevo o contacta al administrador.',
            ]);
        }
        try {
            $sesion->documentosReferencia()->create(['nombre' => $data['nombre'], 'ruta' => $ruta]);
        } catch (\Throwable $e) {
            Storage::disk('local')->delete($ruta);
            throw $e;
        }
        return redirect()->route('panel-copladep-sesiones.show', $sesion)->with('success', 'Documento agregado correctamente.');
    }

    public function destroy(SesionCopladep $sesion, DocumentoReferenciaSesion $documento)
    {
        abort_unless($documento->sesion_copladep_id === $sesion->id, 404);
        $ruta = $documento->ruta;
        $documento->delete();
        Storage::disk('local')->delete($ruta);
        return redirect()->route('panel-copladep-sesiones.show', $sesion)->with('success', 'Documento eliminado correctamente.');
    }

    public function ver(SesionCopladep $sesion, DocumentoReferenciaSesion $documento, Request $request)
    {
        abort_unless($documento->sesion_copladep_id === $sesion->id && Storage::disk('local')->exists($documento->ruta), 404);
        $nombre = \Illuminate\Support\Str::slug($documento->nombre) ?: 'documento';
        return $request->boolean('descargar')
            ? Storage::disk('local')->download($documento->ruta, $nombre . '.pdf', ['Content-Type' => 'application/pdf'])
            : Storage::disk('local')->response($documento->ruta, $nombre . '.pdf', ['Content-Type' => 'application/pdf', 'X-Content-Type-Options' => 'nosniff']);
    }
}
