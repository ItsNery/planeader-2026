<?php

namespace App\Http\Controllers;

use App\Models\CatMunicipio;
use App\Models\EncuestaCiudadana;
use App\Models\Problematica;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class EncuestaPed2025Controller extends Controller
{
    public function cuestionario()
    {
        $municipios = CatMunicipio::all();

        return view('cuestionario', compact('municipios'));
    }

    public function cuestionario_store(Request $request)
    {
        $this->validate(
            $request,
            [
                '1_1' => 'required|integer',
                '1_2' => 'required|integer',
                '1_3' => 'required|integer',
                '2_1' => 'required|integer',
                '2_2' => 'required|integer',
                '3_1' => 'required|integer',
                '3_2' => 'required|integer',
                '4_1' => 'required|integer',
                '4_2' => 'required|integer',
                '5_1' => 'required|integer',
                '5_2' => 'required|array|min:1',
                '5_2.*' => 'integer',
                '6_1' => 'required|array|min:1',
                '6_1.*' => 'integer',
                '6_2' => 'required|array|min:1',
                '6_2.*' => 'integer',
                '6_3' => 'required|integer',
                '7_1' => 'required|integer',
                '7_2' => 'required|integer',
                '8_1' => 'required|integer',
                '8_2' => 'required|integer',
                '9_1' => 'required|integer',
                '9_2' => 'required|integer',
                '9_3' => 'required|integer',
                '9_4' => 'required|integer',
                '9_5' => 'required|integer',
                '9_6' => 'required|integer',
                '9_6_1' => 'required_if:9_6,1|array',
                '9_6_1.*' => 'integer',
                '9_7' => 'required|integer',
                '9_7_1' => 'required_if:9_7,1|array',
                '9_7_1.*' => 'integer',
                '9_8' => 'required|string',
                '9_9' => 'nullable|sometimes|string',
            ],
            [
                '1_1.required' => 'El campo NO puede estar vacío',
                '1_1.integer' => 'El campo debe de ser de tipo númerico',
                '1_2.required' => 'El campo NO puede estar vacío',
                '1_2.integer' => 'El campo debe de ser de tipo númerico',
                '1_3.required' => 'El campo NO puede estar vacío',
                '1_3.integer' => 'El campo debe de ser de tipo númerico',
                '2_1.required' => 'El campo NO puede estar vacío',
                '2_1.integer' => 'El campo debe de ser de tipo númerico',
                '2_2.required' => 'El campo NO puede estar vacío',
                '2_2.integer' => 'El campo debe de ser de tipo númerico',
                '3_1.required' => 'El campo NO puede estar vacío',
                '3_1.integer' => 'El campo debe de ser de tipo númerico',
                '3_2.required' => 'El campo NO puede estar vacío',
                '3_2.integer' => 'El campo debe de ser de tipo númerico',
                '4_1.required' => 'El campo NO puede estar vacío',
                '4_1.integer' => 'El campo debe de ser de tipo númerico',
                '4_2.required' => 'El campo NO puede estar vacío',
                '4_2.integer' => 'El campo debe de ser de tipo númerico',
                '5_1.required' => 'El campo NO puede estar vacío',
                '5_1.integer' => 'El campo debe de ser de tipo númerico',
                '5_2.required' => 'El campo NO puede estar vacío',
                '5_2.array' => 'El formato de selección no es válido',
                '5_2.min' => 'Debe seleccionar al menos una opción',
                '5_2.*.integer' => 'Los valores seleccionados deben ser números',
                '6_1.required' => 'El campo NO puede estar vacío',
                '6_1.array' => 'El formato de selección no es válido',
                '6_1.min' => 'Debe seleccionar al menos una opción',
                '6_1.*.integer' => 'El campo debe de ser de tipo númerico',
                '6_2.required' => 'El campo NO puede estar vacío',
                '6_2.array' => 'El formato de selección no es válido',
                '6_2.min' => 'Debe seleccionar al menos una opción',
                '6_2.*.integer' => 'Los valores seleccionados deben ser números',
                '6_3.required' => 'El campo NO puede estar vacío',
                '6_3.integer' => 'El campo debe de ser de tipo númerico',
                '7_1.required' => 'El campo NO puede estar vacío',
                '7_1.integer' => 'El campo debe de ser de tipo numérico',
                '7_2.required' => 'El campo NO puede estar vacío',
                '7_2.integer' => 'El campo debe de ser de tipo numérico',
                '8_1.required' => 'El campo NO puede estar vacío',
                '8_1.integer' => 'El campo debe de ser de tipo numérico',
                '8_2.required' => 'El campo NO puede estar vacío',
                '8_2.integer' => 'El campo debe de ser de tipo numérico',
                '9_1.required' => 'El campo NO puede estar vacío',
                '9_1.integer' => 'El campo debe de ser de tipo numérico',
                '9_2.required' => 'El campo NO puede estar vacío',
                '9_2.integer' => 'El campo debe de ser de tipo numérico',
                '9_3.required' => 'El campo NO puede estar vacío',
                '9_3.integer' => 'El campo debe de ser de tipo numérico',
                '9_4.required' => 'El campo NO puede estar vacío',
                '9_4.integer' => 'El campo debe de ser de tipo numérico',
                '9_5.required' => 'El campo NO puede estar vacío',
                '9_5.integer' => 'El campo debe de ser de tipo numérico',
                '9_6.required' => 'Debes seleccionar una opción',
                '9_6.integer' => 'El campo debe de ser de tipo numérico.',
                '9_6_1.required_if' => 'Debe seleccionar una lengua si eligió "Sí" en ¿Habla alguna lengua indígena?',
                '9_6_1.array' => 'El formato de selección no es válido',
                '9_6_1.*.integer' => 'El campo debe ser de tipo numérico.',
                '9_7.required' => 'Debes seleccionar una opción',
                '9_7.integer' => 'El campo debe de ser de tipo numérico.',
                '9_7_1.required_if' => 'Debe seleccionar una dispapacidad si eligió "Sí" en ¿Tiene alguna discapacidad?',
                '9_7_1.array' => 'El formato de selección no es válido',
                '9_7_1.integer' => 'El campo debe ser de tipo numérico.',
                '9_8.required' => 'El campo NO puede estar vacío',
                '9_8.string' => 'El campo debe de ser de tipo texto',
                '9_9.string' => 'El campo debe de ser de tipo texto',
            ]
        );

        EncuestaCiudadana::create([
            '1_1' => $request["1_1"],
            '1_2' => $request["1_2"],
            '1_3' => $request["1_3"],
            '2_1' => $request["2_1"],
            '2_2' => $request["2_2"],
            '3_1' => $request["3_1"],
            '3_2' => $request["3_2"],
            '4_1' => $request["4_1"],
            '4_2' => $request["4_2"],
            '5_1' => $request["5_1"],
            '5_2' => implode(",", $request['5_2']),
            '6_1' => implode(",", $request['6_1']),
            '6_2' => implode(",", $request['6_2']),
            '6_3' => $request["6_3"],
            '7_1' => $request["7_1"],
            '7_2' => $request["7_2"],
            '8_1' => $request["8_1"],
            '8_2' => $request["8_2"],
            '9_1' => $request["9_1"],
            '9_2' => $request["9_2"],
            '9_3' => $request["9_3"],
            '9_4' => $request["9_4"],
            '9_5' => $request["9_5"],
            '9_6' => $request["9_6"],
            '9_6_1' => isset($request['9_6_1']) ? implode(",", $request['9_6_1']) : null,
            '9_7' => $request["9_7"],
            '9_7_1' => isset($request['9_7_1']) ? implode(",", $request['9_7_1']) : null,
            '9_8' => $request["9_8"],
            '9_9' => $request["9_9"],
        ]);

        return redirect()->action([EncuestaPed2025Controller::class, 'cuestionario'])->with('success_encuesta', 'Gracias por su valiosa participación. Su opinión será clave para construir el futuro de Puebla.');
    }

    public function problematica()
    {
        $municipios = CatMunicipio::all();

        return view('problematica', compact('municipios'));
    }

    public function problematica_store(Request $request)
    {
        $this->validate(
            $request,
            [
                'genero' => 'required|integer',
                'edad' => 'required|integer',
                'escolaridad' => 'required|integer',
                'ocupacion' => 'required|integer',
                'estado_civil' => 'required|integer',
                'municipio' => 'required|string',
                'lengua_indigena' => 'required|integer',
                'lengua_indigena_si' => 'required_if:lengua_indigena,1|array',
                'lengua_indigena_si.*' => 'integer',
                'discapacidad' => 'required|integer',
                'discapacidad_si' => 'required_if:discapacidad,1|array',
                'discapacidad_si.*' => 'integer',
                'tematica' => 'required|string|max:190',
                'problematica' => 'required|string|max:1500',
                'solucion' => 'required|string|max:1500',
            ],
            [
                'genero.required' => 'El campo NO puede estar vacío',
                'genero.integer' => 'El campo debe de ser de tipo numérico',
                'edad.required' => 'El campo NO puede estar vacío',
                'edad.integer' => 'El campo debe de ser de tipo numérico',
                'escolaridad.required' => 'El campo NO puede estar vacío',
                'escolaridad.integer' => 'El campo debe de ser de tipo numérico',
                'ocupacion.required' => 'El campo NO puede estar vacío',
                'ocupacion.integer' => 'El campo debe de ser de tipo numérico',
                'estado_civil.required' => 'El campo NO puede estar vacío',
                'estado_civil.integer' => 'El campo debe de ser de tipo numérico',
                'municipio.required' => 'El campo NO puede estar vacío',
                'municipio.string' => 'El campo debe de ser de tipo texto',
                'lengua_indigena.required' => 'Debes seleccionar una opción',
                'lengua_indigena.integer' => 'El campo debe de ser de tipo numérico.',
                'lengua_indigena_si.required_if' => 'Debe seleccionar una lengua si eligió "Sí" en ¿Habla alguna lengua indígena?',
                'lengua_indigena_si.array' => 'El formato de selección no es válido',
                'lengua_indigena_si.*.integer' => 'El campo debe ser de tipo numérico.',
                'discapacidad.required' => 'Debes seleccionar una opción',
                'discapacidad.integer' => 'El campo debe de ser de tipo numérico.',
                'discapacidad_si.required_if' => 'Debe seleccionar una dispapacidad si eligió "Sí" en ¿Tiene alguna discapacidad?',
                'discapacidad_si.array' => 'El formato de selección no es válido',
                'discapacidad_si.integer' => 'El campo debe ser de tipo numérico.',
                'tematica.required' => 'El campo NO puede estar vacío',
                'tematica.string' => 'El campo debe de ser de tipo texto',
                'tematica.max' => 'Los caracteres máximos permitidos son 190',
                'problematica.required' => 'El campo NO puede estar vacío',
                'problematica.string' => 'El campo debe de ser de tipo texto',
                'problematica.max' => 'Los caracteres máximos permitidos son 1500',
                'solucion.required' => 'El campo NO puede estar vacío',
                'solucion.string' => 'El campo debe de ser de tipo texto',
                'solucion.max' => 'Los caracteres máximos permitidos son 1500',
            ]
        );

        Problematica::create([
            'genero' => $request['genero'],
            'edad' => $request['edad'],
            'escolaridad' => $request['escolaridad'],
            'ocupacion' => $request['ocupacion'],
            'estado_civil' => $request['estado_civil'],
            'municipio' => $request['municipio'],
            'lengua_indigena' => $request['lengua_indigena'],
            'lengua_indigena_si' => isset($request['lengua_indigena_si']) ? implode(",", $request['lengua_indigena_si']) : null,
            'discapacidad' => $request['discapacidad'],
            'discapacidad_si' => isset($request['discapacidad_si']) ? implode(",", $request['discapacidad_si']) : null,
            'tematica' => $request['tematica'],
            'problematica' => $request['problematica'],
            'solucion' => $request['solucion'],
        ]);

        return redirect()->action([EncuestaPed2025Controller::class, 'problematica'])->with('success_encuesta', 'Gracias por su valiosa participación. Su opinión será clave para construir el futuro de Puebla.');
    }

    public function proyecto()
    {
        return view('proyecto');
    }

    public function proyecto_store(Request $request)
    {
        $this->validate(
            $request,
            [
                'responsable' => 'required|string',
                'organizacion' => 'required|string',
                'telefono' => 'required|string',
                'correo' => 'required|email',
                'nombre_proyecto' => 'required|string',
                'antecedentes' => 'required|string|max:6000',
            ],
            [
                'responsable.required' => 'El campo NO puede estar vacío',
                'responsable.string' => 'El campo debe de ser de tipo texto',
                'organizacion.required' => 'El campo NO puede estar vacío',
                'organizacion.string' => 'El campo debe de ser de tipo texto',
                'telefono.required' => 'El campo NO puede estar vacío',
                'telefono.string' => 'El campo debe de ser de tipo texto',
                'correo.required' => 'El campo NO puede estar vacío',
                'correo.string' => 'Debes ingresar un correo válido',
                'nombre_proyecto.required' => 'El campo NO puede estar vacío',
                'nombre_proyecto.string' => 'El campo debe de ser de tipo texto',
                'antecedentes.required' => 'El campo NO puede estar vacío',
                'antecedentes.string' => 'El campo debe de ser de tipo texto',
                'antecedentes.max' => 'Los caracteres máximos permitidos son 6000',
            ]
        );

        Proyecto::create([
            'responsable' => $request['responsable'],
            'organizacion' => $request['organizacion'],
            'telefono' => $request['telefono'],
            'correo' => $request['correo'],
            'nombre_proyecto' => $request['nombre_proyecto'],
            'antecedentes' => $request['antecedentes'],
        ]);
        return redirect()->action([EncuestaPed2025Controller::class, 'proyecto'])->with('success_encuesta', 'Gracias por su valiosa participación. Su opinión será clave para construir el futuro de Puebla.');
    }
}
