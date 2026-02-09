<?php

namespace App\Http\Controllers;

use App\Models\DocumentoApoyoCoplademun;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\UpdatesPublicado;

class DocumentoApoyoCoplademunController extends Controller
{
    use UpdatesPublicado;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentos = DocumentoApoyoCoplademun::orderBy('orden', 'asc')->get();
        return view('panel-documentos-apoyo-coplademun.index', compact('documentos'));
    }

    public function create()
    {
        $documento = new DocumentoApoyoCoplademun();
        $totalDocumentos = DocumentoApoyoCoplademun::count();
        $ordenesExistentes = DocumentoApoyoCoplademun::pluck('orden')->toArray();
        $ordenesDisponibles = range(1, $totalDocumentos + 1);
        return view('panel-documentos-apoyo-coplademun.form', compact('documento', 'ordenesExistentes', 'ordenesDisponibles'));
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
        ]);

        $documento = new DocumentoApoyoCoplademun();
        $documento->titulo = $request->titulo;
        $documento->orden = $request->orden;
        $documento->publicado = $request->publicado;

        $slug = Str::slug($request->titulo);

        if ($request->hasFile('ruta_documento')) {
            $documento->ruta_documento = $this->handleFileUpload($request->file('ruta_documento'), 'documentos/apoyo-coplademun/', $slug);
        }

        if ($request->hasFile('imagen')) {
            $documento->imagen = $this->handleFileUpload($request->file('imagen'), 'imagen/apoyo-coplademun/', 'Portada_de_' . $slug);
        }

        $documento->save();

        return redirect()->route('panel-documentos-apoyo-coplademun.index')->with('success', 'Documento creado exitosamente.');
    }

    public function edit($id)
    {
        $documento = DocumentoApoyoCoplademun::findOrFail($id);
        $totalDocumentos = DocumentoApoyoCoplademun::count();
        $ordenesExistentes = DocumentoApoyoCoplademun::pluck('orden')->toArray();
        $ordenesDisponibles = range(1, $totalDocumentos);
        return view('panel-documentos-apoyo-coplademun.form', compact('documento', 'ordenesExistentes', 'ordenesDisponibles'));
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
        ]);

        $documento = DocumentoApoyoCoplademun::findOrFail($id);
        $documento->titulo = $request->titulo;
        $documento->orden = $request->orden;
        $documento->publicado = $request->publicado;

        $slug = Str::slug($request->titulo);

        if ($request->hasFile('ruta_documento')) {
            $this->deleteFile('documentos/apoyo-coplademun/' . $documento->ruta_documento);
            $documento->ruta_documento = $this->handleFileUpload($request->file('ruta_documento'), 'documentos/apoyo-coplademun/', $slug);
        }

        if ($request->hasFile('imagen')) {
            $this->deleteFile('imagen/apoyo-coplademun/' . $documento->imagen);
            $documento->imagen = $this->handleFileUpload($request->file('imagen'), 'imagen/apoyo-coplademun/', 'Portada_de_' . $slug);
        }

        $documento->save();

        return redirect()->route('panel-documentos-apoyo-coplademun.index')->with('success', 'Documento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $documento = DocumentoApoyoCoplademun::findOrFail($id);
        
        $this->deleteFile('documentos/apoyo-coplademun/' . $documento->ruta_documento);
        $this->deleteFile('imagen/apoyo-coplademun/' . $documento->imagen);

        $documento->delete();

        return redirect()->route('panel-documentos-apoyo-coplademun.index')->with('success', 'Documento eliminado exitosamente.');
    }

    protected function getModel()
    {
        return DocumentoApoyoCoplademun::class;
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

    public function mostrarCoplademun(){
        $documentos = DocumentoApoyoCoplademun::where('publicado', true)->orderby('orden', 'asc')->get();

        return view('coplademun', compact('documentos'));
    }
}
