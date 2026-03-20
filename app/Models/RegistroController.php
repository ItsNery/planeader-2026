<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatMunicipio;
use App\Models\RegistroCapacitacion; // Asegúrate de importar el modelo correcto
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Para trabajar con fechas
use Illuminate\Validation\Rule;

class RegistroController extends Controller
{
    /**
     * Muestra una lista paginada de registros de capacitación, divididos por rangos de fechas específicos.
     *
     * Este método recupera registros de capacitación para tres periodos de tiempo predefinidos en el año actual.
     * Cada periodo corresponde a un "día" de registro con horas de inicio y fin específicas.
     * Los registros se cargan con su relación 'catMunicipio' y se ordenan de forma descendente por su fecha de creación.
     * La vista 'registro-coplademun-listado' se renderiza con los registros de cada día y el año actual.
     *
     * @return \Illuminate\View\View Retorna la vista 'registro-coplademun-listado' con las siguientes variables:
     * - 'registrosDia1': Colección de registros del primer rango de fechas (16 de mayo a 20 de mayo 3 PM).
     * - 'registrosDia2': Colección de registros del segundo rango de fechas (20 de mayo 5 PM a 21 de mayo 3 PM).
     * - 'registrosDia3': Colección de registros del tercer rango de fechas (21 de mayo 5 PM a 22 de mayo 3 PM).
     * - 'year': El año actual utilizado para definir los rangos de fechas.
     */ 
    public function index()
    {
        $year = Carbon::now()->year;

        $fechaInicioDia1 = Carbon::createFromDate($year, 5, 16)->startOfDay();
        $fechaFinDia1 = Carbon::createFromDate($year, 5, 20)->setHour(15)->setMinute(0)->setSecond(0);

        $registrosDia1 = RegistroCapacitacion::with('catMunicipio')
            ->whereBetween('created_at', [$fechaInicioDia1, $fechaFinDia1])
            ->orderBy('created_at', 'desc')
            ->get();

        $fechaInicioDia2 = Carbon::createFromDate($year, 5, 20)->setHour(17)->setMinute(0)->setSecond(0);
        $fechaFinDia2 = Carbon::createFromDate($year, 5, 21)->setHour(15)->setMinute(0)->setSecond(0);

        $registrosDia2 = RegistroCapacitacion::with('catMunicipio')
            ->whereBetween('created_at', [$fechaInicioDia2, $fechaFinDia2])
            ->orderBy('created_at', 'desc')
            ->get();

        $fechaInicioDia3 = Carbon::createFromDate($year, 5, 21)->setHour(17)->setMinute(0)->setSecond(0);
        $fechaFinDia3 = Carbon::createFromDate($year, 5, 22)->setHour(15)->setMinute(0)->setSecond(0);

        $registrosDia3 = RegistroCapacitacion::with('catMunicipio')
            ->whereBetween('created_at', [$fechaInicioDia3, $fechaFinDia3])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('registro-coplademun-listado', compact(
            'registrosDia1',
            'registrosDia2',
            'registrosDia3',
            'year'
        ));
    }

    /**
     * Muestra el formulario para subir un nuevo registro a la capacitacion.
     *
     * Pre-carga los datos necesarios para los selectores del formulario.
     * (municipios)
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $municipios = CatMunicipio::select('nombre_municipio')
            ->selectRaw('MIN(id) as id')
            ->groupBy('nombre_municipio')
            ->orderBy('nombre_municipio', 'asc')
            ->get();

        return view('registro-coplademun', compact('municipios'));
    }

    /**
     * Procesa y almacena un nuevo registro para un programa de capacitación municipal.
     *
     * Este método valida los datos de la solicitud de un formulario de registro,
     * incluyendo información personal, de contacto y de ubicación (municipio).
     * Utiliza validación manual con mensajes personalizados y logging para el seguimiento.
     * Si la validación es exitosa, intenta crear un nuevo registro en la base de datos.
     * En caso de éxito, redirige al usuario a la página de registro con un mensaje de éxito.
     * Si la validación falla o ocurre un error durante el almacenamiento,
     * redirige de vuelta con los errores o un mensaje de error genérico.
     *
     * @param  \Illuminate\Http\Request  $request La instancia de la solicitud HTTP con los datos del formulario.
     * @return \Illuminate\Http\RedirectResponse Redirige al usuario a la página de registro con un mensaje de éxito
     * o con errores de validación/base de datos.
     */
    public function store(Request $request)
    {
        Log::info('Inicio del método store para registro de capacitación.');
        Log::debug('Datos recibidos en la solicitud:', $request->all());

        $rules = [
            'nombre_completo' => 'required|string|max:255',
            'sexo' => 'required|string|in:Hombre,Mujer,Otro',
            'cargo' => 'required|string|max:255',
            'municipio_id' => 'required|integer|exists:cat_municipios,id',
            'correo_electronico' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'telefono_oficina' => 'required|string|max:20|regex:/^[0-9\s\-\+\(\)]*$/',
            'telefono_celular' => 'required|string|max:20|regex:/^[0-9\s\-\+\(\)]*$/',
        ];
        Log::debug('Reglas de validación definidas:', $rules);

        $messages = [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'sexo.required' => 'Debe seleccionar un sexo.',
            'sexo.in' => 'El valor seleccionado para el sexo no es válido.',
            'cargo.required' => 'El cargo es obligatorio.',
            'municipio_id.required' => 'Debe seleccionar un municipio.',
            'municipio_id.integer' => 'El municipio seleccionado no es válido.',
            'municipio_id.exists' => 'El municipio seleccionado no existe en nuestro catálogo.',
            'correo_electronico.required' => 'El correo electrónico es obligatorio.',
            'correo_electronico.email' => 'El formato del correo electrónico no es válido.',
            // 'correo_electronico.unique' => 'Este correo electrónico ya ha sido registrado hoy.',
            'telefono_oficina.regex' => 'El formato del teléfono de oficina no es válido.',
            'telefono_oficina.required' => 'Es necesario un número de teléfono de oficina.',
            'telefono_celular.required' => 'Es necesario un número de teléfono celular.',
            'telefono_celular.regex' => 'El formato del teléfono celular no es válido.',
        ];
        Log::debug('Mensajes de error personalizados definidos.');

        Log::info('Realizando la validación de los datos.');
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            Log::warning('La validación falló.', $validator->errors()->toArray());
            return redirect()->route('registro.create')
                ->withErrors($validator)
                ->withInput();
        }

        Log::info('Validación exitosa.');

        try {
            $validatedData = $validator->validated();
            Log::info('Intentando crear el registro de capacitación con los siguientes datos validados:', $validatedData);

            $registro = RegistroCapacitacion::create($validatedData);

            Log::info('Registro de capacitación creado exitosamente. ID: ' . $registro->id);

            return redirect()->route('registro.create')
                ->with('success', '¡Te has registrado exitosamente al Programa de Capacitación Municipal!');
        } catch (\Exception $e) {
            Log::error('Error al guardar el registro de capacitación: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);

            return redirect()->route('registro.create')
                ->withErrors(['db_error' => 'Ocurrió un error inesperado al procesar tu registro. Por favor, inténtalo de nuevo más tarde o contacta al administrador.'])
                ->withInput();
        }
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
}
