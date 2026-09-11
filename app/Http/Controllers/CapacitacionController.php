<?php

namespace App\Http\Controllers;
use App\Models\Capacitacion;
use App\Models\Documento;
use App\Models\DocumentoCapacitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Traits\UpdatesPublicado;

class CapacitacionController extends Controller
{
    use UpdatesPublicado;

    public function __construct()
    {
        $this->middleware('permission:ver-capacitacion|crear-capacitacion|editar-capacitacion|borrar-capacitacion', ['only' => ['index']]);
        $this->middleware('permission:crear-capacitacion', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-capacitacion', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-capacitacion', ['only' => ['destroy', 'destroyDocumento']]);
    }

    /**
     * Muestra un listado de las capacitaciones.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $capacitaciones = Capacitacion::latest()->get();
        return view('panel-capacitaciones.index', compact('capacitaciones'));
    }

    /**
     * Muestra el formulario para crear una nueva capacitación .
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('panel-capacitaciones.form', [
            'capacitacione' => new Capacitacion()
        ]);
    }

    /**
     * Valida y almacena la nueva capacitación en la base de datos.
     *
     * Gestiona la subida y el almacenamiento del archivo de imagen asociado.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con los datos de la nueva capacitación.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen_programa' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'publicado' => 'nullable|boolean',
            'documentos.*.nombre' => 'nullable|string',
            'documentos.*.archivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
            'documentos.*.dia' => 'nullable|integer|in:1,2,3',
        ]);

        $file = $request->file('imagen_programa');
        $nombreArchivo = Str::slug($request->nombre) . '.' . $file->getClientOriginalExtension();
        $rutaImagen = $file->storeAs('.', $nombreArchivo, 'capacitaciones_public');

        $capacitacion = Capacitacion::create([
            'nombre' => $request->nombre,
            'imagen_programa' => $rutaImagen,
            'publicado' => $request->boolean('publicado', false),
        ]);

        if ($request->has('documentos')) {
            foreach ($request->documentos as $index => $docData) {
                if ($request->hasFile("documentos.$index.archivo")) {
                    $file = $request->file("documentos.$index.archivo");
                    $nombreDisplay = $docData['nombre'] ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $nombreArchivoUnico = Str::slug($request->nombre . ' ' . $nombreDisplay) . '.' . $file->getClientOriginalExtension();
                    $rutaGuardadaDoc = $file->storeAs('.', $nombreArchivoUnico, 'capacitaciones_public');

                    $capacitacion->documentos()->create([
                        'nombre_display' => $nombreDisplay,
                        'ruta_archivo' => $rutaGuardadaDoc,
                        'dia_agrupador' => $docData['dia'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('capacitaciones.index')->with('success', 'Capacitación creada exitosamente.');
    }

    /**
     * Display the specified resource.
     * Actualmente no se utiliza, pero se puede implementar si es necesario.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Muestra el formulario para editar una capacitación existente.
     *
     * Carga los datos de la capacitación a editar y la información necesaria
     * para la carga de los documentos.
     *
     * @param  Capacitacion $capacitacione El objeto capacitacione con la info de la capacitación.
     * @return \Illuminate\View\View
     */
    public function edit(Capacitacion $capacitacione)
    {
        return view('panel-capacitaciones.form', compact('capacitacione'));
    }

