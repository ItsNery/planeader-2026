<?php
namespace App\Http\Controllers;

use App\Models\ProgramaDerivado;
use App\Models\PlanEstatal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\UpdatesPublicado;
use App\Models\Banner;
use Yajra\DataTables\Facades\DataTables;

class ProgramaDerivadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-programa-derivado|crear-programa-derivado|editar-programa-derivado|borrar-programa-derivado', ['only' => ['index']]);
        $this->middleware('permission:crear-programa-derivado', ['only' => ['create', 'store', 'createMassive', 'storeMassive']]);
        $this->middleware('permission:editar-programa-derivado', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-programa-derivado', ['only' => ['destroy']]);
    }

    /**
     * Muestra un listado paginado de los documentos de los programas derivados, paginado cada 1000 registros.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ProgramaDerivado::with('planestatal')->select('programa_derivados.*');

            return DataTables::of($data)
                ->addColumn('info', function ($row) {
                    $html = '<div class="d-flex align-items-center">';
                    $html .= '<img src="' . asset('portadaprogder/' . $row->portada) . '" class="img-thumbnail mx-2 imagen-lista">';
                    $html .= '<div>';
                    $html .= '<div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">' . e($row->nombre) . '</div>';
                    $html .= '<div class="d-flex flex-wrap gap-2 align-items-center">';
                    $html .= '<span class="badge bg-light text-dark border">' . e($row->tipo_derivado) . '</span>';
                    $html .= '<span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-integration"><i class="fa-solid fa-file-lines me-1"></i>' . e($row->planestatal->nombre) . '</span>';
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</div>';
                    return $html;
                })
                ->addColumn('documento', function ($row) {
                    return '<div class="text-center"><a href="' . asset('progderi/' . $row->ruta_documento) . '" target="_blank" title="Ver documento ' . e($row->nombre) . '"><i class="fa-solid fa-file-pdf fs-2"></i></a></div>';
                })
                ->addColumn('estado', function ($row) {
                    if (auth()->user()->can('editar-programa-derivado')) {
                        $selectedPublicado = $row->publicado ? 'selected' : '';
                        $selectedBorrador = !$row->publicado ? 'selected' : '';
                        return '
                            <form action="' . route('update-publicado-programa-derivado', $row->id) . '" method="POST" class="d-inline">
                                ' . csrf_field() . '
                                ' . method_field('PATCH') . '
                                <select name="publicado" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="1" ' . $selectedPublicado . '>Publicado</option>
                                    <option value="0" ' . $selectedBorrador . '>Borrador</option>
                                </select>
                            </form>';
                    } else {
                        $class = $row->publicado ? 'bg-success' : 'bg-warning';
                        $text = $row->publicado ? 'Publicado' : 'Borrador';
                        return '<span class="badge ' . $class . '">' . $text . '</span>';
                    }
                })
                ->addColumn('acciones', function ($row) {
                    $btn = '<div class="text-center"><div class="btn-group btn-group-sm" role="group">';
                    if (auth()->user()->can('editar-programa-derivado')) {
                        $btn .= '<a href="' . route('panel-programas-derivados.edit', $row->id) . '" class="text-decoration-none"><button class="btn btn-outline-secondary" title="Editar elemento"><i class="fa-regular fa-pen-to-square"></i></button></a>';
                    }
                    if (auth()->user()->can('borrar-programa-derivado')) {
                        $btn .= '
                            <form action="' . route('panel-programas-derivados.destroy', $row->id) . '" method="POST" class="formEliminar ms-1">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-outline-danger"><i class="fa-regular fa-trash-can"></i></button>
                            </form>';
                    }
                    $btn .= '</div></div>';
                    return $btn;
                })
                ->rawColumns(['info', 'documento', 'estado', 'acciones'])
                ->make(true);
        }

        $planes_estatales = PlanEstatal::all();
        return view('panel-programas-derivados.index', compact('planes_estatales'));
    }

    /**
     * Muestra el formulario para subir un nuevo documento de programa derivado.
     *
     * Pre-carga los datos necesarios para los selectores del formulario.
     * (tiposProgDer, planes_estatales)
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $programa = new ProgramaDerivado();
        $tiposProgDer = ['Sectoriales', 'Especiales', 'Institucionales', 'Regionales'];
        $planes_estatales = PlanEstatal::all();
        return view('panel-programas-derivados.form', compact('planes_estatales', 'tiposProgDer', 'programa'));
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
            'tipo_derivado' => 'required|string',
            'portada' => 'required|image|mimes:jpeg,png,svg,jpg|max:6144',
            'planestatal_id' => 'required|exists:plan_estatals,id',
            'publicado' => 'nullable|boolean'
        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'nombre.string' => 'El nombre del documento no puede llevar carácteres especiales',
            'nombre.max' => 'El nombre del documento no puede tener más de :max caracteres',

            'ruta_documento.mimes' => 'El archivo debe ser PDF (Formato de documento portátil)',
            'ruta_documento.required' => 'No has seleccionado un archivo',
            'ruta_documento.max' => 'El archivo no debe pesar más de 50MB',
            'ruta_documento.file' => 'El archivo debe ser un documento válido',

            'tipo_derivado.required' => 'Hace falta elegir el tipo de programa',
            'tipo_derivado.string' => 'El tipo de programa elegido no es válido',

            'portada.required' => 'Se requiere la portada del plan',
            'portada.image' => 'El archivo no es una imagen',
            'portada.mimes' => 'El archivo no es una imagen',
            'portada.max' => 'La imagen no debe pesar mas de 6MB',

            'planestatal_id.required' => 'Falta seleccionar un plan estatal',
            'planestatal_id.exists' => 'El plan estatal seleccionado no es válido',

            'publicado.boolean' => 'El estado puede ser sólo: Publicado o No Publicado'
        ]);

        $programasDerivados = $request->all();
        $programasDerivados['tipo_derivado'] = $request->tipo_derivado;

        if ($ruta_progDer = $request->file('ruta_documento')) {
            $rutaGuardarDoc = 'progderi/';
            $nombre_documento = $request->input('nombre');
            $nombre_documento = Str::slug($nombre_documento). '.' . $ruta_progDer->getClientOriginalExtension();
            $ruta_progDer->move(public_path($rutaGuardarDoc), $nombre_documento);
            $programasDerivados['ruta_documento'] = $nombre_documento;
        }

        if ($portada = $request->file('portada')) {
            $rutaGuardarImg = 'portadaprogder/';
            $nombre_portada = $request->input('nombre');
            $nombre_portada = Str::slug($nombre_portada). '.' . $portada->getClientOriginalExtension();
            $portada->move(public_path($rutaGuardarImg), $nombre_portada);
            $programasDerivados['portada'] = $nombre_portada;
        }

        ProgramaDerivado::create($programasDerivados);
        return redirect()->route('panel-programas-derivados.index')->with('success', 'Programa subido exitosamente.');
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
     * (tiposProgDer, programasDerivados, planes_estatales).
     *
     * @param  int  $id El ID del documento de programa derivado a editar.
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $programa = ProgramaDerivado::findOrFail($id);
        $tiposProgDer = ['Sectoriales', 'Especiales', 'Institucionales', 'Regionales'];
        $planes_estatales = PlanEstatal::all();
        return view('panel-programas-derivados.form', compact('programa', 'planes_estatales', 'tiposProgDer'));
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
            'nombre' => 'required|string|max:200',
            'tipo_derivado' => 'required|string',
            'ruta_documento' => 'nullable|file|mimes:pdf|max:52400',
            'portada' => 'nullable|image|mimes:jpeg,png,svg,jpg|max:6144',
            'planestatal_id' => 'required|integer|exists:plan_estatals,id',
            'publicado' => 'nullable|boolean'
        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'nombre.max' => 'El nombre del documento no puede tener más de :max caracteres',
            'nombre.string' => 'El nombre del documento no puede llevar carácteres especiales',

            'tipo_derivado.required' => 'No has elegido el tipo de programa',
            'tipo_derivado.string' => 'El tipo de programa elegido no es válido',

            'ruta_documento.mimes' => 'El archivo debe ser PDF (Formato de documento portátil)',
            'ruta_documento.max' => 'El archivo no debe pesar más de 50MB',
            'ruta_documento.file' => 'El archivo debe ser un documento válido',

            'portada.image' => 'El archivo no es una imagen',
            'portada.mimes' => 'El archivo no es una imagen',
            'portada.max' => 'La imagen no debe pesar más de 6MB',

            'planestatal_id.required' => 'Falta elegir el plan estatal',
            'planestatal_id.exists' => 'El plan estatal seleccionado no es válido',

            'publicado.boolean' => 'El estado puede ser sólo: Publicado o No Publicado'
        ]);

        $programasDerivados = ProgramaDerivado::findOrFail($id);

        $programasDerivados->nombre = $request->nombre;
        $programasDerivados->planestatal_id = $request->planestatal_id;
        $programasDerivados->tipo_derivado = $request->tipo_derivado;

        if ($request->hasFile('ruta_documento')) {
            if ($programasDerivados->ruta_documento) {
                unlink(public_path('progderi/') . $programasDerivados->ruta_documento);
            }

            $ruta_documento = $request->file('ruta_documento');
            $nombre_documento = $request->input('nombre');
            $nombre_documento = Str::slug($nombre_documento) . '.' . $ruta_documento->getClientOriginalExtension();
            $ruta_documento->move(public_path('progderi/'), $nombre_documento);
            $programasDerivados->ruta_documento = $nombre_documento;
        }

        if ($request->hasFile('portada')) {
            if ($programasDerivados->portada) {
                unlink(public_path('portadaprogder/') . $programasDerivados->portada);
            }

            $portada = $request->file('portada');
            $nombre_portada = $request->input('nombre');
            $nombre_portada = Str::slug($nombre_portada) . '.' . $portada->getClientOriginalExtension();
            $portada->move(public_path('portadaprogder/'), $nombre_portada);
            $programasDerivados->portada = $nombre_portada;
        }

        if ($request->has('publicado')) {
            $programasDerivados->publicado = $request->publicado;
        }

        $programasDerivados->save();

        return redirect()->route('panel-programas-derivados.index')->with('success', 'Programa actualizado exitosamente.');
    }

    /**
     * Elimina un documento de la base de datos y su archivo pdf e imagen asociado.
     *
     * @param  int  $id El ID del documento a eliminar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $programaDerivado = ProgramaDerivado::findOrFail($id);

        if (file_exists(public_path('portadaprogder/' . $programaDerivado->portada))) {
            unlink(public_path('portadaprogder/' . $programaDerivado->portada));
        }

        if (file_exists(public_path('progderi/' . $programaDerivado->ruta_documento))) {
            unlink(public_path('progderi/' . $programaDerivado->ruta_documento));
        }

        $programaDerivado->delete();

        return redirect()->route('panel-programas-derivados.index')->with('success', 'Programa eliminado correctamente.');
    }

    /**
     * Muestra la vista de programas derivados, categorizando y organizando los programas.
     *
     * Este método recupera dos conjuntos principales de programas derivados:
     * 1. Programas "históricos": Aquellos que están publicados y NO pertenecen al
     * "Plan Estatal de Desarrollo 2024-2030".
     * 2. Programas "actuales": Aquellos que están publicados y SÍ pertenecen al
     * "Plan Estatal de Desarrollo 2024-2030". Estos programas se agrupan
     * adicionalmente por su `tipo_derivado` y se ordenan de forma personalizada
     * (Sectoriales, Especiales, Regionales, Institucionales, otros).
     *
     * Finalmente, calcula la fecha de la última actualización para ambos conjuntos de programas
     * y retorna la vista 'programaderivados' con todos los datos preparados.
     *
     * @return \Illuminate\View\View Retorna la vista 'programaderivados' con los siguientes datos:
     * - 'programasDerivados': Programas actuales (agrupados y ordenados).
     * - 'programasDerivadosHistorico': Programas históricos.
     * - 'programasDerivadosActuales': Una referencia a 'programasDerivados' (para compatibilidad o claridad en la vista).
     * - 'ultimaActualizacionProgramas': Fecha de la última actualización de los programas actuales.
     * - 'ultimaActualizacionProgramasHistorico': Fecha de la última actualización de los programas históricos.
     */
    public function mostrarProgramasDerivados()
    {
        $programasDerivadosHistorico = ProgramaDerivado::with('planestatal')
            ->whereDoesntHave('planestatal', function ($query) {
                $query->where('nombre', 'Plan Estatal de Desarrollo 2024-2030');
            })
            ->where('publicado', 1)
            ->get();

        $programasDerivados = ProgramaDerivado::oldest()
            ->whereHas('planestatal', function ($query) {
                $query->where('nombre', 'Plan Estatal de Desarrollo 2024-2030');
            })
            ->where('publicado', 1)
            ->get()
            ->groupBy('tipo_derivado');

        $programasDerivados = $programasDerivados->sortBy(function ($programas, $tipo) {
            switch ($tipo) {
                case 'Sectoriales':
                    return 1;
                case 'Especiales':
                    return 2;
                case 'Regionales':
                    return 3;
                case 'Institucionales':
                    return 4;
                default:
                    return 5;
            }
        });

        $ultimaActualizacionProgramas = $programasDerivados->isEmpty() ? null : $programasDerivados->flatten()->max('updated_at');
        $ultimaActualizacionProgramasHistorico = $programasDerivadosHistorico->isEmpty() ? null : $programasDerivadosHistorico->flatten()->max('updated_at');
        $programasDerivadosActuales = $programasDerivados;
        return view('programaderivados', compact('programasDerivados', 'programasDerivadosHistorico', 'programasDerivadosActuales', 'ultimaActualizacionProgramas', 'ultimaActualizacionProgramasHistorico'));
    }

    use UpdatesPublicado;
    /**
     * Define el modelo principal que este controlador gestiona
     * para ser utilizado por el trait UpdatesPublicado.
     *
     * @return string La clase del modelo ProgramaDerivado.
     */
    protected function getModel()
    {
        return ProgramaDerivado::class;
    }
    /**
     * Muestra el formulario para la subida masiva de programas derivados.
     *
     * @return \Illuminate\View\View
     */
    public function createMassive()
    {
        $tiposProgDer = ['Sectoriales', 'Especiales', 'Institucionales', 'Regionales'];
        $planes_estatales = PlanEstatal::all();
        // Apuntamos a una nueva vista que crearemos
        return view('panel-programas-derivados.crear-masivo', compact('planes_estatales', 'tiposProgDer'));
    }

    /**
     * Valida y almacena múltiples documentos de programas derivados
     * (Versión con Nombre manual + PDF + Portada).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeMassive(Request $request)
    {
        // dd($request->all());
        // Validación
        $this->validate($request, [
            'programas' => 'required|array|min:1',

            // ✨ CAMBIO: Validar el nuevo campo 'nombre'
            'programas.*.nombre' => 'required|string|max:200',

            'programas.*.pdf' => 'required|file|mimes:pdf|max:52400',
            'programas.*.portada' => 'required|image|mimes:jpeg,png,svg,jpg,webp|max:6144',

            // Campos comunes
            'tipo_derivado' => 'required|string',
            'planestatal_id' => 'required|exists:plan_estatals,id',
            'publicado' => 'nullable|boolean'
        ], [
            'programas.required' => 'Debes añadir al menos un par de programa (Nombre + PDF + Portada).',

            // ✨ CAMBIO: Mensajes para 'nombre'
            'programas.*.nombre.required' => 'Falta escribir el nombre en uno de los programas.',
            'programas.*.nombre.max' => 'El nombre no puede tener más de 200 caracteres.',

            'programas.*.pdf.required' => 'Falta un archivo PDF en uno de los programas.',
            'programas.*.portada.required' => 'Falta una imagen de portada en uno de los programas.',
            'planestatal_id.required' => 'Falta seleccionar un plan estatal',
            'tipo_derivado.required' => 'Hace falta elegir el tipo de programa',
        ]);

        $rutaGuardarDoc = 'progderi/';
        $rutaGuardarImg = 'portadaprogder/';
        $count = 0;

        // 1. Iterar sobre el array 'programas'
        foreach ($request->programas as $programaData) {

            // ✨ CAMBIO: Obtener las 3 partes
            $nombreManual = $programaData['nombre'];
            $pdfFile = $programaData['pdf'];
            $portadaFile = $programaData['portada'];

            // 2. Crear el slug a partir del nombre manual
            $slugBase = Str::slug($nombreManual);

            // 3. Subir el PDF (usando el slug)
            $nombre_documento = $slugBase . '-' . Str::random(4) . '.' . $pdfFile->getClientOriginalExtension();
            $pdfFile->move(public_path($rutaGuardarDoc), $nombre_documento);

            // 4. Subir la Portada (usando el slug)
            $nombre_portada = $slugBase . '-' . Str::random(4) . '.' . $portadaFile->getClientOriginalExtension();
            $portadaFile->move(public_path($rutaGuardarImg), $nombre_portada);

            // 5. Crear el registro en la BD
            ProgramaDerivado::create([
                // ✨ CAMBIO: Usar el nombre manual
                'nombre' => $nombreManual,
                'ruta_documento' => $nombre_documento,
                'portada' => $nombre_portada,
                'tipo_derivado' => $request->tipo_derivado,       // Dato común
                'planestatal_id' => $request->planestatal_id,    // Dato común
                'publicado' => $request->publicado ?? 0,         // Dato común
            ]);

            $count++;
        }

        return redirect()->route('panel-programas-derivados.index')
            ->with('success', '¡' . $count . ' programas subidos exitosamente!');
    }
}
