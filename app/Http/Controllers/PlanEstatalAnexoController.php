<?php

namespace App\Http\Controllers;

use App\Models\PlanEstatal;
use App\Models\PlanEstatalAnexo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\UpdatesPublicado;

class PlanEstatalAnexoController extends Controller
{
    use UpdatesPublicado;

    /**
     * Display a listing of the resource.
     *
     * @param int $planId
     * @return \Illuminate\View\View
     */
    public function index($planId)
    {
        $planEstatal = PlanEstatal::findOrFail($planId);
        $anexos = $planEstatal->anexos()->orderBy('orden', 'asc')->get();
        return view('panel-planes-estatales.anexos.index', compact('planEstatal', 'anexos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $planId
     * @return \Illuminate\View\View
     */
    public function create($planId)
    {
        $planEstatal = PlanEstatal::findOrFail($planId);
        $anexo = new PlanEstatalAnexo();
        $total = $planEstatal->anexos()->count();
        $ordenesDisponibles = range(1, $total + 1);
        $ordenesExistentes = $planEstatal->anexos()->pluck('orden')->toArray();
        return view('panel-planes-estatales.anexos.form', compact('planEstatal', 'anexo', 'ordenesDisponibles', 'ordenesExistentes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $planId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $planId)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'es_enlace' => 'required|boolean',
            'ruta_documento_archivo' => 'required_if:es_enlace,0|nullable|file|mimes:pdf|max:102400',
            'ruta_documento_enlace' => 'required_if:es_enlace,1|nullable|url|max:255',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:6144',
            'orden' => 'required|integer|min:1',
        ]);

        $planEstatal = PlanEstatal::findOrFail($planId);
        $anexo = new PlanEstatalAnexo();
        $anexo->plan_estatal_id = $planId;
        $anexo->titulo = $request->titulo;
        $anexo->es_enlace = $request->es_enlace;
        $anexo->orden = $request->orden;
        $anexo->publicado = $request->has('publicado');

        $slug = Str::slug($request->titulo);

        if ($request->es_enlace) {
            $anexo->ruta_documento = $request->ruta_documento_enlace;
        } else {
            if ($request->hasFile('ruta_documento_archivo')) {
                $archivo = $request->file('ruta_documento_archivo');
                $nombreArchivo = $slug . '-' . Str::random(4) . '.' . $archivo->getClientOriginalExtension();
                $archivo->move(public_path('documentos/planesest/anexos/'), $nombreArchivo);
                $anexo->ruta_documento = $nombreArchivo;
            }
        }

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = 'Anexo_' . $slug . '-' . Str::random(4) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('img/ped/anexos/'), $nombreImagen);
            $anexo->imagen = $nombreImagen;
        }

        $anexo->save();

        return redirect()->route('panel-planes-estatales-anexos.index', $planId)->with('success', 'Anexo creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $planId
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($planId, $id)
    {
        $planEstatal = PlanEstatal::findOrFail($planId);
        $anexo = PlanEstatalAnexo::findOrFail($id);
        $total = $planEstatal->anexos()->count();
        $ordenesDisponibles = range(1, $total);
        $ordenesExistentes = $planEstatal->anexos()->where('id', '!=', $id)->pluck('orden')->toArray();
        return view('panel-planes-estatales.anexos.form', compact('planEstatal', 'anexo', 'ordenesDisponibles', 'ordenesExistentes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $planId
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $planId, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'es_enlace' => 'required|boolean',
            'ruta_documento_archivo' => 'nullable|file|mimes:pdf|max:102400',
            'ruta_documento_enlace' => 'required_if:es_enlace,1|nullable|url|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:6144',
            'orden' => 'required|integer|min:1',
        ]);

        $anexo = PlanEstatalAnexo::findOrFail($id);
        $anexo->titulo = $request->titulo;
        $anexo->orden = $request->orden;
        $anexo->publicado = $request->has('publicado');

        $slug = Str::slug($request->titulo);

        // Manage file deletion if type changed or new file uploaded
        if ($request->es_enlace) {
            // If it was a file before, delete it
            if (!$anexo->es_enlace && $anexo->ruta_documento) {
                $this->deleteFile('documentos/planesest/anexos/' . $anexo->ruta_documento);
            }
            $anexo->ruta_documento = $request->ruta_documento_enlace;
            $anexo->es_enlace = true;
        } else {
            // If it was an enlace before, just clear it if we are uploading a new file or if it's strictly a file now
            if ($anexo->es_enlace) {
                $anexo->ruta_documento = null; // Clear URL
            }
            $anexo->es_enlace = false;

            if ($request->hasFile('ruta_documento_archivo')) {
                // Delete old file if existed
                if ($anexo->ruta_documento) {
                    $this->deleteFile('documentos/planesest/anexos/' . $anexo->ruta_documento);
                }
                $archivo = $request->file('ruta_documento_archivo');
                $nombreArchivo = $slug . '-' . Str::random(4) . '.' . $archivo->getClientOriginalExtension();
                $archivo->move(public_path('documentos/planesest/anexos/'), $nombreArchivo);
                $anexo->ruta_documento = $nombreArchivo;
            }
        }

        if ($request->hasFile('imagen')) {
            $this->deleteFile('img/ped/anexos/' . $anexo->imagen);
            $imagen = $request->file('imagen');
            $nombreImagen = 'Anexo_' . $slug . '-' . Str::random(4) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('img/ped/anexos/'), $nombreImagen);
            $anexo->imagen = $nombreImagen;
        }

        $anexo->save();

        return redirect()->route('panel-planes-estatales-anexos.index', $planId)->with('success', 'Anexo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $planId
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($planId, $id)
    {
        $anexo = PlanEstatalAnexo::findOrFail($id);
        $this->deleteFile('documentos/planesest/anexos/' . $anexo->ruta_documento);
        $this->deleteFile('img/ped/anexos/' . $anexo->imagen);
        $anexo->delete();

        return redirect()->route('panel-planes-estatales-anexos.index', $planId)->with('success', 'Anexo eliminado exitosamente.');
    }

    protected function getModel()
    {
        return PlanEstatalAnexo::class;
    }

    private function deleteFile($relative)
    {
        $full = public_path($relative);
        if (file_exists($full) && is_file($full)) {
            unlink($full);
        }
    }
}
