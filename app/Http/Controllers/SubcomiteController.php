<?php
// local
namespace App\Http\Controllers;

use App\Models\Subcomite;
use Illuminate\Http\Request;
use App\Models\PlanEstatal;
use App\Models\DocumentoSubcomite;
use Illuminate\Support\Str;
use App\Traits\UpdatesPublicado;

class SubcomiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-subcomite|crear-subcomite|editar-subcomite|borrar-subcomite', ['only' => ['index']]);
        $this->middleware('permission:crear-subcomite', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-subcomite', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-subcomite', ['only' => ['destroy']]);
    }

    /**
     * Muestra un listado paginado de los subcomités, paginado cada 1000 registros.
     * Envia tambien los planes estatales para su uso en la vista.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $planes_estatales = PlanEstatal::all();
        $subcomites = Subcomite::paginate(1000);
        return view('panel-subcomites.index', compact('subcomites', 'planes_estatales'));
    }

    /**
     * Muestra el formulario para subir un subcomité.
     *
     * Pre-carga los datos necesarios para los selectores del formulario.
     * (tipos_subcomites,planes_estatales )
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $subcomite = new Subcomite();
        $planes_estatales = PlanEstatal::all();
        $tipos_subcomites = [
            'Sectoriales',
            'Especiales',
            'Regional',
        ];
        return view('panel-subcomites.form', compact('tipos_subcomites', 'planes_estatales', 'subcomite'));
    }

    /**
     * Valida y almacena un nuevo subcomité en la base de datos.
     *
     * Gestiona la subida y el almacenamiento del archivo de imgen (icono y conformación) asociado.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con los datos del nuevo subcomité.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'nombre' => 'required|string|max:150',
            'tipo_subcomite' => 'required|string',
            'conformacion' => 'required|image|mimes:jpeg,png,svg,jpg|max:6144',
            'icono' => 'required|image|mimes:jpeg,png,svg,jpg|max:6144',
            'objetivo' => 'required',
            'planestatal_id' => 'required|exists:plan_estatals,id',
            'publicado' => 'nullable|boolean'
        ], [
            'nombre.required' => 'El nombre del subcomite es requerido',
            'nombre.string' => 'El nombre del subcomite no es válido',
            'nombre.max' => 'El nombre del subcomite no puede tener más de :max carácteres',

            'tipo_subcomite.required' => 'Se necesita especificar el tipo',
            'tipo_subcomite.string' => 'El tipo de subcomité no es válido',

            'conformacion.mimes' => 'El archivo debe ser una imagen',
            'conformacion.required' => 'No ha cargado una imagen',
            'conformacion.max' => 'El archivo no debe pesar mas de 6MB',
            'conformacion.image' => 'El archivo debe ser una imagen',

            'icono.mimes' => 'El archivo debe ser una imagen',
            'icono.required' => 'No ha cargado una imagen',
            'icono.max' => 'El archivo no debe pesar mas de 6MB',
            'icono.image' => 'El archivo debe ser una imagen',

            'objetivo.required' => 'Se requiere el objetivo del subcomité',

            'planestatal_id.required' => 'Se necesita elegir un plan Estatal',
            'planestatal_id.exists' => 'El plan estatal seleccionado no es válido',

            'publicado.boolean' => 'El estado solo puede ser publicado o no publicado'
        ]);

        $subcomite = $request->all();
        $slug = $this->generateSlug($request->nombre);
        $subcomite = $request->all();
        $subcomite['slug'] = $slug;

        if ($conformacion = $request->file('conformacion')) {
            $rutaGuardarImg = 'subcomitesconformacion/';
            $nombre_conformacion = Str::slug($request->input('nombre')) . '-' . Str::random(4) . "." . $conformacion->getClientOriginalExtension();
            $conformacion->move(public_path($rutaGuardarImg), $nombre_conformacion);
            $subcomite['conformacion'] = $nombre_conformacion;
        }

        if ($icono = $request->file('icono')) {
            $rutaGuardarIco = 'icono_subcomites/';
            $nombre_icono = Str::slug($request->input('nombre')) . '-' . Str::random(4) . "." . $icono->getClientOriginalExtension();
            $icono->move(public_path($rutaGuardarIco), $nombre_icono);
            $subcomite['icono'] = $nombre_icono;
        }

        Subcomite::create($subcomite);
        return redirect()->route('panel-subcomites.index')->with('success', 'Subcomité creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *  Actualmente no se utiliza, pero se deja como parte de la estructura del controlador.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Muestra el formulario para editar un subcomitéexistente.
     *
     * Carga los datos del documento a editar y la información necesaria
     * (tipos_subcomites, subcomites, planes_estatales).
     *
     * @param  int  $id El ID del documento de programa estatal a editar.
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $subcomite = Subcomite::findOrFail($id);
        $planes_estatales = PlanEstatal::all();
        $tipos_subcomites = [
            'Sectoriales',
            'Especiales',
            'Regional',
        ];
        return view('panel-subcomites.form', compact('subcomite', 'tipos_subcomites', 'planes_estatales'));
    }

    /**
     * Valida y actualiza un subcomité en la base de datos.
     *
     * Gestiona la actualización de la imagen (icono y conformación), eliminando los anteriores si se sube uno nuevo.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud con los datos actualizados.
     * @param  int  $id El ID del documento a actualizar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'nombre' => 'required|string|max:150',
            'tipo_subcomite' => 'required|string',
            'conformacion' => 'nullable|image|mimes:jpeg,png,svg,jpg|max:6144',
            'icono' => 'nullable|image|mimes:jpeg,png,svg,jpg|max:6144',
            'objetivo' => 'required',
            'planestatal_id' => 'required|exists:plan_estatals,id',
            'publicado' => 'nullable|boolean'
        ], [
            'nombre.required' => 'El nombre del subcomite es requerido',
            'nombre.string' => 'El nombre del subcomite no es válido',
            'nombre.max' => 'El nombre del subcomite no puede tener más de 150 carácteres',

            'tipo_subcomite.required' => 'Se necesita especificar el tipo',

            'icono.mimes' => 'El archivo debe ser una imagen',
            'icono.max' => 'El archivo no debe pesar mas de 6MB',
            'icono.image' => 'El archivo debe ser una imagen',

            'conformacion.mimes' => 'El archivo debe ser una imagen',
            'conformacion.max' => 'El archivo no debe pesar mas de 6MB',
            'conformacion.image' => 'El archivo debe ser una imagen',

            'objetivo.required' => 'Se requiere una descripcion del objetivo',

            'planestatal_id.required' => 'Se require un Plan Estatal',
            'planestatal_id.exists' => 'El plan estatal seleccionado no es válido',

            'publicado.boolean' => 'El estado solo puede ser publicado o no publicado'
        ]);

        $subcomites = Subcomite::findOrFail($id);

        $subcomites->nombre = $request->nombre;
        $subcomites->tipo_subcomite = $request->tipo_subcomite;
        $subcomites->objetivo = $request->objetivo;
        $subcomites->planestatal_id = $request->planestatal_id;

        if ($request->hasFile('conformacion')) {
            if ($subcomites->conformacion) {
                unlink(public_path('subcomitesconformacion/') . $subcomites->conformacion);
            }

            $conformacion = $request->file('conformacion');
            $nombre_conformacion = Str::slug($request->input('nombre')) . '-' . Str::random(4) . '.' . $conformacion->getClientOriginalExtension();
            $conformacion->move(public_path('subcomitesconformacion/'), $nombre_conformacion);
            $subcomites->conformacion = $nombre_conformacion;
        }

        if ($request->hasFile('icono')) {
            if ($subcomites->icono) {
                unlink(public_path('icono_subcomites/') . $subcomites->icono);
            }

            $icono = $request->file('icono');
            $nombre_icono = Str::slug($request->input('nombre')) . '-' . Str::random(4) . '.' . $icono->getClientOriginalExtension();
            $icono->move(public_path('icono_subcomites/'), $nombre_icono);
            $subcomites->icono = $nombre_icono;
        }

        if ($request->has('publicado')) {
            $subcomites->publicado = $request->publicado;
        }

        $subcomites->save();

        return redirect()->route('panel-subcomites.index')->with('success', 'Subcomité actualizado exitosamente.');
    }

    /**
     * Elimina un subcomité de la base de datos y su archivo imagen (icono y conformación) asociado.
     *
     * @param  int  $id El ID del documento a eliminar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $subcomites = Subcomite::findOrFail($id);

        $rutaArchivo = public_path('subcomitesconformacion/') . $subcomites->conformacion;

        if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
        }
        $rutaArchivo2 = public_path('icono_subcomites/') . $subcomites->icono;

        if (file_exists($rutaArchivo2)) {
            unlink($rutaArchivo2);
        }

        $subcomites->delete();

        return redirect()->route('panel-subcomites.index')->with('success', 'Subcomité eliminado correctamente.');
    }

    /**
     * Muestra la vista pública de subcomités, categorizándolos por su plan estatal asociado.
     *
     * Este método recupera todos los subcomités publicados, los organiza según si
     * pertenecen al "Plan Estatal de Desarrollo 2024-2030" (considerado el plan actual)
     * o a otros planes históricos. Los subcomités se cargan con su relación `planEstatal`.
     * La vista `subcomites` se renderiza con listas separadas de subcomités actuales e históricos
     * agrupados por el ID de su plan, junto con una lista predefinida de tipos de subcomités.
     *
     * @return \Illuminate\View\View Retorna la vista 'subcomites' con las siguientes variables:
     * - 'tipos_subcomites': Un array con los tipos predefinidos de subcomités (Sectoriales, Especiales, Regional).
     * - 'subcomites_actual': Una colección de subcomités asociados al plan actual.
     * - 'subcomites_historicos_agrupados': Una colección de subcomités históricos, agrupados por el ID de su plan estatal.
     */
    public function mostrarSubcomites()
    {
        define('NOMBRE_PLAN_ACTUAL', 'Plan Estatal de Desarrollo 2024-2030');

        $tipos_subcomites = ['Sectoriales', 'Especiales', 'Regional'];

        // 1. ÚNICA CONSULTA a la BD
        $todos_los_subcomites = Subcomite::with('planEstatal')
            ->where('publicado', true)
            ->orderBy('nombre')
            ->get();
        $plan_actual = $todos_los_subcomites->first(function ($subcomite) {
            return $subcomite->planEstatal && $subcomite->planEstatal->nombre === NOMBRE_PLAN_ACTUAL;
        });
        $plan_actual_id = $plan_actual ? $plan_actual->planestatal_id : null;
        $subcomites_actual = $plan_actual_id !== null ? $todos_los_subcomites->where('planestatal_id', $plan_actual_id) : collect();
        $subcomites_agrupados = $todos_los_subcomites->groupBy('planestatal_id');
        $subcomites_historicos_agrupados = $subcomites_agrupados->filter(function ($group, $key) use ($plan_actual_id) {
            return $key != $plan_actual_id && $key != null;
        });
        return view('subcomites', compact(
            'tipos_subcomites',
            'subcomites_actual',
            'subcomites_historicos_agrupados'
        ));
    }

    /**
     * Muestra la información detallada de un subcomité específico y sus documentos públicos.
     *
     * Este método busca un subcomité por su 'slug'. Si lo encuentra, recupera todos los
     * documentos asociados a ese subcomité. Los documentos se filtran para mostrar solo
     * aquellos que están publicados y se agrupan por 'año' y 'tipo_documento',
     * ordenándose los grupos de años de forma descendente. También se calcula la fecha
     * de la última actualización de los documentos publicados del subcomité.
     * La vista `panel-subcomites.showPublic` se renderiza con los datos del subcomité,
     * sus documentos originales, los documentos agrupados y la fecha de última actualización.
     *
     * @param  string  $slug El slug único del subcomité a mostrar.
     * @return \Illuminate\View\View Retorna la vista 'panel-subcomites.showPublic' con los datos del subcomité,
     * sus documentos, los documentos agrupados y la fecha de última actualización.
     */
    public function showPublic($slug)
    {
        $subcomite = Subcomite::where('slug', $slug)->firstOrFail();
        $id = $subcomite->id; // Obtener el id del subcomité

        // Obtener los documentos asociados
        $documentos = DocumentoSubcomite::where('subcomite_id', $id)->get();

        $documentosAgrupados = $documentos->where('publicado', 1) // Filtrar solo los documentos que estén publicados
            ->groupBy(['anio', 'tipo_documento']);

        // Ordenar los documentos agrupados por año de forma descendente
        $documentosAgrupados = $documentosAgrupados->sortByDesc(function ($group, $anio) {
            return $anio;
        });

        $ultimaActualizacionDocSubcomite = $documentosAgrupados->isEmpty() ? null : $documentosAgrupados->flatten()->max('updated_at');

        return view('panel-subcomites.showPublic', compact('subcomite', 'documentos', 'documentosAgrupados', 'ultimaActualizacionDocSubcomite'));
    }

    /**
     * Evalúa si un acta (documento) tiene la palabra "segunda" en su título (sin importar mayúsculas/minúsculas).
     *
     * Este método privado se utiliza para verificar una condición específica dentro de la lógica de negocio.
     * Si el título del acta contiene la palabra "segunda", el acta se devuelve tal cual.
     * Si no contiene la palabra, también devuelve el acta original, lo que indica que
     * no realiza ninguna priorización o modificación de la acta.
     *
     * @param  object|null  $acta El objeto del acta (documento) a evaluar, o null.
     * @return object|null Retorna el mismo objeto $acta recibido, sin modificaciones basadas en la prioridad.
     * Devuelve null si el acta de entrada es null.
     */
    private function priorizarSegunda($acta)
    {
        if ($acta && strpos(strtolower($acta->titulo), 'segunda') !== false) {
            return $acta;
        }

        return $acta;
    }
    /**
     * Genera un slug único para el nombre de un subcomité.
     *
     * Este método toma un nombre y lo convierte en un slug amigable para URLs.
     * Si el slug generado ya existe en la base de datos para otro subcomité,
     * añade un sufijo numérico (ej. '-1', '-2') para asegurar su unicidad.
     *
     * @param  string  $nombre El nombre base a partir del cual se generará el slug.
     * @return string El slug único generado.
     */
    private function generateSlug($nombre)
    {
        $slug = Str::slug($nombre);
        $suffix = 1;

        while (Subcomite::where('slug', $slug)->exists()) {
            $slug = Str::slug($nombre) . '-' . $suffix++;
        }

        return $slug;
    }

    use UpdatesPublicado;
    /**
     * Define el modelo principal que este controlador gestiona
     * para ser utilizado por el trait UpdatesPublicado.
     *
     * @return string La clase del modelo Subcomite.
     */
    protected function getModel()
    {
        return Subcomite::class;
    }
}
