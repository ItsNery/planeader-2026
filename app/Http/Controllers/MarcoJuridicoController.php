<?php

namespace App\Http\Controllers;

use App\Models\MarcoJuridico;
use App\Models\MarcoJuridicoClasificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MarcoJuridicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-marco-juridico|crear-marco-juridico|editar-marco-juridico|borrar-marco-juridico', ['only' => ['index']]);
        $this->middleware('permission:crear-marco-juridico', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-marco-juridico', ['only' => ['edit', 'update', 'updatePublicado']]);
        $this->middleware('permission:borrar-marco-juridico', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentos = MarcoJuridico::with('clasificacion.ambito', 'clasificacion.tipoDocumento')->paginate(1000);
        return view('panel-marco-juridico.index', compact('documentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $totalDocumentos = MarcoJuridico::count();
        $ordenesExistentes = MarcoJuridico::pluck('orden')->toArray();
        $ordenesDisponibles = range(1, $totalDocumentos + 2);
        $clasificaciones = MarcoJuridicoClasificacion::with('ambito', 'tipoDocumento')
            ->orderBy('ambito_id')
            ->orderBy('tipo_documento_id')
            ->get();

        return view('panel-marco-juridico.form')
            ->with('documento', null)
            ->with('clasificaciones', $clasificaciones)
            ->with('ordenesExistentes', $ordenesExistentes)
            ->with('ordenesDisponibles', $ordenesDisponibles);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'ruta_documento' => 'required|mimes:pdf|max:500000',
            'portada' => 'required|image|mimes:jpeg,png,svg,jpg|max:6144',
            'orden' => 'required|integer',
            'publicado' => 'nullable',
            'marco_juridico_clasificacion_id' => 'required|exists:marco_juridico_clasificaciones,id',
        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'ruta_documento.required' => 'No ha elegido un documento',
            'ruta_documento.mimes' => 'El archivo debe ser PDF (Formato de documento portátil)',
            'ruta_documento.max' => 'El archivo no debe pesar mas de 500MB',
            'portada.required' => 'Se requiere la portada del plan',
            'portada.image' => 'El archivo no es una imagen',
            'portada.mimes' => 'El archivo no es una imagen',
            'portada.max' => 'La imagen no debe pesar mas de 6MB',
            'orden.required' => 'Se requiere un número para definir el orden, por ej.:1 o 2 o 3, etc',
            'orden.integer' => 'Se requiere un número',
            'marco_juridico_clasificacion_id.required' => 'Se requiere la clasificación normativa',
            'marco_juridico_clasificacion_id.exists' => 'La clasificación normativa seleccionada no es válida',
        ]);

        // Obtener los datos individuales del formulario
        $nombre = $request->input('nombre');
        $ruta_documento = $request->file('ruta_documento');
        $portada = $request->file('portada');
        $orden = $request->input('orden');
        $clasificacion = MarcoJuridicoClasificacion::with('ambito')->findOrFail($request->input('marco_juridico_clasificacion_id'));

        // Crear un nuevo registro MarcoJuridico con los datos recibidos
        $documentosMarcoJuridico = new MarcoJuridico();
        $documentosMarcoJuridico->nombre = $nombre;
        $documentosMarcoJuridico->orden = $orden;
        $documentosMarcoJuridico->tipo = $clasificacion->ambito->nombre;
        $documentosMarcoJuridico->marco_juridico_clasificacion_id = $clasificacion->id;

        // $documentosMarcoJuridico = $request->all();

        if ($ruta_documentomarco = $request->file('ruta_documento')) {
            $rutaGuardarDoc = 'marco-juridico/';
            $slugNombre = Str::limit(Str::slug($nombre), 70);
            $nombreArchivo = $slugNombre . date('YmdHis') . "." . $ruta_documentomarco->getClientOriginalExtension();

            $ruta_documentomarco->move($rutaGuardarDoc, $nombreArchivo); // Corregido aquí
            $documentosMarcoJuridico['ruta_documento'] = $nombreArchivo; // Y también aquí
        }

        if ($portada = $request->file('portada')) {
            $rutaGuardarImg = 'portadas-marcojuridico/';
            $slugNombrePortada = Str::limit('Portada_de_' . Str::slug($nombre), 70);
            $nombrePortada = $slugNombrePortada . '_'  . date('YmdHis') . "." . $portada->getClientOriginalExtension();

            $portada->move($rutaGuardarImg, $nombrePortada);
            $documentosMarcoJuridico['portada'] = $nombrePortada; // Corregido aquí
        }
        if ($request->has('publicado')) {
            $documentosMarcoJuridico->publicado = $request->publicado;
        }

        // MarcoJuridico::create($documentosMarcoJuridico);
        $documentosMarcoJuridico->save();
        // return redirect()->route('.index');
        return redirect()->route('panel-marco-juridico.index')->with('success', 'Documento subido exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $totalDocumentos = MarcoJuridico::count();
        $ordenesExistentes = MarcoJuridico::pluck('orden')->toArray();
        $ordenesDisponibles = range(1, $totalDocumentos + 1);
        $documentosMarcoJuridico = MarcoJuridico::with('clasificacion.ambito', 'clasificacion.tipoDocumento')->findOrFail($id);
        $clasificaciones = MarcoJuridicoClasificacion::with('ambito', 'tipoDocumento')
            ->orderBy('ambito_id')
            ->orderBy('tipo_documento_id')
            ->get();

        return view('panel-marco-juridico.form')
            ->with('documento', $documentosMarcoJuridico)
            ->with('clasificaciones', $clasificaciones)
            ->with('ordenesExistentes', $ordenesExistentes)
            ->with('ordenesDisponibles', $ordenesDisponibles);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'nombre' => 'required',
            'ruta_documento' => 'nullable|mimes:pdf',
            'portada' => 'nullable|image|mimes:jpeg,png,svg,jpg|max:6144',
            'orden' => 'required|integer',
            'publicado' => 'nullable',
            'marco_juridico_clasificacion_id' => 'required|exists:marco_juridico_clasificaciones,id',
        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'ruta_documento.mimes' => 'El archivo debe ser PDF (Formato de documento portátil)',
            'portada.image' => 'El archivo no es una imagen',
            'portada.mimes' => 'El archivo no es una imagen',
            'portada.max' => 'La imagen no debe pesar más de 6MB',
            'orden.required' => 'Se requiere el número de ordenación del documento',
            'orden.integer' => 'Se requiere el número',
            'marco_juridico_clasificacion_id.required' => 'Se requiere la clasificación normativa',
            'marco_juridico_clasificacion_id.exists' => 'La clasificación normativa seleccionada no es válida',
        ]);

        $documentosMarcoJuridico = MarcoJuridico::findOrFail($id);
        $clasificacion = MarcoJuridicoClasificacion::with('ambito')->findOrFail($request->marco_juridico_clasificacion_id);

        // Actualizar campos no relacionados con archivos
        $documentosMarcoJuridico->nombre = $request->nombre;
        $documentosMarcoJuridico->orden = $request->orden;
        $documentosMarcoJuridico->tipo = $clasificacion->ambito->nombre;
        $documentosMarcoJuridico->marco_juridico_clasificacion_id = $clasificacion->id;
        $slugNombre = Str::limit(Str::slug($request->nombre), 70);

        // Manejar la actualización de la ruta del documento (si se proporciona un nuevo archivo)
        if ($request->hasFile('ruta_documento')) {
            $ruta_documento = $request->file('ruta_documento');
            $nombre_documento = $slugNombre . '_' . date('YmdHis') . '.' . $ruta_documento->getClientOriginalExtension();
            $ruta_documento->move(public_path('marco-juridico/'), $nombre_documento);
            $documentosMarcoJuridico->ruta_documento = $nombre_documento;
        }

        // Manejar la actualización de la portada (si se proporciona un nuevo archivo)
        if ($request->hasFile('portada')) {
            $portada = $request->file('portada');
            $nombre_portada = 'Portada_de_' . Str::limit(Str::slug($request->nombre), 70);
            $nombre_portada = $nombre_portada . '_' . date('YmdHis') . '.' . $portada->getClientOriginalExtension();
            $portada->move(public_path('portadas-marcojuridico/'), $nombre_portada);
            $documentosMarcoJuridico->portada = $nombre_portada;
        }

        // Manejar la actualización del campo publicado si se proporciona
        if ($request->has('publicado')) {
            $documentosMarcoJuridico->publicado = $request->publicado;
        }

        // Guardar los cambios en la base de datos
        $documentosMarcoJuridico->save();

        return redirect()->route('panel-marco-juridico.index')->with('success', 'Documento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $documento = MarcoJuridico::findOrFail($id);

        $rutaArchivo = public_path('marco-juridico/') . $documento->ruta_documento;

        // Verificar si el archivo existe y luego eliminarlo
        if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
        }
        $rutaArchivo2 = public_path('portadas-marcojuridico/') . $documento->portada;

        // Verificar si el archivo existe y luego eliminarlo
        if (file_exists($rutaArchivo2)) {
            unlink($rutaArchivo2);
        }

        $documento->delete();

        return redirect()->route('panel-marco-juridico.index');
    }

    public function mostrarDocumentosMarco()
    {
        $documentos = MarcoJuridico::with('clasificacion.ambito', 'clasificacion.tipoDocumento')
            ->where('publicado', 1)
            ->get()
            ->sortBy(function ($doc) {
                return [
                    optional(optional($doc->clasificacion)->ambito)->orden ?? 99,
                    $doc->orden
                ];
            })
            ->groupBy('ambito_nombre')
            ->map(fn($docs) => $docs->groupBy('tipo_documento_nombre'));

        return view('marcojuridico', compact('documentos'));
    }
    public function updatePublicado(Request $request, $id)
    {
        $request->validate([
            'publicado' => 'required|boolean',
        ]);

        $documento = MarcoJuridico::findOrFail($id);
        $documento->publicado = $request->input('publicado');
        $documento->save();

        return redirect()->back()->with('success', 'Estado de publicación actualizado');
    }
}
