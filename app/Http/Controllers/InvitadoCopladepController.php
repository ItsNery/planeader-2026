<?php

namespace App\Http\Controllers;

use App\Models\CatDependenciaCopladep;
use App\Models\CatMunicipio;
use App\Models\InvitadoCopladep;
use App\Models\SesionCopladep;
use App\Services\ImportacionInvitadosCopladep;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InvitadoCopladepController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-invitado-copladep|crear-invitado-copladep|editar-invitado-copladep|borrar-invitado-copladep', ['only' => ['index', 'monitor']]);
        $this->middleware('permission:crear-invitado-copladep', ['only' => ['store', 'importarForm', 'plantilla', 'importar']]);
        $this->middleware('permission:editar-invitado-copladep', ['only' => ['update', 'toggleCheckInExpress']]);
        $this->middleware('permission:borrar-invitado-copladep', ['only' => ['destroy']]);
    }

    public function index(SesionCopladep $sesion)
    {
        $invitados = $sesion->invitados()->with(['municipio', 'dependenciaCopladep'])->orderBy('nombre_completo')->get();
        $municipios = CatMunicipio::orderBy('nombre_municipio')->get();
        $dependencias = CatDependenciaCopladep::where('activo', true)->orderBy('nombre')->get();

        return view('panel-copladep.sesiones.invitados.index', compact('sesion', 'invitados', 'municipios', 'dependencias'));
    }

    public function store(Request $request, SesionCopladep $sesion)
    {
        $datos = $this->validated($request);
        $datos['sesion_copladep_id'] = $sesion->id;
        $datos['sesion'] = $sesion->numero === 2 ? 'segunda' : 'primera';
        InvitadoCopladep::create($datos);

        return redirect()->route('panel-copladep-sesiones.invitados.index', $sesion)->with('success', 'Invitado registrado exitosamente.');
    }

    public function importarForm(SesionCopladep $sesion)
    {
        return view('panel-copladep.sesiones.invitados.importar', compact('sesion'));
    }

    public function plantilla(SesionCopladep $sesion, ImportacionInvitadosCopladep $importacion)
    {
        $book = $importacion->plantilla();

        return response()->streamDownload(function () use ($book) {
            try {
                (new Xlsx($book))->save('php://output');
            } finally {
                $book->disconnectWorksheets();
            }
        }, 'plantilla-invitados-copladep.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'no-store',
        ]);
    }

    public function importar(Request $request, SesionCopladep $sesion, ImportacionInvitadosCopladep $importacion)
    {
        $request->validate(['archivo' => 'required|file|mimes:xlsx|max:5120'], [
            'archivo.required' => 'Selecciona un archivo XLSX para importar.',
            'archivo.mimes' => 'Selecciona un archivo XLSX generado con la plantilla.',
            'archivo.max' => 'El archivo no debe superar los 5 MB.',
        ]);

        $count = $importacion->importar($request->file('archivo')->getRealPath(), $sesion);

        return redirect()->route('panel-copladep-sesiones.invitados.index', $sesion)
            ->with('success', "Se importaron {$count} invitados correctamente.");
    }

    public function update(Request $request, SesionCopladep $sesion, InvitadoCopladep $invitado)
    {
        abort_unless($invitado->sesion_copladep_id === $sesion->id, 404);
        $invitado->update($this->validated($request));

        return redirect()->route('panel-copladep-sesiones.invitados.index', $sesion)->with('success', 'Datos del invitado actualizados correctamente.');
    }

    public function destroy(SesionCopladep $sesion, InvitadoCopladep $invitado)
    {
        abort_unless($invitado->sesion_copladep_id === $sesion->id, 404);
        try {
            $invitado->delete();
            return redirect()->route('panel-copladep-sesiones.invitados.index', $sesion)->with('success', 'Invitado eliminado.');
        } catch (\Exception) {
            return redirect()->route('panel-copladep-sesiones.invitados.index', $sesion)->withErrors(['error' => 'No se puede eliminar a este invitado porque ya tiene un registro de asistencia vinculado.']);
        }
    }

    public function monitor(SesionCopladep $sesion)
    {
        $invitados = $sesion->invitados()->where(function ($query) {
            $query->whereHas('registro')->orWhere('check_in_express', true);
        })->orderBy('nombre_completo')->get();
        $total = $invitados->count();
        $asistencias = $invitados->where('check_in_express', true)->count();
        $faltantes = $total - $asistencias;

        return view('panel-copladep.sesiones.invitados.monitor', compact('sesion', 'invitados', 'total', 'asistencias', 'faltantes'));
    }

    public function toggleCheckInExpress(SesionCopladep $sesion, InvitadoCopladep $invitado)
    {
        abort_unless($invitado->sesion_copladep_id === $sesion->id, 404);
        $invitado->check_in_express = ! $invitado->check_in_express;
        $invitado->save();
        $esTolerancia = $sesion->fecha_evento && $invitado->updated_at->greaterThan($sesion->fecha_evento);
        $estado = $invitado->check_in_express ? ($esTolerancia ? 'Asistencia con retardo' : 'Presente') : 'Falta';

        return response()->json([
            'success' => true,
            'estado_actual' => $invitado->check_in_express,
            'estado_texto' => $estado,
            'estado_clase' => $invitado->check_in_express ? ($esTolerancia ? 'bg-warning text-dark' : 'bg-success') : 'bg-secondary',
            'message' => $invitado->check_in_express ? "Pase de lista: {$estado}" : 'Pase de lista revertido.',
        ]);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'sexo' => 'required|in:Hombre,Mujer,Otro',
            'cargo' => 'required|string|max:255',
            'dependencia_id' => 'nullable|integer|exists:cat_dependencias_copladep,id',
            'municipio_id' => 'nullable|integer|exists:cat_municipios,id',
            'modalidad' => 'nullable|in:presencial,virtual',
        ]);
    }
}
