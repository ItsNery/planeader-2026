<?php
namespace App\Http\Controllers;

use App\Models\Subcomite;
use Illuminate\Http\Request;
use App\Models\PlanEstatal;
use App\Models\DocumentoSubcomite;
use Illuminate\Support\Str;
use App\Traits\UpdatesPublicado;

use App\Models\Evento;
use App\Models\AgendaEvento;
use App\Models\AgendaCapacidad;
use Carbon\Carbon;

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
        $subcomites = Subcomite::with('planestatal')->paginate(50);
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
            'Sectorial',
            'Especial',
            'Regional',
            'Institucional'
        ];

        // Optimización: Recuperar y agrupar subcomités en una sola consulta
        $subcomitesPorPlan = Subcomite::whereNotNull('orden')
            ->get(['planestatal_id', 'orden'])
            ->groupBy('planestatal_id');

        $ordenes_disponibles_por_plan = [];
        $ordenes_utilizados_por_plan = [];
        foreach($planes_estatales as $plan) {
            $utilizados = ($subcomitesPorPlan->get($plan->id) ?? collect())->pluck('orden')->toArray();
            $maxOrden = empty($utilizados) ? 0 : max($utilizados);

            $disponibles = [];
            for ($i = 1; $i <= $maxOrden + 2; $i++) {
                if (!in_array($i, $utilizados)) {
                    $disponibles[] = $i;
                }
            }
            $ordenes_disponibles_por_plan[$plan->id] = $disponibles;
            $ordenes_utilizados_por_plan[$plan->id] = array_values($utilizados);
        }

        return view('panel-subcomites.form', compact('tipos_subcomites', 'planes_estatales', 'subcomite', 'ordenes_disponibles_por_plan', 'ordenes_utilizados_por_plan'));
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
            'orden' => 'required|integer',
            'tipo_subcomite' => 'required|string',
            'conformacion' => 'nullable|image|mimes:jpeg,png,svg,jpg|max:6144',
            'icono' => 'nullable|image|mimes:jpeg,png,svg,jpg|max:6144',
            'objetivo' => 'required',
            'planestatal_id' => 'required|exists:plan_estatals,id',
            'publicado' => 'nullable|boolean'
        ], [
            'nombre.required' => 'El nombre del subcomite es requerido',
            'nombre.string' => 'El nombre del subcomite no es válido',
            'nombre.max' => 'El nombre del subcomite no puede tener más de :max carácteres',

            'orden.required' => 'El orden es requerido',
            'orden.integer' => 'El orden debe ser un número',

            'tipo_subcomite.required' => 'Se necesita especificar el tipo',
            'tipo_subcomite.string' => 'El tipo de subcomité no es válido',

            'conformacion.mimes' => 'El archivo debe ser una imagen',
            'conformacion.nullable' => 'No ha cargado una imagen',
            'conformacion.max' => 'El archivo no debe pesar mas de 6MB',
            'conformacion.image' => 'El archivo debe ser una imagen',

            'icono.mimes' => 'El archivo debe ser una imagen',
            'icono.nullable' => 'No ha cargado una imagen',
            'icono.max' => 'El archivo no debe pesar mas de 6MB',
            'icono.image' => 'El archivo debe ser una imagen',

            'objetivo.required' => 'Se requiere el objetivo del subcomité',

            'planestatal_id.required' => 'Se necesita elegir un plan Estatal',
            'planestatal_id.exists' => 'El plan estatal seleccionado no es válido',

            'publicado.boolean' => 'El estado solo puede ser publicado o no publicado'
        ]);

        $subcomite = $request->all();
        $subcomite['slug'] = $this->generateSlug($request->nombre);

        if ($conformacion = $request->file('conformacion')) {
            $subcomite['conformacion'] = $this->subirImagen($conformacion, $request->nombre, 'subcomitesconformacion/');
        }

        if ($icono = $request->file('icono')) {
            $subcomite['icono'] = $this->subirImagen($icono, $request->nombre, 'icono_subcomites/');
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

        // Optimización: Recuperar y agrupar subcomités en una sola consulta
        $subcomitesPorPlan = Subcomite::whereNotNull('orden')
            ->get(['planestatal_id', 'orden'])
            ->groupBy('planestatal_id');

        $ordenes_disponibles_por_plan = [];
        $ordenes_utilizados_por_plan = [];
        foreach($planes_estatales as $plan) {
            $utilizados = ($subcomitesPorPlan->get($plan->id) ?? collect())->pluck('orden')->toArray();
            
            // Si estamos editando, queremos asegurar que el orden actual del subcomité 
            // esté disponible para seleccionarlo de nuevo.
            if ($subcomite->planestatal_id == $plan->id) {
                $utilizados = array_diff($utilizados, [$subcomite->orden]);
            }

            $maxOrden = empty($utilizados) ? 0 : max($utilizados);

            $disponibles = [];
            for ($i = 1; $i <= $maxOrden + 2; $i++) {
                if (!in_array($i, $utilizados)) {
                    $disponibles[] = $i;
                }
            }
            
            // Si el orden actual es mayor al maxOrden+1 (caso raro), agregarlo a la lista de disponibles
            if ($subcomite->planestatal_id == $plan->id && !in_array($subcomite->orden, $disponibles)) {
                $disponibles[] = $subcomite->orden;
                sort($disponibles);
            }

            $ordenes_disponibles_por_plan[$plan->id] = $disponibles;
            $ordenes_utilizados_por_plan[$plan->id] = array_values($utilizados);
        }

        return view('panel-subcomites.form', compact('subcomite', 'tipos_subcomites', 'planes_estatales', 'ordenes_disponibles_por_plan', 'ordenes_utilizados_por_plan'));
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
            'orden' => 'required|integer',
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

            'orden.required' => 'El orden es requerido',
            'orden.integer' => 'El orden debe ser un número',

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
        $subcomites->orden = $request->orden;
        $subcomites->tipo_subcomite = $request->tipo_subcomite;
        $subcomites->objetivo = $request->objetivo;
        $subcomites->planestatal_id = $request->planestatal_id;

        if ($request->hasFile('conformacion')) {
            $this->eliminarImagen('subcomitesconformacion/', $subcomites->conformacion);
            $subcomites->conformacion = $this->subirImagen($request->file('conformacion'), $request->nombre, 'subcomitesconformacion/');
        }

        if ($request->hasFile('icono')) {
            $this->eliminarImagen('icono_subcomites/', $subcomites->icono);
            $subcomites->icono = $this->subirImagen($request->file('icono'), $request->nombre, 'icono_subcomites/');
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

        $this->eliminarImagen('subcomitesconformacion/', $subcomites->conformacion);
        $this->eliminarImagen('icono_subcomites/', $subcomites->icono);

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
            ->orderBy('orden', 'asc')
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

        // Optimización: Cargar solo documentos publicados y ordenarlos directamente
        $documentosAgrupados = DocumentoSubcomite::where('subcomite_id', $id)
            ->where('publicado', 1)
            ->get()
            ->groupBy(['anio', 'tipo_documento'])
            ->sortByDesc(function ($group, $anio) {
                return $anio;
            });

        $ultimaActualizacionDocSubcomite = $documentosAgrupados->isEmpty() ? null : $documentosAgrupados->flatten()->max('updated_at');

        // CALENDARIO DE EVENTOS
        Carbon::setLocale('es');
        $mesSolicitado = request('mes', Carbon::now()->format('Y-m'));
        $fechaBase = Carbon::createFromFormat('Y-m', $mesSolicitado)->startOfMonth();

        $eventosDelMes = Evento::whereYear('fecha_evento', $fechaBase->year)
            ->whereMonth('fecha_evento', $fechaBase->month)
            ->orderBy('fecha_evento', 'asc')
            ->get();

        $agendaEventosDelMes = \App\Models\AgendaEvento::with('subcomite')
            ->where('publicado', true)
            ->whereIn('estado', ['pendiente', 'confirmado'])
            ->whereYear('fecha_evento', $fechaBase->year)
            ->whereMonth('fecha_evento', $fechaBase->month)
            ->orderBy('fecha_evento')
            ->get();

        $diasEnMes = $fechaBase->daysInMonth;
        $diaDeLaSemanaInicio = $fechaBase->dayOfWeek; // 0 para Domingo, 6 para Sábado

        $fechasNoLaborables = collect(range(1, $diasEnMes))
            ->map(fn ($dia) => $fechaBase->copy()->day($dia)->format('Y-m-d'))
            ->filter(fn ($fecha) => AgendaEvento::fechaEsNoLaborable($fecha))
            ->values();

        $subcomitesAgenda = Subcomite::where('publicado', true)
            ->whereHas('planestatal', function ($query) {
                $query->where('nombre', 'Plan Estatal de Desarrollo 2024-2030');
            })
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get(['id', 'nombre']);


         $eventosPorDia = $eventosDelMes->groupBy(function ($evento) {
             return Carbon::parse($evento->fecha_evento)->day;
         });

        $agendaEventosPorDia = $agendaEventosDelMes->groupBy(function ($evento) {
            return Carbon::parse($evento->fecha_evento)->day;
        });

        $activosFuturos = AgendaEvento::activos()
            ->whereDate('fecha_evento', '>=', Carbon::today())
            ->get(['fecha_evento', 'hora_inicio']);

        $configuracionesAgenda = AgendaCapacidad::whereDate('fecha_evento', '>=', Carbon::today())
            ->orderBy('fecha_evento')
            ->get();
        $capacidadesAgendaPorFecha = $configuracionesAgenda
            ->mapWithKeys(fn (AgendaCapacidad $capacidad) => [
                $capacidad->fecha_evento->format('Y-m-d') => (int) $capacidad->max_eventos,
            ])
            ->all();
        $horariosDisponiblesPorFecha = $configuracionesAgenda
            ->mapWithKeys(fn (AgendaCapacidad $capacidad) => [
                $capacidad->fecha_evento->format('Y-m-d') => $capacidad->horarios,
            ])
            ->all();

        $horariosOcupadosPorFecha = $activosFuturos
            ->groupBy(fn ($e) => Carbon::parse($e->fecha_evento)->format('Y-m-d'))
            ->map(fn ($group) => $group->map(fn ($e) => substr((string) $e->hora_inicio, 0, 5))->unique()->values()->all())
            ->toArray();

        $fechasAgendaOcupadas = collect($horariosOcupadosPorFecha)
            ->filter(fn ($horarios, $fecha) => count($horarios) >= ($capacidadesAgendaPorFecha[$fecha] ?? AgendaEvento::CAPACIDAD_PREDETERMINADA))
            ->keys()
            ->values();

        $mesAnterior = $fechaBase->copy()->subMonth()->format('Y-m');
        $mesSiguiente = $fechaBase->copy()->addMonth()->format('Y-m');

        return view('panel-subcomites.showPublic', compact(
            'subcomite', 
            'documentosAgrupados', 
            'ultimaActualizacionDocSubcomite',
            'fechaBase',
            'diasEnMes',
            'diaDeLaSemanaInicio',
            'eventosPorDia',
            'agendaEventosPorDia',
            'fechasAgendaOcupadas',
            'horariosOcupadosPorFecha',
            'capacidadesAgendaPorFecha',
            'horariosDisponiblesPorFecha',
            'fechasNoLaborables',
            'subcomitesAgenda',
            'mesAnterior',
            'mesSiguiente'
        ));
    }

    public function mesasTecnicasProgramasEspeciales()
    {
        Carbon::setLocale('es');
        $mesSolicitado = request('mes', Carbon::now()->format('Y-m'));
        $fechaBase = Carbon::createFromFormat('Y-m', $mesSolicitado)->startOfMonth();

        $eventosDelMes = Evento::whereYear('fecha_evento', $fechaBase->year)
            ->whereMonth('fecha_evento', $fechaBase->month)
            ->orderBy('fecha_evento', 'asc')
            ->get();

        $agendaEventosDelMes = AgendaEvento::with('subcomite')
            ->where('publicado', true)
            ->whereIn('estado', ['pendiente', 'confirmado'])
            ->whereYear('fecha_evento', $fechaBase->year)
            ->whereMonth('fecha_evento', $fechaBase->month)
            ->orderBy('fecha_evento')
            ->get();

        $diasEnMes = $fechaBase->daysInMonth;
        $diaDeLaSemanaInicio = $fechaBase->dayOfWeek;
        $fechasNoLaborables = collect(range(1, $diasEnMes))
            ->map(fn ($dia) => $fechaBase->copy()->day($dia)->format('Y-m-d'))
            ->filter(fn ($fecha) => AgendaEvento::fechaEsNoLaborable($fecha))
            ->values();
        $subcomitesAgenda = Subcomite::where('publicado', true)
            ->whereHas('planestatal', function ($query) {
                $query->where('nombre', 'Plan Estatal de Desarrollo 2024-2030');
            })
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get(['id', 'nombre']);
        $eventosPorDia = $eventosDelMes->groupBy(fn ($evento) => Carbon::parse($evento->fecha_evento)->day);
        $agendaEventosPorDia = $agendaEventosDelMes->groupBy(fn ($evento) => Carbon::parse($evento->fecha_evento)->day);
        
        $activosFuturos = AgendaEvento::activos()
            ->whereDate('fecha_evento', '>=', Carbon::today())
            ->get(['fecha_evento', 'hora_inicio']);

        $configuracionesAgenda = AgendaCapacidad::whereDate('fecha_evento', '>=', Carbon::today())
            ->orderBy('fecha_evento')
            ->get();
        $capacidadesAgendaPorFecha = $configuracionesAgenda
            ->mapWithKeys(fn (AgendaCapacidad $capacidad) => [
                $capacidad->fecha_evento->format('Y-m-d') => (int) $capacidad->max_eventos,
            ])
            ->all();
        $horariosDisponiblesPorFecha = $configuracionesAgenda
            ->mapWithKeys(fn (AgendaCapacidad $capacidad) => [
                $capacidad->fecha_evento->format('Y-m-d') => $capacidad->horarios,
            ])
            ->all();

        $horariosOcupadosPorFecha = $activosFuturos
            ->groupBy(fn ($e) => Carbon::parse($e->fecha_evento)->format('Y-m-d'))
            ->map(fn ($group) => $group->map(fn ($e) => substr((string) $e->hora_inicio, 0, 5))->unique()->values()->all())
            ->toArray();

        $fechasAgendaOcupadas = collect($horariosOcupadosPorFecha)
            ->filter(fn ($horarios, $fecha) => count($horarios) >= ($capacidadesAgendaPorFecha[$fecha] ?? AgendaEvento::CAPACIDAD_PREDETERMINADA))
            ->keys()
            ->values();

        $mesAnterior = $fechaBase->copy()->subMonth()->format('Y-m');
        $mesSiguiente = $fechaBase->copy()->addMonth()->format('Y-m');
        $subcomite = null;
        $soloCalendario = true;

        return view('panel-subcomites.showPublic', compact(
            'subcomite',
            'soloCalendario',
            'fechaBase',
            'diasEnMes',
            'diaDeLaSemanaInicio',
            'eventosPorDia',
            'agendaEventosPorDia',
            'fechasAgendaOcupadas',
            'horariosOcupadosPorFecha',
            'capacidadesAgendaPorFecha',
            'horariosDisponiblesPorFecha',
            'fechasNoLaborables',
            'subcomitesAgenda',
            'mesAnterior',
            'mesSiguiente'
        ));
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

    /**
     * Sube una imagen al servidor y retorna su nombre generado.
     */
    private function subirImagen($file, $nombreBase, $rutaDestino)
    {
        $nombreFinal = Str::slug($nombreBase) . '-' . Str::random(4) . "." . $file->getClientOriginalExtension();
        $file->move(public_path($rutaDestino), $nombreFinal);
        return $nombreFinal;
    }

    /**
     * Elimina un archivo de forma segura usando Laravel File Facade.
     */
    private function eliminarImagen($rutaBase, $nombreArchivo)
    {
        if ($nombreArchivo) {
            $rutaCompleta = public_path($rutaBase) . $nombreArchivo;
            if (\Illuminate\Support\Facades\File::exists($rutaCompleta)) {
                \Illuminate\Support\Facades\File::delete($rutaCompleta);
            }
        }
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
