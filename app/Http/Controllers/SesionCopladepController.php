<?php

namespace App\Http\Controllers;

class SesionCopladepController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-listado-registro-copladep');
    }

    public function index()
    {
        $sesiones = [
            [
                'nombre' => 'Primera Sesión Ordinaria 2026',
                'descripcion' => 'Asamblea Plenaria del COPLADEP',
                'estado' => 'Concluida',
                'estado_clase' => 'text-bg-secondary',
                'ruta_registros' => 'copladep-registro.index',
                'ruta_publica' => '/copladep/primera-sesion-ordinaria',
            ],
            [
                'nombre' => 'Segunda Sesión Ordinaria 2026',
                'descripcion' => 'Asamblea Plenaria del COPLADEP',
                'estado' => 'En preparación',
                'estado_clase' => 'text-bg-primary',
                'ruta_registros' => 'copladep-registro-segunda.index',
                'ruta_publica' => '/copladep/segunda-sesion-ordinaria',
            ],
        ];

        return view('panel-copladep.sesiones.index', compact('sesiones'));
    }
}
