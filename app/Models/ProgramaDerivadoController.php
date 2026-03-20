<?php

namespace App\Http\Controllers;

use App\Models\ProgramaDerivado;
use App\Models\PlanEstatal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\UpdatesPublicado;
use App\Models\Banner;

class ProgramaDerivadoController extends Controller
{
    /**
     * Muestra un listado paginado de los documentos de los programas derivados, paginado cada 1000 registros.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $planes_estatales = PlanEstatal::all();
        $programasDerivados = ProgramaDerivado::paginate(1000);
        return view('panel-programasderivados.index', compact('programasDerivados', 'planes_estatales'));
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
        $tiposProgDer = ['Sectoriales', 'Especiales', 'Institucionales', 'Regionales'];
        $planes_estatales = PlanEstatal::all();
        return view('panel-programasderivados.crear', compact('planes_estatales', 'tiposProgDer'));
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
            $nombre_documento = Str::slug($nombre_documento) . date('YmdHis') . '.' . $ruta_progDer->getClientOriginalExtension();
            $ruta_progDer->move(public_path($rutaGuardarDoc), $nombre_documento);
            $programasDerivados['ruta_documento'] = $nombre_documento;
        }

        if ($portada = $request->file('portada')) {
            $rutaGuardarImg = 'portadaprogder/';
            $nombre_portada = $request->input('nombre');
            $nombre_portada = Str::slug($nombre_portada) . date('YmdHis') . '.' . $portada->getClientOriginalExtension();
            $portada->move(public_path($rutaGuardarImg), $nombre_portada);
            $programasDerivados['portada'] = $nombre_portada;
        }

        ProgramaDerivado::create($programasDerivados);
        return redirect()->route('panel-programasderivados.index')->with('success', 'Programa subido exitosamente.');
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
        $programasDerivados = ProgramaDerivado::findOrFail($id);
        $tiposProgDer = ['Sectoriales', 'Especiales', 'Institucionales', 'Regionales'];
        $planes_estatales = PlanEstatal::all()->pluck('nombre', 'id');
        return view('panel-programasderivados.editar', compact('programasDerivados', 'planes_estatales', 'tiposProgDer'));
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
            $nombre_documento = Str::slug($nombre_documento) . date('YmdHis') . '.' . $ruta_documento->getClientOriginalExtension();
            $ruta_documento->move(public_path('progderi/'), $nombre_documento);
            $programasDerivados->ruta_documento = $nombre_documento;
        }

        if ($request->hasFile('portada')) {
            if ($programasDerivados->portada) {
                unlink(public_path('portadaprogder/') . $programasDerivados->portada);
            }

            $portada = $request->file('portada');
            $nombre_portada = $request->input('nombre');
            $nombre_portada = Str::slug($nombre_portada) . date('YmdHis') . '.' . $portada->getClientOriginalExtension();
            $portada->move(public_path('portadaprogder/'), $nombre_portada);
            $programasDerivados->portada = $nombre_portada;
        }

        if ($request->has('publicado')) {
            $programasDerivados->publicado = $request->publicado;
        }

        $programasDerivados->save();

        return redirect()->route('panel-programasderivados.index')->with('success', 'Programa actualizado exitosamente.');
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

        return redirect()->route('panel-programasderivados.index');
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
}
