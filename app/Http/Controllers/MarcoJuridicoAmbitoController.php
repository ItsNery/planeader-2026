<?php

namespace App\Http\Controllers;

use App\Models\MarcoJuridicoAmbito;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MarcoJuridicoAmbitoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-marco-juridico|crear-marco-juridico|editar-marco-juridico|borrar-marco-juridico', ['only' => ['index']]);
        $this->middleware('permission:crear-marco-juridico', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-marco-juridico', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-marco-juridico', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ambitos = MarcoJuridicoAmbito::orderBy('orden')->paginate(1000);
        return view('panel-marco-juridico-ambitos.index', compact('ambitos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ambito = new MarcoJuridicoAmbito();
        $totalAmbitos = MarcoJuridicoAmbito::count();
        $ordenesExistentes = MarcoJuridicoAmbito::pluck('orden')->toArray();
        $ordenesDisponibles = range(1, $totalAmbitos + 2);

        return view('panel-marco-juridico-ambitos.form', compact('ambito', 'ordenesExistentes', 'ordenesDisponibles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|unique:marco_juridico_ambitos,nombre',
            'orden' => 'required|integer',
            'portada' => 'nullable|image|mimes:jpeg,png,svg,jpg,webp|max:6144',
        ], [
            'nombre.required' => 'El nombre del ámbito es requerido',
            'nombre.unique' => 'Ya existe un ámbito con este nombre',
            'orden.required' => 'El orden es requerido',
            'orden.integer' => 'El orden debe ser un número entero',
            'portada.image' => 'El archivo no es una imagen',
            'portada.mimes' => 'La portada debe ser formato jpeg, png, svg, jpg o webp',
            'portada.max' => 'La portada no debe pesar más de 6MB',
        ]);

        $ambito = new MarcoJuridicoAmbito();
        $ambito->nombre = $request->nombre;
        $ambito->slug = Str::slug($request->nombre);
        $ambito->orden = $request->orden;

        if ($request->hasFile('portada')) {
            $portada = $request->file('portada');
            $rutaGuardarImg = 'portadas-marcojuridico/';
            $nombrePortada = 'portada_ambito_' . Str::slug($request->nombre) . '_' . date('YmdHis') . '.' . $portada->getClientOriginalExtension();
            $portada->move(public_path($rutaGuardarImg), $nombrePortada);
            $ambito->portada = $nombrePortada;
        }

        $ambito->save();

        return redirect()->route('panel-marco-juridico-ambitos.index')->with('success', 'Ámbito creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Not used
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ambito = MarcoJuridicoAmbito::findOrFail($id);
        $totalAmbitos = MarcoJuridicoAmbito::count();
        $ordenesExistentes = MarcoJuridicoAmbito::pluck('orden')->toArray();
        $ordenesDisponibles = range(1, $totalAmbitos + 1);

        return view('panel-marco-juridico-ambitos.form', compact('ambito', 'ordenesExistentes', 'ordenesDisponibles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ambito = MarcoJuridicoAmbito::findOrFail($id);

        $this->validate($request, [
            'nombre' => 'required|unique:marco_juridico_ambitos,nombre,' . $id,
            'orden' => 'required|integer',
            'portada' => 'nullable|image|mimes:jpeg,png,svg,jpg,webp|max:6144',
        ], [
            'nombre.required' => 'El nombre del ámbito es requerido',
            'nombre.unique' => 'Ya existe un ámbito con este nombre',
            'orden.required' => 'El orden es requerido',
            'orden.integer' => 'El orden debe ser un número entero',
            'portada.image' => 'El archivo no es una imagen',
            'portada.mimes' => 'La portada debe ser formato jpeg, png, svg, jpg o webp',
            'portada.max' => 'La portada no debe pesar más de 6MB',
        ]);

        $ambito->nombre = $request->nombre;
        $ambito->slug = Str::slug($request->nombre);
        $ambito->orden = $request->orden;

        if ($request->hasFile('portada')) {
            // Eliminar la portada anterior si existe
            if ($ambito->portada) {
                $rutaVieja = public_path('portadas-marcojuridico/') . $ambito->portada;
                if (file_exists($rutaVieja)) {
                    unlink($rutaVieja);
                }
            }

            $portada = $request->file('portada');
            $rutaGuardarImg = 'portadas-marcojuridico/';
            $nombrePortada = 'portada_ambito_' . Str::slug($request->nombre) . '_' . date('YmdHis') . '.' . $portada->getClientOriginalExtension();
            $portada->move(public_path($rutaGuardarImg), $nombrePortada);
            $ambito->portada = $nombrePortada;
        }

        $ambito->save();

        return redirect()->route('panel-marco-juridico-ambitos.index')->with('success', 'Ámbito actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ambito = MarcoJuridicoAmbito::findOrFail($id);

        // Validar si tiene clasificaciones asociadas
        if ($ambito->clasificaciones()->exists()) {
            return redirect()->route('panel-marco-juridico-ambitos.index')
                ->with('error', 'No se puede eliminar el ámbito porque está asociado a una o más clasificaciones normativas.');
        }

        // Eliminar portada del servidor
        if ($ambito->portada) {
            $rutaPortada = public_path('portadas-marcojuridico/') . $ambito->portada;
            if (file_exists($rutaPortada)) {
                unlink($rutaPortada);
            }
        }

        $ambito->delete();

        return redirect()->route('panel-marco-juridico-ambitos.index')->with('success', 'Ámbito eliminado exitosamente.');
    }
}
