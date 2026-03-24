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
    public function index()
    {
        $registros = RegistroCopladep::with('catMunicipio')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('registro-copladep-listado', compact('registros'));
    }

    public function create()
    {
        $municipios = CatMunicipio::select('nombre_municipio')->selectRaw('MIN(id) as id')->groupBy('nombre_municipio')->orderBy('nombre_municipio', 'asc')->get();
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
            'nombre_completo' => 'required|string|max:255|unique:registro_copladeps,nombre_completo',
            'sexo' => 'required|string|in:Hombre,Mujer,Otro',
            'cargo' => 'required|string|max:255',
            'municipio_id' => 'nullable|integer|exists:cat_municipios,id',
            'correo_electronico' => 'required|string|email|max:255',
            'telefono_oficina' => 'nullable|string|max:20|regex:/^[0-9\s\-\+\(\)]*$/',
            'telefono_celular' => 'required|string|max:20|regex:/^[0-9\s\-\+\(\)]*$/',
            'firma' => 'nullable|string',
        ];
        $messages = [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'nombre_completo.unique' => 'Este nombre ya ha sido registrado.',
            'sexo.required' => 'Debe seleccionar un sexo.',
            'sexo.in' => 'El valor seleccionado para el sexo no es válido.',
            'cargo.required' => 'El cargo es obligatorio.',
            'municipio_id.integer' => 'El municipio seleccionado no es válido.',
            'municipio_id.exists' => 'El municipio seleccionado no existe en nuestro catálogo.',
            'correo_electronico.required' => 'El correo electrónico es obligatorio.',
            'correo_electronico.email' => 'El formato del correo electrónico no es válido.',
            'telefono_oficina.regex' => 'El formato del teléfono de oficina no es válido.',
            'telefono_celular.required' => 'Es necesario un número de teléfono celular.',
            'telefono_celular.regex' => 'El formato del teléfono celular no es válido.',
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
