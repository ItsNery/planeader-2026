<?php

namespace App\Http\Controllers;

use App\Models\SesionCopladep;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SesionCopladepController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-listado-registro-copladep');
    }

    public function index()
    {
        $sesiones = SesionCopladep::withCount(['invitados', 'registros'])->orderByDesc('anio')->orderByDesc('numero')->get();

        return view('panel-copladep.sesiones.index', compact('sesiones'));
    }

    public function create()
    {
        return view('panel-copladep.sesiones.form', ['sesion' => new SesionCopladep()]);
    }

    public function store(Request $request)
    {
        $sesion = SesionCopladep::create($this->validated($request));

        return redirect()->route('panel-copladep-sesiones.show', $sesion)->with('success', 'Sesión creada correctamente.');
    }

    public function show(SesionCopladep $sesion)
    {
        $sesion->loadCount(['invitados', 'registros']);
        $metricas = [
            'presenciales' => $sesion->registros()->where('modalidad', 'presencial')->count(),
            'virtuales' => $sesion->registros()->where('modalidad', 'virtual')->count(),
            'checkins' => $sesion->registros()->whereNotNull('check_in_at')->count(),
            'sin_modalidad' => $sesion->registros()->whereNull('modalidad')->count(),
        ];

        return view('panel-copladep.sesiones.show', compact('sesion', 'metricas'));
    }

    public function edit(SesionCopladep $sesion)
    {
        return view('panel-copladep.sesiones.form', compact('sesion'));
    }

    public function update(Request $request, SesionCopladep $sesion)
    {
        $sesion->update($this->validated($request, $sesion));

        return redirect()->route('panel-copladep-sesiones.show', $sesion)->with('success', 'Sesión actualizada correctamente.');
    }

    private function validated(Request $request, ?SesionCopladep $sesion = null): array
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:ordinaria,extraordinaria',
            'numero' => 'nullable|integer|min:1|max:99',
            'anio' => 'required|integer|min:2020|max:2100',
            'descripcion' => 'nullable|string|max:1000',
            'estado' => 'required|in:preparacion,abierta,cerrada,concluida',
            'registro_inicio' => 'nullable|date',
            'registro_fin' => 'nullable|date|after:registro_inicio',
            'fecha_evento' => 'nullable|date',
            'lugar' => 'nullable|string|max:255',
            'enlace_virtual' => 'nullable|url|max:255',
            'ruta_publica' => 'nullable|string|max:255',
            'agenda_texto' => 'nullable|string|max:5000',
        ]);

        if (! $sesion) {
            $base = Str::of($data['anio'] . '-' . ($data['numero'] ? $data['numero'] . '-' : '') . $data['tipo'] . '-' . $data['nombre'])->slug('-')->toString();
            $clave = $base;
            $sufijo = 2;
            while (SesionCopladep::where('clave', $clave)->exists()) {
                $clave = $base . '-' . $sufijo++;
            }
            $data['clave'] = $clave;
        }
        $data['agenda'] = collect(preg_split('/\r\n|\r|\n/', $data['agenda_texto'] ?? ''))->map(fn ($punto) => trim($punto))->filter()->values()->all();
        unset($data['agenda_texto']);

        return $data;
    }
}