    /**
     * Valida y actualiza una capacitación existente en la base de datos.
     *
     * Gestiona la actualización de la imagen, eliminando la anterior si se sube una nueva.
     * Gestiona la carga de nuevos documentos asociados a la capacitación.
     * 
     * @param  \Illuminate\Http\Request  $request La solicitud con los datos actualizados.
     * @param  int  $id El ID del banner a actualizar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Capacitacion $capacitacione)
    {
        $request->validate(
            [
                'nombre' => 'required|string|max:255',
                'imagen_programa' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'publicado' => 'nullable|boolean',
                'documentos.*.id' => 'nullable|exists:documento_capacitacions,id',
                'documentos.*.nombre' => 'nullable|string',
                'documentos.*.archivo' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
                'documentos.*.dia' => 'nullable|integer|in:1,2,3',
                'deleted_documentos' => 'nullable|array',
                'deleted_documentos.*' => 'exists:documento_capacitacions,id',
            ],
            [
                'nombre.required' => 'Se requiere un nombre'
            ]
        );

        // Actualizar datos básicos
        $capacitacione->nombre = $request->nombre;
        $capacitacione->publicado = $request->boolean('publicado', false);

        if ($request->hasFile('imagen_programa')) {
            if ($capacitacione->imagen_programa) {
                Storage::disk('capacitaciones_public')->delete($capacitacione->imagen_programa);
            }

            $file = $request->file('imagen_programa');
            $nombreArchivo = 'flyer_' . Str::slug($request->nombre) . '.' . $file->getClientOriginalExtension();
            $rutaGuardada = $file->storeAs('.', $nombreArchivo, 'capacitaciones_public');

            $capacitacione->imagen_programa = $rutaGuardada;
        }
        $capacitacione->save();

        // Manejar eliminaciones
        if ($request->has('deleted_documentos')) {
            // Optimización: Cargar todos los documentos a eliminar en una sola consulta para evitar N+1
            $documentosAEliminar = DocumentoCapacitacion::whereIn('id', $request->deleted_documentos)->get();
            foreach ($documentosAEliminar as $documento) {
                Storage::disk('capacitaciones_public')->delete($documento->ruta_archivo);
                $documento->delete();
            }
        }

        // Manejar documentos (Actualizaciones y Nuevos)
        if ($request->has('documentos')) {
            // Optimización: Cargar documentos existentes en lote para evitar N+1
            $ids = collect($request->documentos)->pluck('id')->filter()->toArray();
            $documentosExistentes = DocumentoCapacitacion::whereIn('id', $ids)->get()->keyBy('id');

            foreach ($request->documentos as $index => $docData) {
                $documento = isset($docData['id']) ? $documentosExistentes->get($docData['id']) : null;

                if ($documento) {
                    // Actualizar existente
                    $documento->nombre_display = $docData['nombre'] ?? $documento->nombre_display;
                    $documento->dia_agrupador = $docData['dia'] ?? null;

                    if ($request->hasFile("documentos.$index.archivo")) {
                        Storage::disk('capacitaciones_public')->delete($documento->ruta_archivo);

                        $file = $request->file("documentos.$index.archivo");
                        $nombreArchivoUnico = Str::slug($capacitacione->nombre . ' ' . $documento->nombre_display) . '.' . $file->getClientOriginalExtension();
                        $documento->ruta_archivo = $file->storeAs('.', $nombreArchivoUnico, 'capacitaciones_public');
                    }
                    $documento->save();
                } else {
                    // Crear nuevo
                    if ($request->hasFile("documentos.$index.archivo")) {
                        $file = $request->file("documentos.$index.archivo");
                        $nombreDisplay = $docData['nombre'] ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $nombreArchivoUnico = Str::slug($capacitacione->nombre . ' ' . $nombreDisplay) . '.' . $file->getClientOriginalExtension();
                        $rutaGuardadaDoc = $file->storeAs('.', $nombreArchivoUnico, 'capacitaciones_public');

                        $capacitacione->documentos()->create([
                            'nombre_display' => $nombreDisplay,
                            'ruta_archivo' => $rutaGuardadaDoc,
                            'dia_agrupador' => $docData['dia'] ?? null,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('capacitaciones.index')->with('success', 'Capacitación actualizada correctamente.');
    }

    /**
     * Elimina una capacitación de la base de datos y su archivo de imagen asociado.
     * Elimina también todos los documentos asociados a la capacitación.
     *
     * @param  Capacitacion $capacitacione El elemento capacitacione a eliminar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Capacitacion $capacitacione)
    {
        DB::transaction(function () use ($capacitacione) {
            foreach ($capacitacione->documentos as $documento) {
                Storage::disk('capacitaciones_public')->delete($documento->ruta_archivo);
            }
            Storage::disk('capacitaciones_public')->delete($capacitacione->imagen_programa);
            $capacitacione->delete();
        });

        return redirect()->route('capacitaciones.index')->with('success', 'Capacitación y todos sus documentos han sido eliminados.');
    }

    /**
     * Elimina un documento de capacitación de la base de datos y su archivo asociado.
     *
     * @param  DocumentoCapacitacion $documento El elemento DocumentoCapacitacion a eliminar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyDocumento(DocumentoCapacitacion $documento)
    {
        Storage::disk('capacitaciones_public')->delete($documento->ruta_archivo);

        $documento->delete();

        return back()->with('success', 'Documento eliminado exitosamente.');
    }
    protected function getModel()
    {
        return Capacitacion::class;
    }
    /**
     * Muestra un listado de las capacitaciones con sus documentos asociados.
     * Esta función se utiliza para mostrar las capacitaciones en la vista publica de capacitaciones, desglozado por capacitación, y día agrupador si existiera.
     *
     * @return \Illuminate\View\View
     */
    public function listarcapacitaciones()
    {
        $capacitaciones = Capacitacion::with('documentos')->where('publicado', true)->latest()->get();
        return view('capacitaciones', compact('capacitaciones'));
    }
}
