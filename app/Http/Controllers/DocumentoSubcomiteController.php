<?php
// local
namespace App\Http\Controllers;

use App\Models\DocumentoSubcomite;
use App\Traits\UpdatesPublicado;
use Illuminate\Http\Request;
use App\Models\Subcomite;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DocumentoSubcomiteController extends Controller
{
    use UpdatesPublicado;

    public function __construct()
    {
        $this->middleware('permission:ver-doc-subcomite|crear-doc-subcomite|editar-doc-subcomite|borrar-doc-subcomite', ['only' => ['index']]);
        $this->middleware('permission:crear-doc-subcomite', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-doc-subcomite', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-doc-subcomite', ['only' => ['destroy']]);
    }

    /**
     * Muestra un listado paginado de los documentos de los subcomités, paginado cada 1000 registros.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DocumentoSubcomite::with('subcomite')
                ->orderBy('anio', 'desc')
                ->orderBy('created_at', 'desc')
                ->select('documentosSubcomites.*');

            return DataTables::of($data)
                ->addColumn('info', function ($row) {
                    $html = '<div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">' . e($row->nombre) . '</div>';
                    $html .= '<div class="d-flex flex-wrap gap-2 align-items-center">';
                    $html .= '<span class="text-muted fw-bold me-2 small"><i class="fa-regular fa-calendar me-1"></i>' . e($row->anio) . '</span>';
                    $html .= '<span class="badge bg-light text-dark border">' . e($row->tipo_documento) . '</span>';
                    if ($row->tipo_acta && $row->tipo_acta != 'No aplica') {
                        $html .= '<span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-integration"><i class="fa-solid fa-file-lines me-1"></i>' . e($row->tipo_acta) . '</span>';
                    }
                    $html .= '</div>';
                    return $html;
                })
                ->addColumn('documento', function ($row) {
                    return '<div class="text-center"><a href="' . asset('documentosubcomites/' . $row->ruta_documento) . '" target="_blank" title="Ver documento ' . e($row->nombre) . '"><i class="fa-solid fa-file-pdf fs-2"></i></a></div>';
                })
                ->addColumn('subcomite_nombre', function ($row) {
                    $html = '<small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.7rem;">Pertenece al:</small>';
                    $html .= '<span class="text-secondary">' . e($row->subcomite->nombre) . '</span>';
                    return $html;
                })
                ->addColumn('estado', function ($row) {
                    if (auth()->user()->can('editar-doc-subcomite')) {
                        $selectedPublicado = $row->publicado ? 'selected' : '';
                        $selectedBorrador = !$row->publicado ? 'selected' : '';
                        return '
                            <form action="' . route('update-publicado-documento-subcomite', $row->id) . '" method="POST">
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
                    if (auth()->user()->can('editar-doc-subcomite')) {
                        $btn .= '<a href="' . route('panel-documentos-subcomites.edit', $row->id) . '" class=""><button class="btn btn-outline-secondary" title="Editar elemento"><i class="fa-regular fa-pen-to-square"></i></button></a>';
                    }
                    if (auth()->user()->can('borrar-doc-subcomite')) {
                        $btn .= '
                            <form action="' . route('panel-documentos-subcomites.destroy', $row->id) . '" method="POST" class="formEliminar ms-1">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button class="btn btn-outline-danger" title="Eliminar elemento"><i class="fa-regular fa-trash-can"></i></button>
                            </form>';
                    }
                    $btn .= '</div></div>';
                    return $btn;
                })
                ->rawColumns(['info', 'documento', 'subcomite_nombre', 'estado', 'acciones'])
                ->make(true);
        }

        return view('panel-documentos-subcomites.index');
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
    protected function getModel()
    {
        return DocumentoSubcomite::class;
    }
}
