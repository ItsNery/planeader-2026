<?php

namespace App\Http\Controllers;

use App\Models\DocumentoCopladep;
use Illuminate\Http\Request;
use App\Traits\UpdatesPublicado;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DocumentoCopladepController extends Controller
{
    /**
     * Muestra un listado paginado de los documentos del COPLADEP.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $documentosCopladep = DocumentoCopladep::orderBy('anio', 'desc')->orderBy('created_at', 'desc')->paginate(1000); // Cambia el número según tus necesidades
        return view('panel-documentoscopladep.index', compact('documentosCopladep'));
    }

    /**
     * Muestra el formulario para subir un nuevo documento.
     *
     * Pre-carga los datos necesarios para los selectores del formulario
     * (tiposDocuments).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tiposDocumentos = ['Informe', 'Acta', 'Programa'];
        return view('panel-documentoscopladep.crear', compact('tiposDocumentos'));
    }

    /**
     * Valida y almacena un nuevo documento en la base de datos.
     *
     * Gestiona la subida y el almacenamiento del archivo de imagen y pdf asociado.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con los datos del nuevo banner.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $currentYear = date('Y');
        $this->validate($request, [
            'nombre' => 'required|string',
            'anio' => 'required|digits:4|integer|min:2010|max:' . $currentYear,
            'ruta_documento' => 'required|mimes:pdf|max:51200',
            'tipo_documento' => 'required',
            'publicado' => 'nullable|boolean'
        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'nombre.string' => 'El nombre del documento no puede llevar carácteres especiales',

            'anio.required' => 'El año del documento es requerido',
            'anio.digits' => 'El año debe tener exactamente cuatro dígitos',
            'anio.integer' => 'El año debe ser un número entero',
            'anio.min' => 'El año no puede ser menor a 2010',
            'anio.max' => 'El año no puede ser mayor al año actual',

            'ruta_documento.required' => 'No ha elegido un archivo',
            'ruta_documento.mimes' => 'El archivo debe ser PDF (Formato de documento portátil)',
            'ruta_documento.max' => 'El archivo no puede pesar más de 50 MB',

            'tipo_documento.required' => 'Se requiere el tipo de documento',

            'publicado.boolean' => 'El valor del campo publicado debe ser verdadero o falso',
        ]);

        $documentosCopladep = $request->all();

        if ($ruta_documento = $request->file('ruta_documento')) {
            $rutaGuardarDoc = 'documentocopladep/';

            $nombreDocumento = Str::slug($request->input('nombre')) . '-' . $request->input('anio') . '-' . now()->format('YmdHis');

            $extension = $ruta_documento->getClientOriginalExtension();

            $documentodeCopladep = $nombreDocumento . '.' . $extension;

            $ruta_documento->move($rutaGuardarDoc, $documentodeCopladep);

            $documentosCopladep['ruta_documento'] = $documentodeCopladep;
        }

        $documentosCopladep['publicado'] = $request->has('publicado') ? (bool)$request->input('publicado') : false;

        DocumentoCopladep::create($documentosCopladep);
        return redirect()->route('panel-documentoscopladep.index')->with('success', 'Documento subido exitosamente.');
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
        $documentosCopladep = DocumentoCopladep::findOrFail($id);
        $tiposDocumentos = ['Informe', 'Acta', 'Programa'];
        return view('panel-documentoscopladep.editar', compact('documentosCopladep', 'tiposDocumentos'));
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
            'nombre' => 'required|string',
            'anio' => 'required|digits:4|integer|min:2010|max:' . $currentYear,
            'ruta_documento' => 'mimes:pdf|max:51200',
            'tipo_documento' => 'required',
            'publicado' => 'nullable|boolean'
        ], [
            'nombre.required' => 'El nombre del documento es requerido',

            'anio.required' => 'El año del documento es requerido',
            'anio.digits' => 'El año debe tener exactamente cuatro dígitos',
            'anio.integer' => 'El año debe ser un número entero',
            'anio.min' => 'El año no puede ser menor a 2010',
            'anio.max' => 'El año no puede ser mayor al año actual',

            'ruta_documento.mimes' => 'El archivo debe ser PDF (Formato de documento portátil)',
            'ruta_documento.max' => 'El archivo no puede pesar más de 50 MB',
            'tipo_documento.required' => 'Se requiere el tipo de documento',
            'publicado.boolean' => 'El valor del campo publicado debe ser verdadero o falso',
        ]);

        $docCopladep = $request->all();

        $docCopladep['publicado'] = $request->has('publicado') ? (bool)$request->input('publicado') : false;

        if ($docCopladep['tipo_documento'] !== 'Acta') {
            $docCopladep['tipo_acta'] = null;
        }

        $documentosCopladep = DocumentoCopladep::find($id);

        if ($ruta_documentoCop = $request->file('ruta_documento')) {
            if ($documentosCopladep && $documentosCopladep->ruta_documento) {
                $rutaArchivoAnterior = 'documentocopladep/' . $documentosCopladep->ruta_documento;
                if (file_exists($rutaArchivoAnterior)) {
                    unlink($rutaArchivoAnterior);
                }
            }

            $rutaGuardarDoc = 'documentocopladep/';

            $nombreDocumento = Str::slug($request->input('nombre')) . '-' . $request->input('anio') . '-' . now()->format('YmdHis');

            $extension = $ruta_documentoCop->getClientOriginalExtension();

            $nombreArchivo = $nombreDocumento . '.' . $extension;

            $ruta_documentoCop->move($rutaGuardarDoc, $nombreArchivo);

            $docCopladep['ruta_documento'] = $nombreArchivo;
        } else {
            unset($docCopladep['ruta_documento']);
        }

        $documentosCopladep->update($docCopladep);

        return redirect()->route('panel-documentoscopladep.index')->with('success', 'Documento actualizado exitosamente.');
    }

    /**
     * Elimina un documento de la base de datos y su archivo pdf asociado.
     *
     * @param  int  $id El ID del documento a eliminar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $documentoCopladep = DocumentoCopladep::findOrFail($id);

        $nombreArchivo = $documentoCopladep->ruta_documento;

        $rutaArchivo = public_path('documentocopladep/') . $nombreArchivo;

        if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
        }

        $documentoCopladep->delete();

        return redirect()->route('panel-documentoscopladep.index')->with('success', 'Documento eliminado exitosamente.');
    }

    /**
     * Muestra un listado paginado de los documentos de copladep publicados, agrupados por año y envia la fecha de actualización más reciente a  la vista.
     *
     * @return \Illuminate\View\View
     */
    public function mostrarDocumentosCopladep()
    {
        $anios = DocumentoCopladep::where('publicado', 1)
            ->select('anio')
            ->distinct()
            ->get();

        $documentos = DocumentoCopladep::where('publicado', 1)
            ->orderBy('tipo_documento')
            ->get()
            ->groupBy('anio')
            ->map(function ($anioDocs) {
                return $anioDocs->groupBy('tipo_documento');
            });

        $ultimaActualizacion = $documentos->flatten()->max('updated_at');
        return view('copladep', compact('anios', 'documentos', 'ultimaActualizacion'));
    }

    /**
     * Obtiene la clase del modelo principal que este controlador gestiona.
     *
     * Este método es utilizado por el trait 'UpdatesPublicado'
     * para interactuar con el modelo 'DocumentoCopladep'.
     *
     * @return string La ruta completa de la clase del modelo.
     */
    use UpdatesPublicado;
    protected function getModel()
    {
        return DocumentoCopladep::class;
    }
}
