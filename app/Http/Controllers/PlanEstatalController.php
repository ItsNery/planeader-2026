<?php
// local
namespace App\Http\Controllers;

use App\Models\PlanEstatal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Banner;
use Illuminate\Support\Str;
use App\Traits\UpdatesPublicado;

class PlanEstatalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-plan-estatal|crear-plan-estatal|editar-plan-estatal|borrar-plan-estatal', ['only' => ['index']]);
        $this->middleware('permission:crear-plan-estatal', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-plan-estatal', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-plan-estatal', ['only' => ['destroy']]);
    }

    /**
     * Muestra un listado paginado de los planes estatales de desarrollo ordenados de menos reciente a mas reciente, paginado cada 1000 registros.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $planesEst = PlanEstatal::orderBy('periodo', 'asc')->get();
        return view('panel-planes-estatales.index', compact('planesEst'));
    }

    /**
     * Muestra el formulario para subir un nuevo documento de plan estatal.
     *
     * Pre-carga los datos necesarios para los selectores del formulario
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('panel-planes-estatales.form');
    }

    /**
     * Valida y almacena un nuevo documento de plan estatal en la base de datos.
     *
     * Gestiona la subida y el almacenamiento del archivo pdf e imagen asociados.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con los datos del nuevo documento de plan estatal.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|string|max:120',
            'periodo' => 'required|string|regex:/^\d{4}(-\d{4})?$/',
            'ruta_documento' => 'required|file|mimes:pdf|max:102400',
            'portada' => 'required|image|mimes:jpeg,png,svg,jpg,webp|max:6144',
            'gobernador' => 'required|string|max:255',
            'publicado' => 'nullable|boolean'

        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'nombre.string' => 'El nombre del documento debe ser texto.',
            'nombre.max' => 'El nombre del documento no debe contener más de :max caracteres.',

            'periodo.required' => 'El periodo del plan municipal es obligatorio.',
            'periodo.string' => 'El formato del periodo es inválido.',
            'periodo.regex' => 'El periodo debe estar en el formato AAAA o AAAA-AAAA (ej. 2023 o 2023-2025).',

            'ruta_documento.required' => 'Debes seleccionar un archivo para el documento.',
            'ruta_documento.file' => 'El campo documento debe ser un archivo válido.',
            'ruta_documento.mimes' => 'El archivo del documento debe ser de tipo PDF.',
            'ruta_documento.max' => 'El tamaño del documento no debe superar los 100 MB.',

            'portada.required' => 'Es obligatorio seleccionar una imagen de portada.',
            'portada.image' => 'El archivo de portada debe ser una imagen.',
            'portada.mimes' => 'La imagen de portada debe ser de tipo JPEG, PNG, JPG o SVG.',
            'portada.max' => 'El tamaño de la imagen de portada no debe superar los 6 MB.',

            'gobernador.required' => 'El nombre del gobernador es obligatorio.',
            'gobernador.string' => 'El nombre del gobernador debe ser texto.',
            'gobernador.max' => 'El nombre del gobernador no debe exceder los :max caracteres.',

            'publicado.boolean' => 'El estado solo puede ser publicado o no publicado'
        ]);

        $planesEstatales = $request->all();

        if ($ruta_planesEst = $request->file('ruta_documento')) {
            $rutaGuardarDoc = 'planesest/';
            $originalName = $request->input('nombre');
            $originalName = Str::slug($originalName) . '-' . Str::random(4) . "." . $ruta_planesEst->getClientOriginalExtension();

            $ruta_planesEst->move($rutaGuardarDoc, $originalName);
            $planesEstatales['ruta_documento'] = $originalName;
        }

        if ($portada = $request->file('portada')) {
            $rutaGuardarImg = 'portadaplanesest/';
            $nombrePortada = $request->input('nombre');
            $nombrePortada = Str::slug($nombrePortada) . '-' . Str::random(4) . "." . $portada->getClientOriginalExtension();
            $portada->move($rutaGuardarImg, $nombrePortada);
            $planesEstatales['portada'] = $nombrePortada;
        }

        PlanEstatal::create($planesEstatales);
        return redirect()->route('panel-planes-estatales.index')->with('success', 'Plan subido exitosamente.');
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
     * Muestra el formulario para editar un documento existente.
     *
     * Carga los datos del documento a editar y la información necesaria
     * (planesEst, ordenesExistentes, ordenesDisponibles).
     *
     * @param  int  $id El ID del documento de plan estatal a editar.
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $planesEst = PlanEstatal::findOrFail($id);
        return view('panel-planes-estatales.form', compact('planesEst'));
    }

    /**
     * Valida y actualiza un documento existente en la base de datos.
     *
     * Gestiona la actualización del documento y portada, eliminando los anteriores si se sube uno nuevo.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud con los datos actualizados.
     * @param  int  $id El ID del documento a actualizar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required|string|max:120',
            'periodo' => 'required|string|regex:/^\d{4}(-\d{4})?$/',
            'ruta_documento' => 'nullable|file|mimes:pdf|max:102400',
            'portada' => 'nullable|image|mimes:jpeg,png,svg,jpg,webp|max:6144',
            'gobernador' => 'required|string|max:255',
            'publicado' => 'nullable|boolean'
        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'nombre.string' => 'El nombre del documento no es valido',
            'nombre.max' => 'El nombre del documento no debe contener más de :max caracteres',

            'periodo.required' => 'El periodo del plan municipal es requerido',
            'periodo.string' => 'El formato del periodo es inválido',
            'periodo.regex' => 'El periodo debe estar en el formato AAAA o AAAA-AAAA',

            'ruta_documento.mimes' => 'El archivo debe ser PDF (Formato de documento portátil)',
            'ruta_documento.max' => 'El archivo no debe pesar más de 100MB',
            'ruta_documento.file' => 'El campo documento debe ser un archivo válido',

            'portada.image' => 'El archivo de portada debe ser una imagen.',
            'portada.mimes' => 'La imagen de portada debe ser de tipo JPEG, PNG, JPG o SVG.',
            'portada.max' => 'El tamaño de la imagen de portada no debe superar los 6 MB.',

            'gobernador.required' => 'El nombre del gobernador es obligatorio.',
            'gobernador.string' => 'El nombre del gobernador debe ser texto.',
            'gobernador.max' => 'El nombre del gobernador no debe exceder los :max caracteres.',

            'publicado.boolean' => 'El estado solo puede ser publicado o no publicado'
        ]);

        $planesEstatales = PlanEstatal::findOrFail($id);

        $planesEstatales->nombre = $request->nombre;
        $planesEstatales->periodo = $request->periodo;
        $planesEstatales->gobernador = $request->gobernador;

        if ($request->hasFile('ruta_documento')) {
            if ($planesEstatales->ruta_documento) {
                unlink(public_path('planesest/') . $planesEstatales->ruta_documento);
            }

            $ruta_documento = $request->file('ruta_documento');
            $nombre_documento = $request->input('nombre');
            $nombre_documento = Str::slug($nombre_documento) . '-' . Str::random(4) . '.' . $ruta_documento->getClientOriginalExtension();
            $ruta_documento->move(public_path('planesest/'), $nombre_documento);
            $planesEstatales->ruta_documento = $nombre_documento;
        }

        if ($request->hasFile('portada')) {
            if ($planesEstatales->portada) {
                unlink(public_path('portadaplanesest/') . $planesEstatales->portada);
            }

            $portada = $request->file('portada');
            $nombre_portada = $request->input('nombre');
            $nombre_portada = Str::slug($nombre_portada) . '-' . Str::random(4) . '.' . $portada->getClientOriginalExtension();
            $portada->move(public_path('portadaplanesest/'), $nombre_portada);
            $planesEstatales->portada = $nombre_portada;
        }

        if ($request->has('publicado')) {
            $planesEstatales->publicado = $request->publicado;
        }

        $planesEstatales->save();

        return redirect()->route('panel-planes-estatales.index')->with('success', 'Plan actualizado exitosamente.');
    }

    /**
     * Elimina un documento de la base de datos y su archivo pdf e imagen asociado.
     *
     * @param  int  $id El ID del documento a eliminar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $planesEst = PlanEstatal::findOrFail($id);

        $rutaArchivo2 = public_path('planesest/') . $planesEst->ruta_documento;

        if (file_exists($rutaArchivo2)) {
            unlink($rutaArchivo2);
        }

        $rutaArchivo = public_path('portadaplanesest/') . $planesEst->portada;

        if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
        }

        $planesEst->delete();

        return redirect()->route('panel-planes-estatales.index')->with('success', 'Documento eliminado exitosamente.');
    }

    /**
     * Muestra un listado de los documentos de planes estatales de desarrollo.
     * Encuentra el plan más reciente entre los planes publicados, definido manualmente
     * Consulta todos los planes estatales publicados excepto el más reciente, ordenados por periodo (descendente)
     * Si no se encuentra el plan más reciente, consulta todos los planes estatales publicados ordenados por periodo (descendente)
     * @return \Illuminate\View\View
     */
    public function mostrarPlanEstatal()
    {
        // Obtener los planes estatales publicados con sus anexos
        $planes_publicados = PlanEstatal::with('anexos')->where('publicado', 1)->get();

        //
        $plan_reciente = $planes_publicados->where('nombre', 'Plan Estatal de Desarrollo 2024-2030')->first();

        if ($plan_reciente) {
            
            $planes_estatales = $planes_publicados->where('id', '!=', $plan_reciente->id)
                ->sortBy('orden');
        } else {
            $planes_estatales = $planes_publicados->sortBy('orden');
        }

        return view('planestatal', compact('planes_estatales', 'plan_reciente'));
    }

    use UpdatesPublicado;
    /**
     * Define el modelo principal que este controlador gestiona
     * para ser utilizado por el trait UpdatesPublicado.
     *
     * @return string La clase del modelo PlanEstatal.
     */
    protected function getModel()
    {
        return PlanEstatal::class;
    }
}
