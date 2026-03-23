<?php
// local
namespace App\Http\Controllers;

use App\Models\FormularioContacto;
use Illuminate\Http\Request;

class FormularioContactoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-contacto|borrar-contacto', ['only' => ['index']]);
        $this->middleware('permission:borrar-contacto', ['only' => ['destroy']]);
    }

    /**
     * Muestra un listado paginado de los documentos de los  mensajes de contacto paginado a 1000 registros.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $mensajes = FormularioContacto::paginate(1000);
        return view('panel-contacto.index', compact('mensajes'));
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
     * Valida y almacena un nuevo registro de mensaje de contacto en la base de datos.
     *
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con los datos del nuevo documento.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'correo' => 'required|email|max:255',
            'telefono' => 'required|string|max:15',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|max:350',
            'g-recaptcha-response' => 'required|captcha'
        ], [
            'nombre.required' => 'El nombre de la persona es requerido',
            'nombre.string' => 'El nombre no puede contener números',
            'nombre.max' => 'El nombre no puede contener más de 255 caracteres',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios',

            'correo.required' => 'Se requiere un correo electrónico de contacto',
            'correo.email' => 'El dato ingresado no cumple con las características de un correo',
            'correo.max' => 'El correo no puede contener más de 255 caracteres',

            'telefono.required' => 'Se requiere un número de teléfono de contacto',
            'telefono.string' => 'El número parece ser incorrecto',
            'telefono.max' => 'El número no puede contener más de 15 dígitos',
            
            'asunto.required' => 'Se requiere un tipo un asunto del mensaje',
            'asunto.string' => 'El asunto no puede contener números',
            'asunto.max' => 'El asunto no puede contener más de 255 caracteres',

            'mensaje.required' => 'Se requiere un mensaje',
            'mensaje.max' => 'Su mensaje es muy largo, pruebe simplificarlo ',

            'g-recaptcha-response.required' => 'Por favor, complete el captcha',
            'g-recaptcha-response.captcha' => 'Validación del captcha fallida, ¡intente nuevamente más tarde o contacte al administrador del sitio!'
        ]);


        $FormularioContacto = $request->all();

        FormularioContacto::create($FormularioContacto);

        return redirect('/contacto')->with('success', 'Su mensaje se ha enviado correctamente');
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
     * Elimina un mensaje de la base de datos.
     *
     * @param  int  $id El ID del mensaje a eliminar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $mensaje = FormularioContacto::findOrFail($id);
        $mensaje->delete();
        return redirect()->route('formulariocontacto.index')->with('success', 'Mensaje eliminado correctamente.');
    }
}
