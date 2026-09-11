<?php
namespace App\Http\Controllers;

use App\Models\HerramientaPlaneacion;
use App\Models\HerramientaAnexo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\UpdatesPublicado;

class HerramientaPlaneacionController extends Controller
{
    use UpdatesPublicado;

    public function __construct()
    {
        $this->middleware('permission:ver-herramienta|crear-herramienta|editar-herramienta|borrar-herramienta', ['only' => ['index']]);
        $this->middleware('permission:crear-herramienta', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-herramienta', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-herramienta', ['only' => ['destroy', 'destroyAnexo']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $herramientas = HerramientaPlaneacion::withCount('anexos')->orderBy('orden', 'asc')->paginate(100);
        return view('panel-herramientas.index', compact('herramientas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $total = HerramientaPlaneacion::count();
        $ordenesDisponibles = range(1, $total + 1);
        $herramienta = new HerramientaPlaneacion();
        $ordenesExistentes = HerramientaPlaneacion::pluck('orden')->toArray();
        return view('panel-herramientas.form', compact('ordenesDisponibles', 'herramienta', 'ordenesExistentes'));
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
            'archivo' => 'required|file|mimes:pdf|max:10240',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:6144',
            'orden' => 'required|integer|min:1',
            'anexos.*.titulo' => 'nullable|string|max:255',
            'anexos.*.archivo' => 'nullable|file|mimes:pdf,zip,rar,doc,docx,xls,xlsx|max:10240',
        ]);

        $herramienta = new HerramientaPlaneacion();
        $herramienta->titulo = $request->titulo;
        $herramienta->descripcion = $request->descripcion;
        $herramienta->orden = $request->orden;
        $herramienta->publicado = $request->boolean('publicado');

        $slug = Str::limit(Str::slug($request->titulo), 70);

        if ($request->hasFile('archivo')) {
            $herramienta->archivo = $this->handleFileUpload($request->file('archivo'), 'documentos/herramientas/', $slug);
        }

        if ($request->hasFile('imagen')) {
            $herramienta->imagen = $this->handleFileUpload($request->file('imagen'), 'imagen/herramientas/', 'Portada_de_' . $slug);
        }

        $herramienta->save();

        if ($request->has('anexos')) {
            foreach ($request->anexos as $index => $anexoData) {
                if (isset($anexoData['archivo']) && $request->hasFile("anexos.$index.archivo")) {
                    $anexoFile = $request->file("anexos.$index.archivo");
                    $tituloAnexo = $anexoData['titulo'] ?? ('Anexo ' . ($index + 1));
                    $nombreAnexo = $this->handleFileUpload($anexoFile, 'documentos/herramientas/anexos/', Str::slug($tituloAnexo));

                    $herramienta->anexos()->create([
                        'titulo' => $tituloAnexo,
                        'archivo' => $nombreAnexo,
                        'orden' => $anexoData['orden'] ?? ($index + 1)
                    ]);
                }
            }
        }

        return redirect()->route('panel-herramientas.index', [], 303)
            ->with('success', 'Herramienta creada exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $herramienta = HerramientaPlaneacion::with('anexos')->findOrFail($id);
        $total = HerramientaPlaneacion::count();
        $ordenesDisponibles = range(1, $total);
        $ordenesExistentes = HerramientaPlaneacion::pluck('orden')->toArray();
        return view('panel-herramientas.form', compact('herramienta', 'ordenesDisponibles', 'ordenesExistentes'));
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
            'archivo' => 'nullable|file|mimes:pdf|max:10240',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:6144',
            'orden' => 'required|integer|min:1',
            'anexos.*.titulo' => 'nullable|string|max:255',
            'anexos.*.archivo' => 'nullable|file|mimes:pdf,zip,rar,doc,docx,xls,xlsx|max:10240',
        ]);

        $herramienta = HerramientaPlaneacion::findOrFail($id);
        $herramienta->titulo = $request->titulo;
        $herramienta->descripcion = $request->descripcion;
        $herramienta->orden = $request->orden;
        $herramienta->publicado = $request->boolean('publicado');

        $slug = Str::limit(Str::slug($request->titulo), 70);

        if ($request->hasFile('archivo')) {
            // Optional: delete old file
            $herramienta->archivo = $this->handleFileUpload($request->file('archivo'), 'documentos/herramientas/', $slug);
        }

        if ($request->hasFile('imagen')) {
            $herramienta->imagen = $this->handleFileUpload($request->file('imagen'), 'imagen/herramientas/', 'Portada_de_' . $slug);
        }

        $herramienta->save();

        // Handle Deletions
        if ($request->has('deleted_anexos')) {
            // Optimización: Cargar anexos a eliminar en una sola consulta
            $anexosAEliminar = HerramientaAnexo::whereIn('id', $request->deleted_anexos)->get();
            foreach ($anexosAEliminar as $anexo) {
                $this->deleteFile('documentos/herramientas/anexos/' . $anexo->archivo);
                $anexo->delete();
            }
        }

        // Handle Annexes (Updates & New)
        if ($request->has('anexos')) {
            // Optimización: Cargar anexos existentes en lote
            $ids = collect($request->anexos)->pluck('id')->filter()->toArray();
            $anexosExistentes = HerramientaAnexo::whereIn('id', $ids)->get()->keyBy('id');

            foreach ($request->anexos as $index => $anexoData) {
                $anexo = isset($anexoData['id']) ? $anexosExistentes->get($anexoData['id']) : null;

                if ($anexo) {
                    // Update existing
                    $anexo->titulo = $anexoData['titulo'];
                    $anexo->orden = $anexoData['orden'] ?? $anexo->orden;
                    
                    if ($request->hasFile("anexos.$index.archivo")) {
                        $this->deleteFile('documentos/herramientas/anexos/' . $anexo->archivo);
                        $anexo->archivo = $this->handleFileUpload($request->file("anexos.$index.archivo"), 'documentos/herramientas/anexos/', Str::slug($anexoData['titulo']));
                    }
                    $anexo->save();
                } else {
                    // Create new
                    if ($request->hasFile("anexos.$index.archivo")) {
                        $anexoFile = $request->file("anexos.$index.archivo");
                        $tituloAnexo = $anexoData['titulo'] ?? ('Anexo ' . ($index + 1));
                        $nombreAnexo = $this->handleFileUpload($anexoFile, 'documentos/herramientas/anexos/', Str::slug($tituloAnexo));

                        $herramienta->anexos()->create([
                            'titulo' => $tituloAnexo,
                            'archivo' => $nombreAnexo,
                            'orden' => $anexoData['orden'] ?? ($index + 1)
                        ]);
                    }
                }
            }
        }

        return redirect()->route('panel-herramientas.index', [], 303)
            ->with('success', 'Herramienta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $herramienta = HerramientaPlaneacion::findOrFail($id);
        
        // Delete files
        $this->deleteFile('documentos/herramientas/' . $herramienta->archivo);
        $this->deleteFile('imagen/herramientas/' . $herramienta->imagen);
        
        foreach($herramienta->anexos as $anexo) {
            $this->deleteFile('documentos/herramientas/anexos/' . $anexo->archivo);
        }

        $herramienta->delete();

        return redirect()->route('panel-herramientas.index')->with('success', 'Herramienta eliminada.');
    }

    public function destroyAnexo($id)
    {
        $anexo = HerramientaAnexo::findOrFail($id);
        $this->deleteFile('documentos/herramientas/anexos/' . $anexo->archivo);
        $anexo->delete();
        return back()->with('success', 'Anexo eliminado.');
    }

    public function mostrarHerramientas()
    {
        $herramientas = HerramientaPlaneacion::with('anexos')
            ->where('publicado', 1)
            ->orderBy('orden', 'asc')
            ->get();
        return view('herramientas-planeacion', compact('herramientas'));
    }

    protected function getModel()
    {
        return HerramientaPlaneacion::class;
    }

    private function handleFileUpload($file, $path, $prefix)
    {
        $directory = public_path($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $name = $prefix . '-' . Str::random(4) . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $name);
        return $name;
    }

    private function deleteFile($relative)
    {
        $full = public_path($relative);
        if (file_exists($full) && is_file($full)) {
            unlink($full);
        }
    }
}
