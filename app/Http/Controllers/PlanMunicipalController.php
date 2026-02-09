<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use App\Models\PlanMunicipal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use App\Traits\UpdatesPublicado;
use App\Models\CatMunicipio;
use Illuminate\Http\JsonResponse;

class PlanMunicipalController extends Controller
{
    /**
     * Muestra un listado paginado de los planes municipales de desarrollo.
     * Se pasa la variable municipios para que se pueda acceder a los nombres de los municipios en la vista.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $municipios = Municipio::all();
        $planesMun = PlanMunicipal::all();
        return view('panel-planes-municipales.index', compact('planesMun', 'municipios'));
    }

    /**
     * Muestra el formulario para subir un nuevo documento de plan municipal.
     *
     * Pre-carga los datos necesarios para los selectores del formulario.
     * (municipios)
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $planMun = new PlanMunicipal();
        $municipios = Municipio::all();
        return view('panel-planes-municipales.form', compact('municipios', 'planMun'));
    }

    /**
     * Valida y almacena un nuevo documento de plan municipal en la base de datos.
     *
     * Gestiona la subida y el almacenamiento del archivo pdf asociado.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con los datos del nuevo documento de plan municipal.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|max:120',
            'periodo' => 'required|string|regex:/^\d{4}-\d{4}$/',
            'ruta_documento' => 'required|file|mimes:pdf|max:52400',
            'municipio_id' => 'required|exists:municipios,id',
            'publicado' => 'nullable|boolean'
        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'nombre.max' => 'El nombre no puede tener más de :max carácteres',

            'periodo.required' => 'El periodo del plan municipal es requerido',
            'periodo.string' => 'El periodo debe no parece valido',
            'periodo.regex' => 'El periodo debe estar en el formato AAAA-AAAA',

            'ruta_documento.required' => 'No has elegido un documento',
            'ruta_documento.file' => 'El campo documento debe ser un archivo válido.',
            'ruta_documento.mimes' => 'El archivo debe ser PDF (Formato de documento portátil)',
            'ruta_documento.max' => 'El archivo debe pesar menos de 50MB',

            'municipio_id.required' => 'Falta seleccionar un municipio',
            'municipio_id.exists' => 'El municipio seleccionado no es válido',

            'publicado.boolean' => 'El estado solo puede ser publicado o no publicado'
        ]);

        $planesMunicipales = $request->all();

        if ($ruta_planesMun = $request->file('ruta_documento')) {
            $rutaGuardarDoc = 'planesmun/';
            $originalName = $request->input('nombre');
            $originalName = Str::slug($originalName) . '-' . Str::random(4) . "." . $ruta_planesMun->getClientOriginalExtension();

            $ruta_planesMun->move($rutaGuardarDoc, $originalName);
            $planesMunicipales['ruta_documento'] = $originalName;
        }

        PlanMunicipal::create($planesMunicipales);
        return redirect()->route('panel-planes-municipales.index')->with('success', 'Plan subido exitosamente.');
    }

    /**
     * Display the specified resource.
     * Actualmente no se utiliza, pero se deja como parte de la estructura del controlador.
     *
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
     * (planesMun, municipios).
     *
     * @param  int  $id El ID del documento de plan municipal a editar.
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $planMun = PlanMunicipal::findOrFail($id);
        $municipios = Municipio::all();
        return view('panel-planes-municipales.form', compact('planMun', 'municipios'));
    }

    /**
     * Valida y actualiza un documento existente en la base de datos.
     *
     * Gestiona la actualización del documento, eliminando los anteriores si se sube uno nuevo.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud con los datos actualizados.
     * @param  int  $id El ID del documento a actualizar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required|string|max:120',
            'periodo' => 'required|string|regex:/^\d{4}-\d{4}$/',
            'ruta_documento' => 'nullable|file|mimes:pdf|max:52400',
            'municipio_id' => 'required|exists:municipios,id',
            'publicado' => 'nullable|boolean'
        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'nombre.string' => 'El nombre debe ser texto',
            'nombre.max' => 'El nombre no puede tener más de 120 carácteres',

            'periodo.required' => 'El periodo del plan municipal es requerido',
            'periodo.regex' => 'El periodo debe estar en el formato AAAA-AAAA',

            'ruta_documento.mimes' => 'El archivo debe ser PDF (Formato de documento portátil)',
            'ruta_documento.max' => 'El archivo debe pesar menos de 50MB',
            'ruta_documento.file' => 'El campo documento debe ser un archivo válido.',

            'municipio_id.required' => 'Falta seleccionar un municipio',
            'municipio_id.exists' => 'El municipio seleccionado no es válido',

            'publicado.boolean' => 'El estado solo puede ser publicado o no publicado'
        ]);

        $planesMunicipales = PlanMunicipal::findOrFail($id);

        $planesMunicipales->nombre = $request->nombre;
        $planesMunicipales->periodo = $request->periodo;
        $planesMunicipales->municipio_id = $request->municipio_id;

        if ($request->hasFile('ruta_documento')) {
            if ($planesMunicipales->ruta_documento) {
                unlink(public_path('planesmun/') . $planesMunicipales->ruta_documento);
            }

            $ruta_documento = $request->file('ruta_documento');
            $nombre_documento = $request->input('nombre');
            $nombre_documento = Str::slug($nombre_documento) . '-' . Str::random(4) . '.' . $ruta_documento->getClientOriginalExtension();
            $ruta_documento->move(public_path('planesmun/'), $nombre_documento);
            $planesMunicipales->ruta_documento = $nombre_documento;
        }

        if ($request->has('publicado')) {
            $planesMunicipales->publicado = $request->publicado;
        }

        $planesMunicipales->save();

        return redirect()->route('panel-planes-municipales.index')->with('success', 'Plan actualizado exitosamente.');
    }


    /**
     * Elimina un documento de la base de datos y su archivo pdf asociado.
     *
     * @param  int  $id El ID del documento a eliminar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $planesMun = PlanMunicipal::findOrFail($id);

        $rutaArchivo2 = public_path('planesmun/') . $planesMun->ruta_documento;

        if (file_exists($rutaArchivo2)) {
            unlink($rutaArchivo2);
        }

        $rutaArchivo = public_path('portadaplanesmun/') . $planesMun->portada;

        if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
        }

        $planesMun->delete();

        return redirect()->route('panel-planes-municipales.index')->with('success', 'Documento eliminado exitosamente.');
    }

    /**
     * Muestra una vista con todos los municipios y sus planes municipales agrupados por periodo.
     *
     * Este método recupera todos los municipios y, para cada uno, obtiene sus planes municipales
     * ordenados del más reciente al más antiguo. Los planes de cada municipio se agrupan
     * adicionalmente por su 'periodo'. Finalmente, se renderiza la vista 'planesmunicipales'
     * con la lista de municipios y una estructura de datos que contiene los planes organizados
     * por municipio y luego por periodo.
     *
     * @return \Illuminate\View\View Retorna la vista 'planesmunicipales' con las variables
     * 'municipios' (todos los municipios) y 'planesPorMunicipio' (planes agrupados por ID de municipio y periodo).
     */
    public function mostrarPlanesMunicipales()
    {
        $municipios = Municipio::all();
        $planesPorMunicipio = [];
        foreach ($municipios as $municipio) {
            $planesPorMunicipio[$municipio->id] = PlanMunicipal::where('municipio_id', $municipio->id)
                ->orderBy('periodo', 'desc')
                ->get()
                ->groupBy('periodo');
        }
        return view('planesmunicipales', compact('municipios', 'planesPorMunicipio'));
    }

