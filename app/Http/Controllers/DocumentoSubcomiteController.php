<?php

namespace App\Http\Controllers;

use App\Models\DocumentoSubcomite;
use App\Traits\UpdatesPublicado;
use Illuminate\Http\Request;
use App\Models\Subcomite;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DocumentoSubcomiteController extends Controller
{
    /**
     * Muestra un listado paginado de los documentos de los subcomités, paginado cada 1000 registros.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $DocumentoSubcomites = DocumentoSubcomite::orderBy('anio', 'desc')->orderBy('created_at', 'desc')->get();
        return view('panel-documentos-subcomites.index', compact('DocumentoSubcomites'));
    }

    /**
     * Muestra el formulario para subir un nuevo documento.
     *
     * Pre-carga los datos necesarios para los selectores del formulario
     * (tiposDocuments, subcomites).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tiposDocumentos = ['Informe', 'Acta', 'Programa'];
        $subcomites = Subcomite::with('planestatal')->get()->groupBy('planestatal_id');
        return view('panel-documentos-subcomites.form', compact('tiposDocumentos', 'subcomites'));
    }

    /**
     * Valida y almacena un nuevo documento en la base de datos.
     *
     * Gestiona la subida y el almacenamiento del archivo pdf asociado.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con los datos del nuevo documento.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $currentYear = date('Y');
        $this->validate($request, [
            'nombre' => 'required|string|max:255',
            'anio' => 'required|digits:4|integer|min:2010|max:' . $currentYear,
            'ruta_documento' => 'required|file|mimes:pdf|max:51200',
            'subcomite_id' => 'required|exists:subcomites,id',
            'tipo_documento' => 'required|string|max:255',
            'publicado' => 'nullable|boolean'
        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'nombre.string' => 'El nombre del documento no puede llevar carácteres especiales',
            'nombre.max' => 'El nombre del documento no puede exceder los :max caracteres.',

            'anio.required' => 'El año del documento es requerido',
            'anio.digits' => 'El año debe tener exactamente cuatro dígitos',
            'anio.integer' => 'El año debe ser un número entero',
            'anio.min' => 'El año no puede ser menor a 2010',
            'anio.max' => 'El año no puede ser mayor al año actual',

            'ruta_documento.required' => 'No ha seleccionado el documento.',
            'ruta_documento.file' => 'El campo debe ser un archivo.',
            'ruta_documento.mimes' => 'El archivo debe ser PDF (Formato de documento portátil).',
            'ruta_documento.max' => 'El tamaño del archivo no puede exceder los 50MB.',


            'subcomite_id.required' => 'El documento debe estar vinculado a un subcomite',
            'subcomite_id.exists' => 'El subcomité seleccionado no es válido.',

            'tipo_documento.required' => 'Se requiere el tipo de documento',
            'tipo_documento.string' => 'El tipo de documento debe ser una cadena de texto.',
            'tipo_documento.max' => 'El tipo de documento no puede exceder los :max caracteres.',

            'publicado.boolean' => 'El valor del campo publicado debe ser verdadero o falso',
        ]);

        $DocumentoSubcomites = $request->all();

        if ($ruta_documento = $request->file('ruta_documento')) {
            $rutaGuardarDoc = 'documentosubcomites/';

            $nombreDocumento = Str::slug($request->input('nombre'));

            $extension = $ruta_documento->getClientOriginalExtension();

            $documentodeSubcomite = $nombreDocumento . '-' . $request->input('anio') . '-' . Str::random(4) . '.' . $extension;

            $ruta_documento->move($rutaGuardarDoc, $documentodeSubcomite);

            $DocumentoSubcomites['ruta_documento'] = $documentodeSubcomite;
        }

        $DocumentoSubcomites['publicado'] = $request->has('publicado') ? (bool)$request->input('publicado') : false;

        DocumentoSubcomite::create($DocumentoSubcomites);
        return redirect()->route('panel-documentos-subcomites.index')->with('success', 'Documento subido exitosamente.');
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
     * para los selectores del formulario.
     *
     * @param  int  $id El ID del documento a editar.
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $DocumentoSubcomite = DocumentoSubcomite::findOrFail($id);
        $tiposDocumentos = ['Informe', 'Acta', 'Programa'];
        $subcomites = Subcomite::with('planestatal')->get()->groupBy('planestatal_id');
        return view('panel-documentos-subcomites.form', compact('DocumentoSubcomite', 'tiposDocumentos', 'subcomites'));
    }

    /**
     * Valida y actualiza un documento existente en la base de datos.
     *
     * Gestiona la actualización del documento, eliminando la anterior si se sube uno nuevo.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud con los datos actualizados.
     * @param  int  $id El ID del documento a actualizar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $currentYear = date('Y');
        $this->validate($request, [
            'nombre' => 'required|string|max:255',
            'anio' => 'required|digits:4|integer|min:2010|max:' . $currentYear,
            'ruta_documento' => 'file|mimes:pdf|max:51200',
            'subcomite_id' => 'required|exists:subcomites,id',
            'tipo_documento' => 'required|string|max:255',
            'publicado' => 'nullable|boolean'
        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'nombre.max' => 'El nombre del documento no puede exceder los :max caracteres.',
            'nombre.string' => 'El nombre del documento no puede llevar carácteres especiales',

            'anio.required' => 'El año del documento es requerido',
            'anio.digits' => 'El año debe tener exactamente cuatro dígitos',
            'anio.integer' => 'El año debe ser un número entero',
            'anio.min' => 'El año no puede ser menor a 2010',
            'anio.max' => 'El año no puede ser mayor al año actual',

            'ruta_documento.mimes' => 'El archivo debe ser PDF (Formato de documento portátil)',
            'ruta_documento.file' => 'El campo debe ser un archivo.',
            'ruta_documento.max' => 'El tamaño del archivo no puede exceder los 50MB.',

            'subcomite_id.required' => 'El documento debe estar vinculado a un subcomite',
            'subcomite_id.exists' => 'El subcomité seleccionado no es válido.',

            'tipo_documento.required' => 'Se requiere el tipo de documento',
            'tipo_documento.string' => 'El tipo de documento debe ser una cadena de texto.',
            'tipo_documento.max' => 'El tipo de documento no puede exceder los :max caracteres.',

            'publicado.boolean' => 'El valor del campo publicado debe ser verdadero o falso',
        ]);

        $docSubco = $request->all();

        // Verificar si el tipo de documento cambió a algo diferente de "Acta"
        if ($docSubco['tipo_documento'] !== 'Acta') {
            // Actualizar el valor del tipo de acta a null
            $docSubco['tipo_acta'] = null;
        }

        $documentoSubcomite = DocumentoSubcomite::find($id);

        if ($ruta_documento = $request->file('ruta_documento')) {
            $rutaGuardarDoc = 'documentosubcomites/';
            $nombreDocumento = $request->input('nombre');

            // Reemplazar acentos y espacios en el nombre del documento
            $nombreDocumento = Str::slug($request->input('nombre'));

            $extension = $ruta_documento->getClientOriginalExtension();
            $documentodeSubcomite = $nombreDocumento . '-' . $request->input('anio') . '-' . Str::random(4) . '.' . $extension;

            if ($documentoSubcomite->ruta_documento) {
                $archivoAnterior = public_path($rutaGuardarDoc . $documentoSubcomite->ruta_documento);
                if (file_exists($archivoAnterior)) {
                    unlink($archivoAnterior);
                }
            }

            $ruta_documento->move($rutaGuardarDoc, $documentodeSubcomite);
            $docSubco['ruta_documento'] = $documentodeSubcomite;
        } else {
            unset($docSubco['ruta_documento']);
        }


        $documentoSubcomite = DocumentoSubcomite::find($id);
        $documentoSubcomite->update($docSubco);
        return redirect()->route('panel-documentos-subcomites.index')->with('success', 'Documento actualizado exitosamente.');
    }

    /**
     * Elimina un documento de la base de datos y su archivo pdf asociado.
     *
     * @param  int  $id El ID del documento a eliminar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $documentoSubcomite = DocumentoSubcomite::find($id);

        $rutaArchivo = public_path('documentosubcomites/') . $documentoSubcomite->ruta_documento;

        if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
        }
        $documentoSubcomite->delete();
        return redirect()->route('panel-documentos-subcomites.index')->with('success', 'Documento eliminado exitosamente.');
    }

    /**
     * Obtiene la clase del modelo principal que este controlador gestiona.
     *
     * Este método es utilizado por el trait 'UpdatesPublicado'
     * para interactuar con el modelo 'DocumentoSubcomite'.
     *
     * @return string La ruta completa de la clase del modelo.
     */
    use UpdatesPublicado;
    protected function getModel()
    {
        return DocumentoSubcomite::class;
    }
}
