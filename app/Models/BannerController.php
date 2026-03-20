<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BannerController extends Controller
{
    /**
     * Muestra un listado paginado de los banners.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $banners = Banner::paginate(1000);
        return view('panel-banners.index', compact('banners'));
    }

    /**
     * Muestra el formulario para crear un nuevo banner.
     *
     * Pre-carga los datos necesarios para los selectores del formulario
     * (secciones, estados, órdenes disponibles).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $secciones = ['Inicio', 'COPLADEP', 'Programas Derivados', 'Plan Estatal'];
        $estado_banner = ['Activo', 'Inactivo', 'Pendiente'];
        $totalBanners = Banner::count();
        $ordenesExistentes = Banner::pluck('orden')->toArray();
        $ordenesDisponibles = range(1, $totalBanners + 2);
        return view('panel-banners.crear', compact('estado_banner', 'secciones', 'ordenesDisponibles', 'ordenesExistentes'));
    }

    /**
     * Valida y almacena un nuevo banner en la base de datos.
     *
     * Gestiona la subida y el almacenamiento del archivo de imagen asociado.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con los datos del nuevo banner.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|max:60',
            'descripcion' => 'required|max:120',
            'enlace' => 'required',
            'imagen' => 'required|image|mimes:jpeg,png,svg,jpg|max:6144',
            'seccion' => 'required',
            'estado' => 'required',
            'orden' => 'required|integer',
        ], [
            'nombre.required' => 'El nombre del banner es requerido',
            'nombre.max' => 'El nombre del banner no puede tener más de 60 caracteres',

            'descripcion.required' => 'Se requiere una descripcion del banner',
            'descripcion.max' => 'La descripción del banner no puede tener más de 120 caracteres',

            'enlace.required' => 'Se requiere un enlace a donde  redirigirá el banner, si no se tiene coloque "#"',

            'imagen.required' => 'Se requiere la imagen',
            'imagen.image' => 'El archivo no es una imagen',
            'imagen.mimes' => 'El archivo no es una imagen',
            'imagen.max' => 'La imagen no debe pesar mas de 6MB',

            'seccion.required' => 'Se requiere una sección donde se mostrará',

            'estado.required' => 'Falta seleccionar el estado',

            'orden.required' => 'El orden es obligatorio.',
            'orden.integer' => 'El orden debe ser un número entero.',
        ]);

        $banners = $request->all();

        if ($imagen = $request->file('imagen')) {
            $rutaGuardarImg = 'baners/';
            $nombreBanner = Str::slug($request->input('nombre')) . date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $imagen->move(public_path($rutaGuardarImg), $nombreBanner);
            $banners['imagen'] = $nombreBanner;
        }

        Banner::create($banners);
        return redirect()->route('panel-banners.index')->with('success', 'Banner subido exitosamente.');
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
     * Muestra el formulario para editar un banner existente.
     *
     * Carga los datos del banner a editar y la información necesaria
     * para los selectores del formulario.
     *
     * @param  int  $id El ID del banner a editar.
     * @return \Illuminate\View\View
     */

    public function edit($id)
    {
        $estados_banner = ['Activo', 'Inactivo', 'Pendiente'];
        $secciones = ['Inicio', 'COPLADEP', 'Programas Derivados', 'Plan Estatal'];
        $banner = Banner::findOrFail($id);
        $seccion_banner = $banner->seccion;
        $totalBanners = Banner::where('seccion', '=', $seccion_banner)->count();
        $ordenesExistentes = Banner::pluck('orden')->toArray();
        $ordenesDisponibles = range(1, $totalBanners + 1);
        return view('panel-banners.editar', compact('banner', 'estados_banner', 'secciones', 'ordenesExistentes', 'ordenesDisponibles'));
    }

    /**
     * Valida y actualiza un banner existente en la base de datos.
     *
     * Gestiona la actualización de la imagen, eliminando la anterior si se sube una nueva.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud con los datos actualizados.
     * @param  int  $id El ID del banner a actualizar.
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'descripcion' => 'required',
            'enlace' => 'required',
            'imagen' => 'nullable|image|mimes:jpeg,png,svg,jpg|max:6144',
            'seccion' => 'required',
            'estado' => 'required',
            'orden' => 'required|integer',
        ], [
            'nombre.required' => 'El nombre del banner es requerido',

            'descripcion.required' => 'Se requiere una descripcion del banner',

            'enlace.required' => 'Se requiere un enlace a donde  redirigirá el banner, si no se tiene coloque "#"',

            'imagen.image' => 'El archivo no es una imagen',
            'imagen.mimes' => 'El archivo no es una imagen',
            'imagen.max' => 'La imagen no debe pesar mas de 6MB',

            'seccion.required' => 'Se requiere una sección donde se mostrará',
            'estado.required' => 'Falta seleccionar el estado',

            'orden.required' => 'El orden es obligatorio.',
            'orden.integer' => 'El orden debe ser un número entero.',
        ]);

        $banners = Banner::findOrFail($id);

        $banners->nombre = $request->nombre;
        $banners->descripcion = $request->descripcion;
        $banners->enlace = $request->enlace;
        $banners->estado = $request->estado;
        $banners->seccion = $request->seccion;
        $banners->orden = $request->orden;

        if ($request->hasFile('imagen')) {
            if ($banners->imagen) {
                unlink(public_path('baners/') . $banners->imagen);
            }
            $imagen = $request->file('imagen');
            $nombre_archivo_banner = Str::slug($request->input('nombre')) . date('YmdHis') . '.' . $imagen->getClientOriginalExtension();
            $imagen->move(public_path('baners/'), $nombre_archivo_banner);
            $banners->imagen = $nombre_archivo_banner;
        }
        
        $banners->save();

        return redirect()->route('panel-banners.index')->with('success', 'Banner actualizado exitosamente.');
    }

    /**
     * Elimina un banner de la base de datos y su archivo de imagen asociado.
     *
     * @param  int  $id El ID del banner a eliminar.
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        $rutaImagen = public_path('baners/') . $banner->imagen;

        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }

        $banner->delete();

        return redirect()->route('panel-banners.index')->with('success', 'Banner eliminado exitosamente.');
    }
}
