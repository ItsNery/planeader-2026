<?php
// local
namespace App\Http\Controllers;

use App\Models\DocumentoMetodologico;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\UpdatesPublicado;

class DocumentoMetodologicoController extends Controller
{
    use UpdatesPublicado;

    public function __construct()
    {
        $this->middleware('permission:ver-doc-metodologico|crear-doc-metodologico|editar-doc-metodologico|borrar-doc-metodologico', ['only' => ['index']]);
        $this->middleware('permission:crear-doc-metodologico', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-doc-metodologico', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-doc-metodologico', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentos = DocumentoMetodologico::orderBy('orden', 'asc')->get();
        return view('panel-documentos-metodologicos.index', compact('documentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $documento = new DocumentoMetodologico();
        $totalDocumentos = DocumentoMetodologico::count();
        $ordenesExistentes = DocumentoMetodologico::pluck('orden')->toArray();
        $ordenesDisponibles = range(1, $totalDocumentos + 1);
        return view('panel-documentos-metodologicos.form', compact('documento', 'ordenesExistentes', 'ordenesDisponibles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
            'titulo' => 'required|string|max:255',
            'ruta_documento' => 'required|file|mimes:pdf,doc,docx|max:51200',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:6144',
            'orden' => 'required|integer|min:1',
            'publicado' => 'nullable|boolean'
        ]);

        $documento = new DocumentoMetodologico();
        $documento->titulo = $request->titulo;
        $documento->orden = $request->orden;
        $documento->publicado = $request->publicado;

        $slug = Str::slug($request->titulo);

        if ($request->hasFile('ruta_documento')) {
            $documento->ruta_documento = $this->handleFileUpload($request->file('ruta_documento'), 'documentos/metodologicos/', $slug);
        }

        if ($request->hasFile('imagen')) {
            $documento->imagen = $this->handleFileUpload($request->file('imagen'), 'imagen/metodologicos/', 'Portada_de_' . $slug);
        }

        $documento->save();

        return redirect()->route('panel-documentos-metodologicos.index')->with('success', 'Documento creado exitosamente.');
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
        $documento = DocumentoMetodologico::findOrFail($id);
        $totalDocumentos = DocumentoMetodologico::count();
        $ordenesExistentes = DocumentoMetodologico::pluck('orden')->toArray();
        $ordenesDisponibles = range(1, $totalDocumentos);
        return view('panel-documentos-metodologicos.form', compact('documento', 'ordenesExistentes', 'ordenesDisponibles'));
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
         $request->validate([
            'titulo' => 'required|string|max:255',
            'ruta_documento' => 'nullable|file|mimes:pdf,doc,docx|max:51200',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:6144',
            'orden' => 'required|integer|min:1',
            'publicado' => 'nullable|boolean'
        ]);

        $documento = DocumentoMetodologico::findOrFail($id);
        $documento->titulo = $request->titulo;
        $documento->orden = $request->orden;
        $documento->publicado = $request->publicado;

        $slug = Str::slug($request->titulo);

        if ($request->hasFile('ruta_documento')) {
            $this->deleteFile('documentos/metodologicos/' . $documento->ruta_documento);
            $documento->ruta_documento = $this->handleFileUpload($request->file('ruta_documento'), 'documentos/metodologicos/', $slug);
        }

        if ($request->hasFile('imagen')) {
            $this->deleteFile('imagen/metodologicos/' . $documento->imagen);
            $documento->imagen = $this->handleFileUpload($request->file('imagen'), 'imagen/metodologicos/', 'Portada_de_' . $slug);
        }

        $documento->save();

        return redirect()->route('panel-documentos-metodologicos.index')->with('success', 'Documento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
                $documento = DocumentoMetodologico::findOrFail($id);
        
        $this->deleteFile('documentos/metodologicos/' . $documento->ruta_documento);
        $this->deleteFile('imagen/metodologicos/' . $documento->imagen);

        $documento->delete();

        return redirect()->route('panel-documentos-metodologicos.index')->with('success', 'Documento eliminado exitosamente.');
    }

    protected function getModel()
    {
        return DocumentoMetodologico::class;
    }

    private function handleFileUpload($file, $path, $prefix)
    {
        $name = $prefix . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($path), $name);
        return $name;
    }

    private function deleteFile($relative)
    {
        if (!$relative) return;
        $full = public_path($relative);
        if (file_exists($full) && is_file($full)) {
            unlink($full);
        }
    }

        public function mostrarMetodologicos(){
        $documentos = DocumentoMetodologico::where('publicado', true)->orderby('orden', 'asc')->get();

        return view('documentos-metodologicos', compact('documentos'));
    }
}
