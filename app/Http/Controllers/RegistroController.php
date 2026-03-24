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
    public function __construct()
    {
        $this->middleware('permission:ver-registro-capacitacion', ['only' => ['index']]);
    }

    /**
     * Muestra una lista paginada de registros de capacitación, divididos por rangos de fechas específicos.
     *
     * Este método recupera registros de capacitación para tres periodos de tiempo predefinidos en el año actual.
     * Cada periodo corresponde a un "día" de registro con horas de inicio y fin específicas.
     * Los registros se cargan con su relación 'catMunicipio' y se ordenan de forma descendente por su fecha de creación.
     * La vista 'registro-coplademun-listado' se renderiza con los registros de cada día y el año actual.
     *
     * @return \Illuminate\View\View Retorna la vista 'registro-coplademun-listado' con las siguientes variables:
     * - 'registrosDia1': Colección de registros del primer rango de fechas (18 de nov a 20 de mayo 3 PM).
     * - 'registrosDia2': Colección de registros del segundo rango de fechas (20 de mayo 5 PM a 21 de mayo 3 PM).
     * - 'registrosDia3': Colección de registros del tercer rango de fechas (21 de mayo 5 PM a 22 de mayo 3 PM).
     * - 'year': El año actual utilizado para definir los rangos de fechas.
     */
    public function index()
    {
        $year = Carbon::now()->year; // Esto tomará 2025 si estamos en 2025

        // --- DÍA 1: 18 de Nov, 8:30 AM - 3:00 PM ---
        // $fechaInicioDia1 = Carbon::create($year, 11, 18)->setHour(8)->setMinute(30)->setSecond(0);
        // $fechaFinDia1 = Carbon::create($year, 11, 18)->setHour(15)->setMinute(0)->setSecond(0);

        // Forma alternativa y un poco más limpia de crear las fechas:
        $fechaInicioDia1 = Carbon::create($year, 11, 18, 8, 30, 0);
        $fechaFinDia1 = Carbon::create($year, 11, 18, 15, 0, 0);

        $registrosDia1 = RegistroCapacitacion::with('catMunicipio')
            ->whereBetween('created_at', [$fechaInicioDia1, $fechaFinDia1])
            ->orderBy('created_at', 'desc')
            ->get();

        // --- DÍA 2: 19 de Nov, 8:30 AM - 3:00 PM ---
        $fechaInicioDia2 = Carbon::create($year, 11, 19, 8, 30, 0);
        $fechaFinDia2 = Carbon::create($year, 11, 19, 15, 0, 0);

        $registrosDia2 = RegistroCapacitacion::with('catMunicipio')
            ->whereBetween('created_at', [$fechaInicioDia2, $fechaFinDia2])
            ->orderBy('created_at', 'desc')
            ->get();

        $municipios = CatMunicipio::select('nombre_municipio')
            ->selectRaw('MIN(id) as id')
            ->groupBy('nombre_municipio')
            ->orderBy('nombre_municipio', 'asc')
            ->get();

        // --- El día 3 se elimina ---

        return view('registro-coplademun-listado', compact(
            'registrosDia1',
            'registrosDia2',
            'year',
            'municipios'
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

        // --- INICIO DE LA VALIDACIÓN DE HORARIO ---
        $now = Carbon::now();
        $year = $now->year;

        // Definir los periodos de registro permitidos
        $inicioDia1 = Carbon::create($year, 11, 18, 8, 30, 0);
        $finDia1    = Carbon::create($year, 11, 18, 15, 0, 0);
        $inicioDia2 = Carbon::create($year, 11, 19, 8, 30, 0);
        $finDia2    = Carbon::create($year, 11, 19, 15, 0, 0);

        // Comprobar si la hora actual está dentro de alguno de los periodos
        $enPeriodo1 = $now->between($inicioDia1, $finDia1);
        $enPeriodo2 = $now->between($inicioDia2, $finDia2);

        if (!($enPeriodo1 || $enPeriodo2)) {
            // Si no está en NINGUNO de los periodos, rechazamos el registro
            Log::warning('Intento de registro fuera de horario. Hora actual: ' . $now);
            return redirect()->route('registro.create')
                ->withErrors(['horario_error' => 'El registro solo está disponible el 18 y 19 de noviembre, de 8:30 AM a 3:00 PM.'])
                ->withInput();
        }
        // --- FIN DE LA VALIDACIÓN DE HORARIO ---

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
}