    /**
     * Busca y devuelve información sobre el Plan Municipal de Desarrollo más reciente para un municipio específico.
     *
     * Este método busca el plan municipal más reciente para el ID de municipio dado,
     * ordenando los planes por su periodo de forma descendente y tomando solo el primero.
     * Si se encuentra un plan, devuelve una respuesta JSON que incluye la ruta del documento y el nombre del plan.
     * En caso de no encontrar ningún plan para el municipio, retorna un error 404.
     *
     * @param  int  $municipioId El ID del municipio para el cual se busca el plan.
     * @return \Illuminate\Http\JsonResponse Retorna una respuesta JSON con la información del plan
     * (ruta_documento y nombre), o un error 404 si no se encuentra.
     */
    public function obtenerPlanMunicipal($municipioId)
    {

        $planMunicipal = PlanMunicipal::where('municipio_id', $municipioId)
            ->orderBy('periodo', 'desc')
            ->first();

        if ($planMunicipal) {
            return response()->json([
                'ruta_documento' => $planMunicipal->ruta_documento,
                'nombre' => $planMunicipal->nombre
            ]);
        } else {
            // Si no se encontró ningún plan, devuelve un error 404.
            return response()->json(['error' => 'No se encontró ningún plan municipal para este municipio.'], 404);
        }
    }

    /**
     * Obtiene y prepara datos de un municipio y sus planes municipales para ser mostrados en un reporte.
     *
     * Este método busca un municipio por su ID y enriquece sus datos con información de microrregión
     * y macrorregión obtenida de la tabla 'cat_municipios'. Luego, recupera todos los planes municipales
     * publicados asociados a ese municipio, ordenándolos por periodo de forma descendente.
     * Finalmente, renderiza la vista 'reporte_planes' pasando los planes y el objeto municipio enriquecido.
     *
     * @param  int  $opcion El ID del municipio cuya información y planes se desean obtener.
     * @return \Illuminate\View\View Retorna la vista 'reporte_planes' con las variables 'planes_municipales'
     * y 'municipio' compactadas para su uso en la plantilla.
     */
    public function obtenerPlanes($opcion)
    {
        $municipio = Municipio::findOrFail($opcion);

        $catMunicipio = CatMunicipio::findOrFail($opcion);

        $municipio->macrorregion = $catMunicipio->id_macrorregion . '. ' . $catMunicipio->nombre_macrorregion;
        $municipio->microrregion = $catMunicipio->id_microrregion . '. ' . $catMunicipio->nombre_microrregion;

        $planes_municipales = PlanMunicipal::where('municipio_id', $opcion)
            ->where('publicado', 1)
            ->orderBy('periodo', 'desc')
            ->get();
        return View::make('reporte_planes', compact('planes_municipales', 'municipio'));
    }

    use UpdatesPublicado;
    /**
     * Define el modelo principal que este controlador gestiona
     * para ser utilizado por el trait UpdatesPublicado.
     *
     * @return string La clase del modelo PlanMunicipal.
     */
    protected function getModel()
    {
        return PlanMunicipal::class;
    }
}
