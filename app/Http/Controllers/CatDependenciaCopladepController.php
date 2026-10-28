<?php

namespace App\Http\Controllers;

use App\Models\CatDependenciaCopladep;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CatDependenciaCopladepController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-listado-registro-copladep');
    }

    public function index()
    {
        $dependencias = CatDependenciaCopladep::withCount('invitados')->orderBy('nombre')->get();

        return view('panel-copladep.dependencias.index', compact('dependencias'));
    }

    public function store(Request $request)
    {
        CatDependenciaCopladep::create($this->validated($request));

        return redirect()->route('panel-copladep-dependencias.index')->with('success', 'Dependencia registrada correctamente.');
    }

    public function storeQuick(Request $request)
    {
        $dependencia = CatDependenciaCopladep::create($request->validate([
            'nombre' => 'required|string|max:255|unique:cat_dependencias_copladep,nombre',
            'siglas' => 'nullable|string|max:30',
        ]) + ['activo' => true]);

        return response()->json([
            'id' => $dependencia->id,
            'nombre' => $dependencia->nombre,
        ], 201);
    }

    public function update(Request $request, CatDependenciaCopladep $dependencia)
    {
        $dependencia->update($this->validated($request, $dependencia));

        return redirect()->route('panel-copladep-dependencias.index')->with('success', 'Dependencia actualizada correctamente.');
    }

    public function destroy(CatDependenciaCopladep $dependencia)
    {
        if ($dependencia->invitados()->exists()) {
            return back()->withErrors(['dependencia' => 'No se puede eliminar una dependencia con invitados históricos asociados.']);
        }

        $dependencia->delete();

        return redirect()->route('panel-copladep-dependencias.index')->with('success', 'Dependencia eliminada.');
    }

    private function validated(Request $request, ?CatDependenciaCopladep $dependencia = null): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:255', Rule::unique('cat_dependencias_copladep', 'nombre')->ignore($dependencia)],
            'siglas' => 'nullable|string|max:30',
            'activo' => 'boolean',
        ]) + ['activo' => $request->boolean('activo')];
    }
}
