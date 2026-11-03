<?php

namespace App\Http\Controllers;

use App\Models\DocumentoSesion;
use App\Models\SesionCopladep;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\UpdatesPublicado;

class DocumentoSesionController extends Controller
{
    use UpdatesPublicado;

    public function __construct()
    {
        $this->middleware('permission:ver-doc-sesion|crear-doc-sesion|editar-doc-sesion|borrar-doc-sesion', ['only' => ['index']]);
        $this->middleware('permission:crear-doc-sesion', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-doc-sesion', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-doc-sesion', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentos = DocumentoSesion::orderBy('sesion', 'desc')->orderBy('orden', 'asc')->get();
        return view('panel-documentos-sesiones.index', compact('documentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $documento = new DocumentoSesion();
        $totalDocumentos = DocumentoSesion::count();
        $ordenesExistentes = DocumentoSesion::pluck('orden')->toArray();
        $ordenesDisponibles = range(1, $totalDocumentos + 2);
        return view('panel-documentos-sesiones.form', compact('documento', 'ordenesExistentes', 'ordenesDisponibles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ruta_documento' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:51200',
            'portada' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:6144',
            'orden' => 'required|integer|min:1',
            'sesion' => 'required|string|max:255',
            'publicado' => 'nullable|boolean'
        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'ruta_documento.required' => 'No ha elegido un archivo permitido',
            'ruta_documento.mimes' => 'El archivo debe ser PDF, DOC, DOCX, PPT o PPTX',
            'ruta_documento.max' => 'El archivo no puede pesar más de 50 MB',
            'portada.image' => 'La portada debe ser una imagen',
            'portada.mimes' => 'La portada debe ser JPEG, PNG, JPG, SVG o WEBP',
            'portada.max' => 'La portada no puede pesar más de 6 MB',
            'orden.required' => 'El orden es requerido',
            'sesion.required' => 'La sesión es requerida',
        ]);

        $documento = new DocumentoSesion();
        $documento->nombre = $request->nombre;
        $documento->orden = $request->orden;
        $documento->sesion = $request->sesion;
        $documento->publicado = $request->has('publicado') ? (bool)$request->input('publicado') : false;

        $slug = Str::slug($request->nombre);

        if ($request->hasFile('ruta_documento')) {
            $documento->ruta_documento = $this->handleFileUpload($request->file('ruta_documento'), 'documentos/sesiones/', $slug);
        }

        if ($request->hasFile('portada')) {
            $documento->portada = $this->handleFileUpload($request->file('portada'), 'imagen/sesiones/', 'Portada_de_' . $slug);
        }

        $documento->save();

        return redirect()->route('panel-documentos-sesiones.index')->with('success', 'Documento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $documento = DocumentoSesion::findOrFail($id);
        $totalDocumentos = DocumentoSesion::count();
        $ordenesExistentes = DocumentoSesion::pluck('orden')->toArray();
        $ordenesDisponibles = range(1, $totalDocumentos);
        return view('panel-documentos-sesiones.form', compact('documento', 'ordenesExistentes', 'ordenesDisponibles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ruta_documento' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,webp,jpg,jpeg,png,svg|max:51200',
            'portada' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:6144',
            'orden' => 'required|integer|min:1',
            'sesion' => 'required|string|max:255',
            'publicado' => 'nullable|boolean'
        ], [
            'nombre.required' => 'El nombre del documento es requerido',
            'ruta_documento.mimes' => 'El archivo debe ser PDF, DOC, DOCX, PPT o PPTX',
            'ruta_documento.max' => 'El archivo no puede pesar más de 50 MB',
            'portada.image' => 'La portada debe ser una imagen',
            'portada.mimes' => 'La portada debe ser JPEG, PNG, JPG, SVG o WEBP',
            'portada.max' => 'La portada no puede pesar más de 6 MB',
            'orden.required' => 'El orden es requerido',
            'sesion.required' => 'La sesión es requerida',
        ]);

        $documento = DocumentoSesion::findOrFail($id);
        $documento->nombre = $request->nombre;
        $documento->orden = $request->orden;
        $documento->sesion = $request->sesion;
        $documento->publicado = $request->has('publicado') ? (bool)$request->input('publicado') : false;

        $slug = Str::slug($request->nombre);

        if ($request->hasFile('ruta_documento')) {
            $this->deleteFile('documentos/sesiones/' . $documento->ruta_documento);
            $documento->ruta_documento = $this->handleFileUpload($request->file('ruta_documento'), 'documentos/sesiones/', $slug);
        }

        if ($request->hasFile('portada')) {
            $this->deleteFile('imagen/sesiones/' . $documento->portada);
            $documento->portada = $this->handleFileUpload($request->file('portada'), 'imagen/sesiones/', 'Portada_de_' . $slug);
        }

        $documento->save();

        return redirect()->route('panel-documentos-sesiones.index')->with('success', 'Documento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $documento = DocumentoSesion::findOrFail($id);

        $this->deleteFile('documentos/sesiones/' . $documento->ruta_documento);
        $this->deleteFile('imagen/sesiones/' . $documento->portada);

        $documento->delete();

        return redirect()->route('panel-documentos-sesiones.index')->with('success', 'Documento eliminado exitosamente.');
    }

    /**
     * Vista pública: muestra los documentos publicados de la primera sesión ordinaria.
     */
    public function mostrarPrimeraSesion()
    {
        $documentos = DocumentoSesion::where('publicado', true)
            ->orderBy('orden', 'asc')
            ->get();

        return view('copladep-primera', compact('documentos'));
    }

    public function mostrarSegundaSesion()
    {
        $documentos = DocumentoSesion::where('publicado', true)
            ->orderBy('orden', 'asc')
            ->get();

        $sesion = SesionCopladep::where('clave', '2026-segunda-ordinaria')->first();

        return view('copladep-segunda', compact('documentos', 'sesion'));
    }

    public function mostrarSegundaSesionVirtual()
    {
        $documentos = DocumentoSesion::where('publicado', true)
            ->orderBy('orden', 'asc')
            ->get();

        $sesion = SesionCopladep::where('clave', '2026-segunda-ordinaria')->first();

        return view('copladep-segunda', compact('documentos', 'sesion'))->with('modalidadEvento', 'virtual');
    }

    protected function getModel()
    {
        return DocumentoSesion::class;
    }

    private function handleFileUpload($file, $path, $prefix)
    {
        $name = $prefix . '-' . Str::random(4) . '.' . $file->getClientOriginalExtension();
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
}
