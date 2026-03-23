<?php
// local
namespace App\Http\Controllers;

use App\Models\ProgramaEstatal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\UpdatesPublicado;
use App\Models\PlanEstatal;

class ProgramaEstatalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-programa-estatales|crear-programa-estatales|editar-programa-estatales|borrar-programa-estatales', ['only' => ['index']]);
        $this->middleware('permission:crear-programa-estatales', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-programa-estatales', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-programa-estatales', ['only' => ['destroy']]);
    }

    /**
     * Muestra un listado paginado de los documentos de los programas estatales.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $programas = ProgramaEstatal::all();

        return view('panel-programas-estatales.index', compact('programas'));
    }

    /**
     * Muestra el formulario para subir un nuevo documento de programa estatal.
     *
     * Pre-carga los datos necesarios para los selectores del formulario.
     * (planes_estatales para acceder al campo periodo)
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $programa = new ProgramaEstatal();
        $planes_estatales = PlanEstatal::all();
        return view('panel-programas-estatales.form', compact('planes_estatales', 'programa'));
    }

    /**
     * Valida y almacena un nuevo documento de programa derivado en la base de datos.
     *
     * Gestiona la subida y el almacenamiento del archivo pdf asociado.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con los datos del nuevo documento de programa derivado.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|string|max:200',
            'ruta_documento' => 'required|file|mimes:pdf|max:52400',
            'portada' => 'required|image|mimes:jpeg,png,svg,jpg|max:6144',
            'publicado' => 'nullable|boolean',
            'planestatal_id' => 'required|exists:plan_estatals,id',

        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'nombre.max' => 'El nombre del documento no puede tener más de 200 caracteres',
            'nombre.string' => 'El nombre del documento no puede llevar carácteres especiales',

            'ruta_documento.mimes' => 'El archivo debe ser PDF (Formato de documento portátil)',
            'ruta_documento.required' => 'No has seleccionado un archivo',
            'ruta_documento.max' => 'El archivo no debe pesar más de 50MB',
            'ruta_documento.file' => 'El archivo debe ser un documento válido',

            'planestatal_id.required' => 'Se necesita elegir un plan Estatal',
            'planestatal_id.exists' => 'El plan estatal seleccionado no existe',

            'portada.required' => 'Se requiere la portada del programa',
            'portada.image' => 'El archivo no es una imagen',
            'portada.mimes' => 'El archivo no es una imagen',
            'portada.max' => 'La imagen no debe pesar mas de 6MB',

            'publicado.boolean' => 'El estado puede ser sólo: Publicado o No Publicado'
        ]);


        $programaEstatal = $request->all();

        if ($ruta_progDer = $request->file('ruta_documento')) {
            $rutaGuardarDoc = 'programasEstatales/';
            $nombre_documento = $request->input('nombre');
            $nombre_documento = Str::slug($nombre_documento) . '-' . Str::random(4) . '.' . $ruta_progDer->getClientOriginalExtension();
            $ruta_progDer->move(public_path($rutaGuardarDoc), $nombre_documento);
            $programaEstatal['ruta_documento'] = $nombre_documento;
        }

        if ($portada = $request->file('portada')) {
            $rutaGuardarImg = 'img/portadas-programas-estatales/';
            $nombre_portada = $request->input('nombre');
            $nombre_portada = Str::slug($nombre_portada) . '-' . Str::random(4) . '.' . $portada->getClientOriginalExtension();
            $portada->move(public_path($rutaGuardarImg), $nombre_portada);
            $programaEstatal['portada'] = $nombre_portada;
        }
        $planReciente = PlanEstatal::orderBy('periodo', 'desc')->first();

        if ($planReciente) {
            $programaEstatal['historico'] = ($request->planestatal_id == $planReciente->id) ? 0 : 1;
        } else {
            $programaEstatal['historico'] = 1;
        }

        ProgramaEstatal::create($programaEstatal);
        return redirect()->route('panel-programas-estatales.index')->with('success', 'Programa subido exitosamente.');
    }

    /**
     * Display the specified resource.
     * Actualmente no se utiliza, pero se deja como parte de la estructura del controlador.
     * @param  \App\Models\ProgramaEstatal  $programaEstatal
     * @return \Illuminate\Http\Response
     */
    public function show(ProgramaEstatal $programaEstatal)
    {
        //
    }

    /**
     * Muestra el formulario para editar un documento existente.
     *
     * Carga los datos del documento a editar y la información necesaria
     * (planes_estatales, programaEstatal).
     *
     * @param  int  $id El ID del documento de programa estatal a editar.
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $planes_estatales = PlanEstatal::orderBy('periodo', 'desc')->get();
        $programa = ProgramaEstatal::findOrFail($id);
        return view('panel-programas-estatales.form', compact('programa', 'planes_estatales'));
    }

    /**
     * Valida y actualiza un documento existente en la base de datos.
     *
     * Gestiona la actualización del documento e imagen, eliminando los anteriores si se sube uno nuevo.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud con los datos actualizados.
     * @param  int  $id El ID del documento a actualizar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required|string|max:200',
            'ruta_documento' => 'nullable|file|mimes:pdf|max:52400',
            'portada' => 'nullable|image|mimes:jpeg,png,svg,jpg|max:6144',
            'publicado' => 'nullable|boolean',
            'planestatal_id' => 'required|exists:plan_estatals,id',
        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'nombre.string' => 'El nombre del documento no puede llevar carácteres especiales',
            'nombre.max' => 'El nombre del documento no puede tener más de 200 caracteres',

            'ruta_documento.mimes' => 'El archivo debe ser PDF (Formato de documento portátil)',
            'ruta_documento.max' => 'El archivo no debe pesar más de 50MB',
            'ruta_documento.file' => 'El archivo debe ser un documento válido',

            'portada.image' => 'El archivo no es una imagen',
            'portada.mimes' => 'El archivo no es una imagen',
            'portada.max' => 'La imagen no debe pesar más de 6MB',

            'publicado.boolean' => 'El estado puede ser sólo: Publicado o No Publicado',

            'planestatal_id.required' => 'Se necesita elegir un plan Estatal',
            'planestatal_id.exists' => 'El plan estatal seleccionado no existe',
        ]);

        $programaEstatal = ProgramaEstatal::findOrFail($id);

        $planReciente = PlanEstatal::orderBy('periodo', 'desc')->first();
        $programaEstatal->nombre = $request->nombre;
        $programaEstatal->planestatal_id = $request->planestatal_id;
        if ($planReciente) {
            $programaEstatal['historico'] = ($request->planestatal_id == $planReciente->id) ? 0 : 1;
        } else {
            $programaEstatal['historico'] = 1;
        }
        if ($request->hasFile('ruta_documento')) {
            if ($programaEstatal->ruta_documento) {
                unlink(public_path('programasEstatales/') . $programaEstatal->ruta_documento);
            }

            $ruta_documento = $request->file('ruta_documento');
            $nombre_documento = $request->input('nombre');
            $nombre_documento = Str::slug($nombre_documento) . '-' . Str::random(4) . '.' . $ruta_documento->getClientOriginalExtension();
            $ruta_documento->move(public_path('programasEstatales/'), $nombre_documento);
            $programaEstatal->ruta_documento = $nombre_documento;
        }

        if ($request->hasFile('portada')) {
            if ($programaEstatal->portada) {
                unlink(public_path('img/portadas-programas-estatales/') . $programaEstatal->portada);
            }

            $portada = $request->file('portada');
            $nombre_portada = $request->input('nombre');
            $nombre_portada = Str::slug($nombre_portada) . '-' . Str::random(4) . '.' . $portada->getClientOriginalExtension();
            $portada->move(public_path('img/portadas-programas-estatales/'), $nombre_portada);
            $programaEstatal->portada = $nombre_portada;
        }

        if ($request->has('publicado')) {
            $programaEstatal->publicado = $request->publicado;
        }

        $programaEstatal->save();

        return redirect()->route('panel-programas-estatales.index')->with('success', 'Programa actualizado exitosamente.');
    }

    /**
     * Elimina un documento de la base de datos y su archivo pdf e imagen asociado.
     *
     * @param  int  $id El ID del documento a eliminar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $programaEstatal = ProgramaEstatal::findOrFail($id);

        if (file_exists(public_path('img/portadas-programas-estatales//' . $programaEstatal->portada))) {
            unlink(public_path('img/portadas-programas-estatales//' . $programaEstatal->portada));
        }

        if (file_exists(public_path('programasEstatales/' . $programaEstatal->ruta_documento))) {
            unlink(public_path('programasEstatales/' . $programaEstatal->ruta_documento));
        }

        $programaEstatal->delete();

        return redirect()->route('panel-programas-estatales.index')->with('success', 'Programa eliminado exitosamente.');
    }

    /**
     * Displays the programs-estatales view, categorizing and organizing state programs.
     *
     * This method retrieves two main sets of state programs:
     * 1. Current Programs: Those marked as 'historico' (historical) as false (0) and 'publicado' (published) as true (1).
     * 2. Historical Programs: Those marked as 'historico' (historical) as true (1) and 'publicado' (published) as true (1).
     * These historical programs are also loaded with their associated 'planEstatal' and then
     * grouped by their 'planestatal_id' for organized display.
     *
     * The method then renders the 'programas-estatales' view, passing both sets of programs.
     *
     * @return \Illuminate\View\View Returns the 'programas-estatales' view with the following data:
     * - 'programas': Current state programs.
     * - 'historico_programas_agrupados': Historical state programs, grouped by their associated state plan ID.
     */
    public function mostrarProgramasEstatales()
    {
        $programas = ProgramaEstatal::where('historico', '0')->where('publicado', '1')->get();

        $programasHistoricos = ProgramaEstatal::where('historico', '1')
            ->where('publicado', '1')
            ->with('planEstatal')
            ->get();

        $historico_programas_agrupados = $programasHistoricos->groupBy('planestatal_id');

        return view('programas-estatales', compact('programas', 'historico_programas_agrupados'));
    }

    use UpdatesPublicado;
    /**
     * Define el modelo principal que este controlador gestiona
     * para ser utilizado por el trait UpdatesPublicado.
     *
     * @return string La clase del modelo ProgramaEstatal.
     */
    protected function getModel()
    {
        return ProgramaEstatal::class;
    }
}
