<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EventoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-evento|crear-evento|editar-evento|borrar-evento', ['only' => ['index']]);
        $this->middleware('permission:crear-evento', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-evento', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-evento', ['only' => ['destroy']]);
    }
    /**
     * Muestra una lista de eventos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $eventos = Evento::orderBy('fecha_evento', 'desc')->orderBy('created_at', 'desc')->get();
        return view('panel-eventos.index', compact('eventos'));
    }

    /**
     * Muestra el formulario para crear un nuevo evento.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $event = new Evento();
        return view('panel-eventos.form', compact('event'));
    }

    /**
     * Almacena un nuevo evento en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'fecha_evento' => 'required|date',
            'icono_evento' => 'required|image|mimes:jpeg,png,svg,jpg|max:6144',
        ], [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.string' => 'El título debe ser una cadena de texto.',
            'titulo.max' => 'El título no puede tener más de 255 caracteres.',
            'fecha_evento.required' => 'La fecha del evento es obligatoria.',
            'fecha_evento.date' => 'La fecha del evento debe ser una fecha válida.',
            'icono_evento.required' => 'El ícono del evento es obligatorio.',
            'icono_evento.image' => 'El ícono debe ser una imagen.',
            'icono_evento.mimes' => 'El ícono debe ser de tipo: jpeg, png, svg, jpg.',
            'icono_evento.max' => 'El ícono no puede tener más de 6MB.',
        ]);

        if ($icono_evento = $request->file('icono_evento')) {
            $rutaGuardarImg = 'imagen-eventos/';
            $slug = Str::slug($request->titulo);
            $slugLimitado = Str::limit($slug, 30, '');
            $originalName = 'Icono-evento-' . $slugLimitado . date('YmdHis');
            $iconoEventoNombre = $originalName . '.' . $icono_evento->getClientOriginalExtension();
            $icono_evento->move($rutaGuardarImg, $iconoEventoNombre);
            $validatedData['icono_evento'] = "$iconoEventoNombre";
        }

        Evento::create($validatedData);
        return redirect()->route('panel-eventos.index')->with('success', 'Evento creado exitosamente.');
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
     * Muestra el formulario para editar un evento existente.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $event = Evento::findOrFail($id);
        return view('panel-eventos.form', compact('event'));
    }

    /**
     * Actualiza un evento existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'fecha_evento' => 'required|date',
            'icono_evento' => 'nullable|image|mimes:jpeg,png,svg,jpg|max:10240',
        ], [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.string' => 'El título debe ser una cadena de texto.',
            'titulo.max' => 'El título no puede tener más de 255 caracteres.',
            'fecha_evento.required' => 'La fecha del evento es obligatoria.',
            'fecha_evento.date' => 'La fecha del evento debe ser una fecha válida.',
            'icono_evento.image' => 'El ícono debe ser una imagen.',
            'icono_evento.mimes' => 'El ícono debe ser de tipo: jpeg, png, svg, jpg.',
            'icono_evento.max' => 'El ícono no puede tener más de 10MB.',
        ]);

        $event = Evento::find($id);
        $event->update($validatedData);

        if ($icono_evento = $request->file('icono_evento')) {
            $rutaGuardarImg = 'imagen-eventos/';
            $slug = Str::slug($request->titulo);
            $slugLimitado = Str::limit($slug, 30, '');
            $originalName = 'Icono-evento-' . $slugLimitado . date('YmdHis');
            $iconoEventoNombre = $originalName . '.' . $icono_evento->getClientOriginalExtension();
            $icono_evento->move($rutaGuardarImg, $iconoEventoNombre);

            if ($event->icono_evento && file_exists(public_path($rutaGuardarImg . $event->icono_evento))) {
                unlink(public_path($rutaGuardarImg . $event->icono_evento));
            }

            $event->icono_evento = $iconoEventoNombre;
            $event->save();
        }
        
        return redirect()->route('panel-eventos.index')->with('success', 'Evento actualizado exitosamente.');
    }

    /**
     * Elimina un evento y su ícono asociado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $event = Evento::find($id);

        if ($event->icono_evento) {
            $iconoPath = public_path('imagen-eventos/' . $event->icono_evento);
            if (file_exists($iconoPath)) {
                unlink($iconoPath);
            }
        }
        $event->delete();
        return redirect()->route('panel-eventos.index')->with('success', 'Evento eliminado exitosamente.');
    }
}
