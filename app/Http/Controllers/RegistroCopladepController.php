<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatMunicipio;
use App\Models\RegistroCopladep;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RegistroCopladepController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-listado-registro-copladep', ['only' => ['index']]);
    }
    public function index()
    {
        $registros = RegistroCopladep::with('catMunicipio')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('registro-copladep-listado', compact('registros'));
    }

    public function create()
    {
        $municipios = CatMunicipio::select('nombre_municipio')->whereIn('id', [4, 10, 15, 19, 45, 47, 53, 39, 71, 74, 85, 94, 114, 132, 140, 154, 156, 164, 169, 174, 186, 197, 207])->selectRaw('MIN(id) as id')->groupBy('nombre_municipio')->orderBy('nombre_municipio', 'asc')->get();
        return view('registro-copladep', compact('municipios'));
    }

    public function store(Request $request)
    {
        Log::info('Inicio del método store para registro COPLADEP.');
        $now = Carbon::now();

        $inicioRegistro = Carbon::create(2026, 3, 24, 8, 30, 0);
        $finRegistro    = Carbon::create(2026, 3, 24, 15, 0, 0);

        // Comprobar si la hora actual está dentro del periodo
        if (!$now->between($inicioRegistro, $finRegistro)) {
            Log::warning('Intento de registro COPLADEP fuera de horario. Hora actual: ' . $now);
            return redirect()->route('copladep-registro.create')
                ->withErrors(['error' => 'El registro solo está disponible el 10 de abril, de 8:30 AM a 3:00 PM.'])
                ->withInput();
        }
        
        $rules = [
            'nombre_completo' => 'required|string|max:50|unique:registro_copladeps,nombre_completo',
            'sexo' => 'required|string|in:Hombre,Mujer,Otro',
            'cargo' => 'required|string|max:100',
            'municipio_id' => 'nullable|integer|exists:cat_municipios,id',
            'correo_electronico' => 'required|unique|string|email|max:50',
            'telefono_oficina' => 'nullable|string|max:20|regex:/^[0-9\s\-\+\(\)]*$/',
            'telefono_celular' => 'required|string|max:20|regex:/^[0-9\s\-\+\(\)]*$/',
            'firma' => 'nullable|string',
        ];
        $messages = [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'nombre_completo.unique' => 'Este nombre ya ha sido registrado.',
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
            'telefono_oficina.regex' => 'El formato del teléfono de oficina no es válido.',
            'telefono_oficina.max' => 'El teléfono de oficina no puede exceder los 20 caracteres.',
            'telefono_celular.required' => 'Es necesario un número de teléfono celular.',
            'telefono_celular.regex' => 'El formato del teléfono celular no es válido.',
            'telefono_celular.max' => 'El teléfono celular no puede exceder los 20 caracteres.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('copladep-registro.create')
                ->withErrors($validator)
                ->withInput();
        }
        try {
            RegistroCopladep::create($validator->validated());

            return redirect()->route('copladep-registro.create')
                ->with('success', '¡Te has registrado exitosamente a la sesión del COPLADEP!');
        } catch (\Exception $e) {
            Log::error('Error al guardar registro de la sesión del COPLADEP: ' . $e->getMessage());
            return redirect()->route('copladep-registro.create')
                ->withErrors(['db_error' => 'Ocurrió un error inesperado al procesar tu registro.'])
                ->withInput();
        }
    }
}
