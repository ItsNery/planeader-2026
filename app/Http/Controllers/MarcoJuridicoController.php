<?php

namespace App\Http\Controllers;

use App\Models\MarcoJuridico;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\UpdatesPublicado;

class MarcoJuridicoController extends Controller
{
    /**
     * Muestra un listado paginado de los documentos del marco jurídico, paginado cada 1000 registros.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $documentos = MarcoJuridico::orderBy('orden', 'asc')->get();
        return view('panel-marco-juridico.index', compact('documentos'));
    }

    /**
     * Muestra el formulario para subir un nuevo documento.
     *
     * Pre-carga los datos necesarios para los selectores del formulario
     * Calcula el total de documentos existentes y las órdenes disponibles
     * (totalDocumentos, ordenesExistentes, ordenesDisponibles).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $documento = new MarcoJuridico();
        $totalDocumentos = MarcoJuridico::count();
        $ordenesExistentes = MarcoJuridico::pluck('orden')->toArray();
        $ordenesDisponibles = range(1, $totalDocumentos + 1);
        return view('panel-marco-juridico.form', compact('documento', 'ordenesExistentes', 'ordenesDisponibles'));
    }

    /**
     * Valida y almacena un nuevo documento en la base de datos.
     *
     * Gestiona la subida y el almacenamiento del archivo pdf e imagen asociados.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con los datos del nuevo documento.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|string|max:255',
            'ruta_documento' => 'required|file|mimes:pdf|max:51200',
            'portada' => 'required|image|mimes:jpeg,png,jpg,svg|max:6144',
            'orden' => 'required|integer|min:1',
            'publicado' => 'nullable'
        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'nombre.string' => 'El nombre del documento debe ser texto.',
            'nombre.max' => 'El nombre del documento no puede exceder los :max caracteres.',

            'ruta_documento.required' => 'Es obligatorio seleccionar un documento PDF.',
            'ruta_documento.file' => 'El campo documento debe ser un archivo válido.',
            'ruta_documento.mimes' => 'El documento debe ser un archivo PDF.',
            'ruta_documento.max' => 'El tamaño del documento no debe superar los 50 MB.',

            'portada.required' => 'Es obligatorio seleccionar una imagen de portada.',
            'portada.image' => 'El archivo de portada debe ser una imagen.',
            'portada.mimes' => 'La imagen de portada debe ser de tipo JPEG, PNG, JPG o SVG.',
            'portada.max' => 'El tamaño de la imagen de portada no debe superar los 6 MB.',

            'orden.required' => 'Es obligatorio especificar un número para el orden.',
            'orden.integer' => 'El orden debe ser un número entero.',
            'orden.min' => 'El número de orden debe ser al menos :min.',
        ]);

        $nombre = $request->input('nombre');
        $ruta_documento = $request->file('ruta_documento');
        $portada = $request->file('portada');
        $orden = $request->input('orden');

        $documentosMarcoJuridico = new MarcoJuridico();
        $documentosMarcoJuridico->nombre = $nombre;
        $documentosMarcoJuridico->orden = $orden;

        if ($ruta_documentomarco = $request->file('ruta_documento')) {
            $rutaGuardarDoc = 'marco-juridico/';
            $slugNombre = Str::limit(Str::slug($nombre), 70);
            $nombreArchivo = $slugNombre . '-' . Str::random(4) . "." . $ruta_documentomarco->getClientOriginalExtension();

            $ruta_documentomarco->move($rutaGuardarDoc, $nombreArchivo);
            $documentosMarcoJuridico['ruta_documento'] = $nombreArchivo;
        }

        if ($portada = $request->file('portada')) {
            $rutaGuardarImg = 'portadas-marcojuridico/';
            $slugNombrePortada = Str::limit('Portada_de_' . Str::slug($nombre), 70);
            $nombrePortada = $slugNombrePortada . '_'  . Str::random(4) . "." . $portada->getClientOriginalExtension();

            $portada->move($rutaGuardarImg, $nombrePortada);
            $documentosMarcoJuridico['portada'] = $nombrePortada;
        }
        if ($request->has('publicado')) {
            $documentosMarcoJuridico->publicado = $request->publicado;
        }

        $documentosMarcoJuridico->save();
        return redirect()->route('panel-marco-juridico.index')->with('success', 'Documento subido exitosamente.');
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
     * para los selectores del formulario. Además calcula el total de documentos existentes y los ordenes disponibles
     * (totalDocumentos, ordenesExistentes, ordenesDisponibles).
     *
     * @param  int  $id El ID del documento a editar.
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $documento = MarcoJuridico::findOrFail($id);
        $totalDocumentos = MarcoJuridico::count();
        $ordenesExistentes = MarcoJuridico::pluck('orden')->toArray();
        $ordenesDisponibles = range(1, $totalDocumentos);
        return view('panel-marco-juridico.form', compact('documento', 'ordenesExistentes', 'ordenesDisponibles'));
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
            'nombre' => 'required|string|max:255',
            'ruta_documento' => 'nullable|file|mimes:pdf|max:51200',
            'portada' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:6144',
            'orden' => 'required|integer|min:1',
            'publicado' => 'nullable'
        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'nombre.string' => 'El nombre del documento debe ser texto.',
            'nombre.max' => 'El nombre del documento no puede exceder los :max caracteres.',

            'ruta_documento.mimes' => 'El archivo debe ser PDF (Formato de documento portátil)',
            'ruta_documento.max' => 'El tamaño del documento no debe superar los 50 MB.',
            'ruta_documento.file' => 'El campo documento debe ser un archivo válido.',

            'portada.image' => 'El archivo no es una imagen',
            'portada.mimes' => 'El archivo no es una imagen',
            'portada.max' => 'La imagen no debe pesar más de 6MB',

            'orden.required' => 'Se requiere el número de ordenación del documento',
            'orden.integer' => 'Se requiere el número',
            'orden.min' => 'El número de orden debe ser al menos :min.',
        ]);

        $documentosMarcoJuridico = MarcoJuridico::findOrFail($id);

        $documentosMarcoJuridico->nombre = $request->nombre;
        $documentosMarcoJuridico->orden = $request->orden;
        $slugNombre = Str::limit(Str::slug($request->nombre), 70);

        if ($request->hasFile('ruta_documento')) {
            $ruta_documento = $request->file('ruta_documento');
            $nombre_documento = $slugNombre . '_' . Str::random(4) . '.' . $ruta_documento->getClientOriginalExtension();
            $ruta_documento->move(public_path('marco-juridico/'), $nombre_documento);
            $documentosMarcoJuridico->ruta_documento = $nombre_documento;
        }

        if ($request->hasFile('portada')) {
            $portada = $request->file('portada');
            $nombre_portada = 'Portada_de_' . Str::limit(Str::slug($request->nombre), 70);
            $nombre_portada = $nombre_portada . '_' . Str::random(4) . '.' . $portada->getClientOriginalExtension();
            $portada->move(public_path('portadas-marcojuridico/'), $nombre_portada);
            $documentosMarcoJuridico->portada = $nombre_portada;
        }

        if ($request->has('publicado')) {
            $documentosMarcoJuridico->publicado = $request->publicado;
        }

        $documentosMarcoJuridico->save();

        return redirect()->route('panel-marco-juridico.index')->with('success', 'Documento actualizado exitosamente.');
    }

    /**
     * Elimina un documento de la base de datos y su archivo pdf e imagen asociado.
     *
     * @param  int  $id El ID del documento a eliminar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $documento = MarcoJuridico::findOrFail($id);

        $rutaArchivo = public_path('marco-juridico/') . $documento->ruta_documento;

        if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
        }
        $rutaArchivo2 = public_path('portadas-marcojuridico/') . $documento->portada;

        if (file_exists($rutaArchivo2)) {
            unlink($rutaArchivo2);
        }

        $documento->delete();

        return redirect()->route('panel-marco-juridico.index')->with('success', 'Documento eliminado exitosamente.');
    }

    /**
     * Muestra un listado de los documentos del marco jurídico en la vista pública del portal, ordenados de manera ascendente por el campo orden.
     *
     * @return \Illuminate\View\View
     */
    public function mostrarDocumentosMarco()
    {
        $documentos = MarcoJuridico::where('publicado', 1)
            ->orderBy('orden', 'asc')
            ->get();
        return view('marcojuridico', compact('documentos'));
    }

    use UpdatesPublicado;
    /**
     * Define el modelo principal que este controlador gestiona
     * para ser utilizado por el trait UpdatesPublicado.
     *
     * @return string La clase del modelo MarcoJuridico.
     */
    protected function getModel()
    {
        return MarcoJuridico::class;
    }
}
