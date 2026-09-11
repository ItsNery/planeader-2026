<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encuesta;
class EncuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     * Actualmente no se utiliza, pero se deja como parte de la estructura del controlador.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * Actualmente no se utiliza, pero se deja como parte de la estructura del controlador.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * Actualmente no se utiliza, pero se deja como parte de la estructura del controlador.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * Actualmente no se utiliza, pero se deja como parte de la estructura del controlador.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * Actualmente no se utiliza, pero se deja como parte de la estructura del controlador.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * Actualmente no se utiliza, pero se deja como parte de la estructura del controlador.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * Actualmente no se utiliza, pero se deja como parte de la estructura del controlador.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    /**
     * Almacena la respuesta de satisfacción de una encuesta.
     *
     * Este método valida la entrada para asegurar que el campo 'satisfaccion'
     * sea requerido y su valor esté dentro de las opciones permitidas (1, 2 o 3).
     * Una vez validado, crea un nuevo registro en el modelo Encuesta
     * con el nivel de satisfacción proporcionado.
     *
     * @param  \Illuminate\Http\Request  $request La instancia de la solicitud HTTP que contiene los datos del formulario.
     * @return \Illuminate\Http\JsonResponse Retorna una respuesta JSON indicando el éxito de la operación.
     */
    public function guardarRespuesta(Request $request)
    {
        $request->validate([
            'satisfaccion' => 'required|in:1,2,3',
        ]);

        $respuesta = new Encuesta();
        $respuesta->satisfaccion = $request->input('satisfaccion');
        $respuesta->save();

        return response()->json(['success' => true]);
    }
}
