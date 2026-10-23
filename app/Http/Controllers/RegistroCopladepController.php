<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatMunicipio;
use App\Models\InvitadoCopladep;
use App\Models\RegistroCopladep;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RegistroCopladepController extends Controller
{
    private array $configSesiones = [
        'primera' => [
            'nombre'        => 'Primera Sesión Ordinaria 2026',
            'inicio'        => ['2026-03-26 08:30:00', 'Y-m-d H:i:s'],
            'fin'           => ['2026-03-31 19:00:00', 'Y-m-d H:i:s'],
            'mensaje_fuera' => 'El registro solo está disponible desde el 26 hasta el 31 de marzo a 7:00 PM.',
            'js_inicio'     => [2026, 2, 26, 8, 30],
            'js_fin'        => [2026, 2, 31, 19, 0],
            'js_mensaje_inicio' => 'El registro abrirá el 26 de marzo a las 8:30 AM.',
        ],
        'segunda' => [
            'nombre'        => 'Segunda Sesión Ordinaria 2026',
            'inicio'        => ['2026-06-15 08:30:00', 'Y-m-d H:i:s'],
            'fin'           => ['2026-06-20 19:00:00', 'Y-m-d H:i:s'],
            'mensaje_fuera' => 'El registro de la segunda sesión aún no está disponible.',
            'js_inicio'     => [2026, 5, 15, 8, 30],
            'js_fin'        => [2026, 5, 20, 19, 0],
            'js_mensaje_inicio' => 'El registro abrirá el 15 de junio a las 8:30 AM.',
        ],
    ];

    public function __construct()
    {
        $this->middleware('permission:ver-listado-registro-copladep', ['only' => ['index']]);
    }

    public function index()
    {
        $registros = RegistroCopladep::with('catMunicipio', 'invitado')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('panel-copladep.primera-sesion-ordinaria-2026.registro-copladep-listado', compact('registros'));
    }

    public function createPrimera()
    {
        return $this->create('primera');
    }

    public function createSegunda()
    {
        return $this->create('segunda');
    }

    public function storePrimera(Request $request)
    {
        return $this->store($request, 'primera');
    }

    public function storeSegunda(Request $request)
    {
        return $this->store($request, 'segunda');
    }

    private function rutaCreate(string $sesion): string
    {
        return $sesion === 'segunda' ? 'copladep-registro-segunda.create' : 'copladep-registro.create';
    }

    public function create(string $sesion)
    {
        $config = $this->configSesiones[$sesion] ?? $this->configSesiones['primera'];

        $municipios = CatMunicipio::select('nombre_municipio')->selectRaw('MIN(id) as id')->whereIn('id', [3, 4, 10, 15, 19, 45, 47, 53, 39, 71, 74, 85, 94, 114, 132, 140, 154, 156, 164, 169, 174, 186, 197, 207])->groupBy('nombre_municipio')->orderBy('nombre_municipio', 'asc')->get();
        $invitados = InvitadoCopladep::with('municipio')->where('sesion', $sesion)->orderBy('nombre_completo', 'asc')->get();

        return view('panel-copladep.primera-sesion-ordinaria-2026.registro-copladep', compact('municipios', 'invitados', 'sesion', 'config'));
    }

    public function store(Request $request, string $sesion)
    {
        Log::info("Inicio del método store para registro COPLADEP - sesión: {$sesion}.");
        $config = $this->configSesiones[$sesion] ?? $this->configSesiones['primera'];
        $now = Carbon::now();

        $inicioRegistro = Carbon::createFromFormat($config['inicio'][1], $config['inicio'][0]);
        $finRegistro    = Carbon::createFromFormat($config['fin'][1], $config['fin'][0]);

        if (!$now->between($inicioRegistro, $finRegistro)) {
            Log::warning("Intento de registro COPLADEP fuera de horario (sesión {$sesion}). Hora actual: {$now}");
            return redirect()->route($this->rutaCreate($sesion))
                ->withErrors(['error' => $config['mensaje_fuera']])
                ->withInput();
        }

        $rules = [
            'tipo_asistente'     => 'required|string|in:titular,representante',
            'invitado_id'        => 'required|integer|exists:invitado_copladeps,id',
            'nombre_completo' => 'required|string|max:50',
            'sexo' => 'required|string|in:Hombre,Mujer,Otro',
            'cargo' => 'required|string|max:200',
            'municipio_id' => 'nullable|integer|exists:cat_municipios,id',
            'correo_electronico' => 'required|string|email|max:50',
            'telefono_oficina' => 'required|string|max:20|regex:/^[0-9\s\-\+\(\)]*$/',
            'telefono_celular' => 'nullable|string|max:20|regex:/^[0-9\s\-\+\(\)]*$/',
            'firma' => 'nullable|string',
        ];
        $messages = [
            'tipo_asistente.required' => 'Debe indicar si es titular o representante.',
            'invitado_id.required'    => 'Debe seleccionar al invitado de la lista.',
            'invitado_id.exists'      => 'El invitado seleccionado no es válido.',
            'firma.required'          => 'Es obligatorio proporcionar su firma o rúbrica.',
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'nombre_completo.max' => 'El nombre completo no puede exceder los 50 caracteres.',
            'sexo.required' => 'Debe seleccionar un sexo.',
            'sexo.in' => 'El valor seleccionado para el sexo no es válido.',
            'cargo.required' => 'El cargo es obligatorio.',
            'cargo.max' => 'El nombre del cargo no puede exceder los 100 caracteres.',
            'municipio_id.integer' => 'El municipio seleccionado no es válido.',
            'municipio_id.exists' => 'El municipio seleccionado no existe en nuestro catálogo.',
            'correo_electronico.required' => 'El correo electrónico es obligatorio.',
            'correo_electronico.email' => 'El formato del correo electrónico no es válido.',
            'correo_electronico.max' => 'El correo electrónico no puede exceder los 50 caracteres.',
            'correo_electronico.unique' => 'Este correo electrónico ya ha sido registrado.',
            'telefono_oficina.required' => 'El teléfono de oficina es obligatorio.',
            'telefono_oficina.regex' => 'El formato del teléfono de oficina no es válido.',
            'telefono_oficina.max' => 'El teléfono de oficina no puede exceder los 20 caracteres.',
            'telefono_celular.regex' => 'El formato del teléfono celular no es válido.',
            'telefono_celular.max' => 'El teléfono celular no puede exceder los 20 caracteres.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function ($validator) use ($sesion) {
            $nombre = $validator->getData()['nombre_completo'] ?? null;
            $correo = $validator->getData()['correo_electronico'] ?? null;

            if ($nombre && RegistroCopladep::where('sesion', $sesion)->where('nombre_completo', $nombre)->exists()) {
                $validator->errors()->add('nombre_completo', 'Este nombre ya ha sido registrado en esta sesión.');
            }
            if ($correo && RegistroCopladep::where('sesion', $sesion)->where('correo_electronico', $correo)->exists()) {
                $validator->errors()->add('correo_electronico', 'Este correo electrónico ya ha sido registrado en esta sesión.');
            }
        });

        if ($validator->fails()) {
            return redirect()->route($this->rutaCreate($sesion))
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $datos = $validator->validated();
            $datos['sesion'] = $sesion;
            RegistroCopladep::create($datos);

            return redirect()->route($this->rutaCreate($sesion))
                ->with('success', '¡Te has registrado exitosamente a la sesión del COPLADEP!');
        } catch (\Exception $e) {
            Log::error('Error al guardar registro de la sesión del COPLADEP: ' . $e->getMessage());
            return redirect()->route($this->rutaCreate($sesion))
                ->withErrors(['db_error' => 'Ocurrió un error inesperado al procesar tu registro.'])
                ->withInput();
        }
    }
}
