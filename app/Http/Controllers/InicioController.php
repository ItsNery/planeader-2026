<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\CatMunicipio;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InicioController extends Controller
{
    /**
     * Envia los banners que corresponde a la sección de «Inicio» a la vista principal del mismo nombre ordenados de manera ascendente por el campo orde y que esten activos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $banners = Banner::where('estado', 'Activo')
            ->where('seccion', 'Inicio')
            ->orderBy('orden', 'asc')
            ->get();
        return view('inicio', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     * Actualmente no se utiliza, pero se deja como parte de la estructura del controlador.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * Actualmente no se utiliza, pero se deja como parte de la estructura del controlador.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     * Actualmente no se utiliza, pero se deja como parte de la estructura del controlador.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * Actualmente no se utiliza, pero se deja como parte de la estructura del controlador.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * Actualmente no se utiliza, pero se deja como parte de la estructura del controlador.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Muestra la vista de regionalización con datos agrupados por microrregiones y macrorregiones.
     *
     * Este método consulta la tabla 'cat_municipios' para obtener información sobre
     * las diferentes regiones geográficas. Realiza tres consultas distintas:
     * 1. Una consulta principal que agrupa por microrregión y macrorregión para obtener
     * combinaciones únicas de ambas, manteniendo la relación entre ellas.
     * 2. Una consulta específica para listar todas las microrregiones únicas.
     * 3. Una consulta específica para listar todas las macrorregiones únicas.
     *
     * Los datos obtenidos son pasados a la vista 'regionalizacion' para su presentación.
     *
     * @return \Illuminate\View\View Retorna una vista ('regionalizacion') con las variables compactadas
     * 'regiones', 'microrregiones' y 'macrorregiones'.
     */
    public function regionalizacion()
    {
        $regiones = CatMunicipio::select('id_microrregion', 'nombre_microrregion', 'id_macrorregion', 'nombre_macrorregion',)
            ->groupBy('id_microrregion', 'nombre_microrregion', 'id_macrorregion', 'nombre_macrorregion',) // Agrupas por todas las columnas que seleccionas para obtener combinaciones únicas
            ->orderBy('id_microrregion', 'asc')
            ->get();
        $microrregiones = CatMunicipio::select('id_microrregion', 'nombre_microrregion')
            ->groupBy('id_microrregion', 'nombre_microrregion')
            ->orderBy('id_microrregion', 'asc')
            ->get();

        $macrorregiones = CatMunicipio::select('id_macrorregion', 'nombre_macrorregion')
            ->groupBy('id_macrorregion', 'nombre_macrorregion')
            ->orderBy('id_macrorregion', 'asc')
            ->get();

        return view('regionalizacion', compact('regiones', 'microrregiones', 'macrorregiones'));
    }

    /**
     * Obtiene información detallada (nombre y municipios) de una microrregión o macrorregión específica.
     *
     * Este método recibe el tipo de región ('Microrregiones' o 'Macrorregiones') y su ID.
     * Dinámicamente determina las columnas de la base de datos a consultar y busca la región.
     * Si la región existe, obtiene su nombre y todos los municipios asociados a ella,
     * ordenándolos alfabéticamente. En caso de no encontrar la región o de un tipo inválido,
     * devuelve una respuesta JSON con el error correspondiente y el código de estado HTTP adecuado.
     * También incluye manejo de excepciones para errores internos del servidor.
     *
     * @param  string  $tipo El tipo de región a consultar ('Microrregiones' o 'Macrorregiones').
     * @param  int  $id El ID numérico de la microrregión o macrorregión.
     * @return \Illuminate\Http\JsonResponse Retorna una respuesta JSON con el nombre de la región y la lista de municipios,
     * o un mensaje de error con el código de estado HTTP apropiado.
     */
    public function getInfoRegion($tipo, $id)
    {
        try {
            $nombreRegion = '';
            $municipios = [];
            $queryColumn = '';
            $nameColumn = '';

            if ($tipo === 'Microrregiones') {
                $queryColumn = 'id_microrregion';
                $nameColumn = 'nombre_microrregion';
            } elseif ($tipo === 'Macrorregiones') {
                $queryColumn = 'id_macrorregion';
                $nameColumn = 'nombre_macrorregion';
            } else {
                return response()->json(['error' => 'Tipo de región no válido.'], 400);
            }

            $region = CatMunicipio::where($queryColumn, $id)->first();

            if (!$region) {
                return response()->json(['error' => "No se encontró la región con el ID {$id} para el tipo {$tipo}."], 404);
            }

            $nombreRegion = $region->$nameColumn;
            $municipios = CatMunicipio::where($queryColumn, $id)->orderBy('nombre_municipio')->get(['nombre_municipio']);

            return response()->json([
                'nombre' => $nombreRegion,
                'municipios' => $municipios
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error interno en el servidor.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Proporciona datos de regionalización agrupados por microrregiones y macrorregiones en formato JSON.
     *
     * Este método es el equivalente API del método 'regionalizacion'.
     * Realiza tres consultas a la tabla 'cat_municipios' para obtener:
     * 1. Una lista de combinaciones únicas de microrregiones y macrorregiones (`regiones`).
     * 2. Una lista de todas las microrregiones únicas (`microrregiones`).
     * 3. Una lista de todas las macrorregiones únicas (`macrorregiones`).
     *
     * Todos los datos son devueltos como una única respuesta JSON.
     *
     * @return \Illuminate\Http\JsonResponse Retorna una respuesta JSON que contiene un array con
     * 'regiones', 'microrregiones' y 'macrorregiones'.
     */
    public function apiRegionalizacion(): JsonResponse
    {
        $regiones = CatMunicipio::select(
            'id_microrregion',
            'nombre_microrregion',
            'id_macrorregion',
            'nombre_macrorregion'
        )
            ->groupBy(
                'id_microrregion',
                'nombre_microrregion',
                'id_macrorregion',
                'nombre_macrorregion'
            )
            ->orderBy('id_microrregion', 'asc')
            ->get();

        $microrregiones = CatMunicipio::select('id_microrregion', 'nombre_microrregion')
            ->groupBy('id_microrregion', 'nombre_microrregion')
            ->orderBy('id_microrregion', 'asc')
            ->get();

        $macrorregiones = CatMunicipio::select('id_macrorregion', 'nombre_macrorregion')
            ->groupBy('id_macrorregion', 'nombre_macrorregion')
            ->orderBy('id_macrorregion', 'asc')
            ->get();

        return response()->json(compact('regiones', 'microrregiones', 'macrorregiones'));
    }
}
