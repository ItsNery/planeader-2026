<?php

namespace App\Http\Controllers;

use App\Models\InvitadoCopladep;
use App\Models\CatMunicipio;

use Illuminate\Http\Request;

class InvitadoCopladepController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-invitado-copladep|crear-invitado-copladep|editar-invitado-copladep|borrar-invitado-copladep', ['only' => ['index']]);
        $this->middleware('permission:crear-invitado-copladep', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-invitado-copladep', ['only' => ['update']]);
        $this->middleware('permission:borrar-invitado-copladep', ['only' => ['destroy']]);
    }

    public function index()
    {
        $invitados = InvitadoCopladep::with('municipio')->orderBy('nombre_completo', 'asc')->get();
        $municipios = CatMunicipio::orderBy('nombre_municipio', 'asc')->get();

        return view('panel-copladep.primera-sesion-ordinaria-2026.invitados-copladep', compact('invitados', 'municipios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:50',
            'sexo' => 'required|string|in:Hombre,Mujer,Otro',
            'cargo' => 'required|string|max:191',
            'municipio_id' => 'nullable|integer|exists:cat_municipios,id',
        ]);

        InvitadoCopladep::create($request->all());

        return redirect()->route('copladep-registro-invitados.index')->with('success', 'Invitado registrado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'sexo'            => 'required|in:Hombre,Mujer,Otro',
            'cargo'           => 'required|string|max:255',
            'municipio_id'    => 'required|integer|exists:cat_municipios,id',
        ]);

        $invitado = InvitadoCopladep::findOrFail($id);
        $invitado->update($request->all());

        return redirect()->route('copladep-registro-invitados.index')
            ->with('success', '¡Datos del invitado actualizados correctamente!');
    }

    public function destroy($id)
    {
        try {
            InvitadoCopladep::findOrFail($id)->delete();
            return redirect()->route('copladep-registro-invitados.index')->with('success', 'Invitado eliminado.');
        } catch (\Exception $e) {
            return redirect()->route('copladep-registro-invitados.index')->withErrors(['error' => 'No se puede eliminar a este invitado porque ya tiene un registro de asistencia vinculado.']);
        }
    }

    public function monitor()
    {
        $invitados = InvitadoCopladep::with('registro')->orderBy('nombre_completo', 'asc')->get();

        $total = $invitados->count();
        $asistencias = $invitados->filter(function ($invitado) {
            return $invitado->registro || $invitado->check_in_express;
        })->count();
        $faltantes = $total - $asistencias;

        return view('panel-copladep.primera-sesion-ordinaria-2026.monitor-invitados', compact('invitados', 'total', 'asistencias', 'faltantes'));
    }
    public function toggleCheckInExpress($id)
    {
        $invitado = InvitadoCopladep::findOrFail($id);

        if ($invitado->registro) {
            return response()->json([
                'success' => false,
                'message' => 'Este invitado ya realizó su registro de asistencia en el formulario.'
            ]);
        }


        $invitado->check_in_express = !$invitado->check_in_express;
        $invitado->save();

        return response()->json([
            'success' => true,
            'estado_actual' => $invitado->check_in_express,
            'message' => $invitado->check_in_express ? '¡Check-in Express activado!' : 'Check-in Express revertido.'
        ]);
    }
}
