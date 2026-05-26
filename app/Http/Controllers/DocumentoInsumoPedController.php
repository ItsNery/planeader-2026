<?php

namespace App\Http\Controllers;

use App\Models\DocumentoInsumoPed;
use App\Models\PlanEstatal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentoInsumoPedController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-documento-insumo-ped|crear-documento-insumo-ped|editar-documento-insumo-ped|borrar-documento-insumo-ped', ['only' => ['index']]);
        $this->middleware('permission:crear-documento-insumo-ped', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-documento-insumo-ped', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-documento-insumo-ped', ['only' => ['destroy']]);
    }

    /**
     * Muestra un listado paginado de los documentos de insumos del PED.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $documentos = DocumentoInsumoPed::all();
        return view('panel-documentos-insumo-ped.index', compact('documentos'));
    }

    /**
     * Muestra el formulario para crear un nuevo documento de insumo.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $planesEstatales = PlanEstatal::all();
        return view('panel-documentos-insumo-ped.form', compact('planesEstatales'));
    }

    /**
     * Valida y almacena un nuevo documento de insumo en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'plan_estatal_id' => 'required|exists:plan_estatals,id',
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|in:arbol-problemas,fichas-indicadores',
            'ruta_documento' => 'required|file|mimes:pdf,xls,xlsx|max:102400',
            'publicado' => 'nullable|boolean',
        ], [
            'plan_estatal_id.required' => 'El Plan Estatal es obligatorio.',
            'plan_estatal_id.exists' => 'El Plan Estatal seleccionado no es válido.',
            'titulo.required' => 'El título del documento es requerido',
            'titulo.string' => 'El título debe ser texto.',
            'titulo.max' => 'El título no debe contener más de :max caracteres.',

            'tipo.required' => 'El tipo de documento es obligatorio.',
            'tipo.in' => 'El tipo de documento debe ser Árbol de problemas o Fichas de indicadores.',

            'ruta_documento.required' => 'Debes seleccionar un archivo para el documento.',
            'ruta_documento.file' => 'El campo documento debe ser un archivo válido.',
            'ruta_documento.mimes' => 'El archivo debe ser PDF o Excel (XLS, XLSX).',
            'ruta_documento.max' => 'El tamaño del documento no debe superar los 100 MB.',

            'publicado.boolean' => 'El estado solo puede ser publicado o no publicado',
        ]);

        $datosDocumento = $request->all();

        if ($archivo = $request->file('ruta_documento')) {
            $rutaGuardar = 'insumos-ped/';
            $nombreOriginal = $request->input('titulo');
            $nombreArchivo = Str::slug($nombreOriginal) . '-' . Str::random(4) . "." . $archivo->getClientOriginalExtension();
            
            // Guardar formato automáticamente según extensión del archivo
            $extensión = strtolower($archivo->getClientOriginalExtension());
            $datosDocumento['formato'] = in_array($extensión, ['xls', 'xlsx']) ? 'excel' : 'pdf';
            
            $archivo->move(public_path($rutaGuardar), $nombreArchivo);
            $datosDocumento['ruta_documento'] = $nombreArchivo;
        }

        DocumentoInsumoPed::create($datosDocumento);
        return redirect()->route('panel-documentos-insumo-ped.index')->with('success', 'Documento subido exitosamente.');
    }

    /**
     * Muestra el formulario para editar un documento existente.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $documento = DocumentoInsumoPed::findOrFail($id);
        $planesEstatales = PlanEstatal::all();
        return view('panel-documentos-insumo-ped.form', compact('documento', 'planesEstatales'));
    }

    /**
     * Valida y actualiza un documento existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'plan_estatal_id' => 'required|exists:plan_estatals,id',
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|in:arbol-problemas,fichas-indicadores',
            'ruta_documento' => 'nullable|file|mimes:pdf,xls,xlsx|max:102400',
            'publicado' => 'nullable|boolean',
        ], [
            'plan_estatal_id.required' => 'El Plan Estatal es obligatorio.',
            'plan_estatal_id.exists' => 'El Plan Estatal seleccionado no es válido.',
            'titulo.required' => 'El título del documento es requerido',
            'titulo.string' => 'El título debe ser texto.',
            'titulo.max' => 'El título no debe contener más de :max caracteres.',

            'tipo.required' => 'El tipo de documento es obligatorio.',
            'tipo.in' => 'El tipo de documento debe ser Árbol de problemas o Fichas de indicadores.',

            'ruta_documento.file' => 'El campo documento debe ser un archivo válido.',
            'ruta_documento.mimes' => 'El archivo debe ser PDF o Excel (XLS, XLSX).',
            'ruta_documento.max' => 'El tamaño del documento no debe superar los 100 MB.',

            'publicado.boolean' => 'El estado solo puede ser publicado o no publicado',
        ]);

        $documento = DocumentoInsumoPed::findOrFail($id);

        $documento->plan_estatal_id = $request->plan_estatal_id;
        $documento->titulo = $request->titulo;
        $documento->tipo = $request->tipo;

        if ($request->hasFile('ruta_documento')) {
            if ($documento->ruta_documento) {
                $rutaAnterior = public_path('insumos-ped/') . $documento->ruta_documento;
                if (file_exists($rutaAnterior)) {
                    unlink($rutaAnterior);
                }
            }

            $archivo = $request->file('ruta_documento');
            $nombreArchivo = Str::slug($request->input('titulo')) . '-' . Str::random(4) . '.' . $archivo->getClientOriginalExtension();
            
            // Guardar formato automáticamente según extensión del archivo
            $extensión = strtolower($archivo->getClientOriginalExtension());
            $documento->formato = in_array($extensión, ['xls', 'xlsx']) ? 'excel' : 'pdf';
            
            $archivo->move(public_path('insumos-ped/'), $nombreArchivo);
            $documento->ruta_documento = $nombreArchivo;
        }

        if ($request->has('publicado')) {
            $documento->publicado = $request->publicado;
        }

        $documento->save();

        return redirect()->route('panel-documentos-insumo-ped.index')->with('success', 'Documento actualizado exitosamente.');
    }

    /**
     * Elimina un documento de la base de datos y su archivo asociado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $documento = DocumentoInsumoPed::findOrFail($id);

        $rutaArchivo = public_path('insumos-ped/') . $documento->ruta_documento;

        if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
        }

        $documento->delete();

        return redirect()->route('panel-documentos-insumo-ped.index')->with('success', 'Documento eliminado exitosamente.');
    }

    /**
     * Obtiene los documentos públicos de insumos agrupados por tipo (para vista pública).
     *
     * @return \Illuminate\View\View
     */
    public function insumos()
    {
        $arbolesProblemas = DocumentoInsumoPed::where('tipo', 'arbol-problemas')
            ->where('publicado', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $fichasIndicadores = DocumentoInsumoPed::where('tipo', 'fichas-indicadores')
            ->where('publicado', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('insumos-ped', compact('arbolesProblemas', 'fichasIndicadores'));
    }

    /**
     * Actualiza el estado de publicación de un documento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePublicado(Request $request, $id)
    {
        $request->validate([
            'publicado' => 'required|boolean',
        ]);

        $documento = DocumentoInsumoPed::findOrFail($id);
        $documento->publicado = $request->input('publicado');
        $documento->save();

        return redirect()->back()->with('success', 'Estado de publicación actualizado');
    }
}
