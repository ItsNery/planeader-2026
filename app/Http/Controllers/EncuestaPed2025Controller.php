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
        abort(403, 'La encuesta ha concluido.');

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

    public function resultados()
    {
        $columns = [
            'id', '1_1', '1_2', '1_3', '2_1', '2_2', '3_1', '3_2', '4_1', '4_2',
            '5_1', '5_2', '6_1', '6_2', '6_3', '7_1', '7_2', '8_1', '8_2', '9_1',
            '9_2', '9_3', '9_4', '9_5', '9_6', '9_6_1', '9_7', '9_7_1', '9_8', '9_9',
            'created_at', 'updated_at',
        ];
        $options = $this->opcionesEncuesta();

        return response()->streamDownload(function () use ($columns, $options) {
            $output = fopen('php://output', 'w');

            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, $columns, ';', '"', '');

            foreach (EncuestaCiudadana::query()->select($columns)->lazyById() as $respuesta) {
                $row = array_map(function ($column) use ($respuesta, $options) {
                    $value = $respuesta->getAttribute($column);

                    if ($value !== null && isset($options[$column])) {
                        $value = collect(explode(',', (string) $value))
                            ->map(function ($code) use ($column, $options) {
                                $code = trim($code);

                                return isset($options[$column][$code])
                                    ? $code.' - '.$options[$column][$code]
                                    : $code;
                            })
                            ->implode(' | ');
                    }

                    if (is_string($value) && preg_match('/^[=+\-@]/', $value)) {
                        return "'".$value;
                    }

                    return $value;
                }, $columns);

                fputcsv($output, $row, ';', '"', '');
            }

            fclose($output);
        }, 'resultados-encuesta-ciudadana-2025.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function opcionesEncuesta(): array
    {
        return [
            '1_1' => [
                '1' => 'Promover el crecimiento económico',
                '2' => 'Financiar proyectos de infraestructura',
                '3' => 'Asegurar el acceso a la educación universal',
                '4' => 'Promover la igualdad social',
                '5' => 'Mejorar los servicios de salud',
                '6' => 'Fortalecer el sistema de justicia',
                '99' => 'No tengo opinión',
            ],
            '1_2' => [
                '1' => 'Garantizar servicios públicos de calidad',
                '2' => 'Implementar políticas públicas que promuevan la igualdad',
                '3' => 'Crear programas específicos para grupos vulnerables',
                '4' => 'Legislar en materia de igualdad',
                '99' => 'No tengo opinión',
            ],
            '1_3' => [
                '1' => 'Invirtiendo en grandes proyectos de infraestructura',
                '2' => 'Fomentando la participación ciudadana',
                '3' => 'Priorizando la inversión extranjera',
                '4' => 'Desarrollando programas sociales dirigidos a comunidades vulnerables',
                '5' => 'Garantizando acceso a la educación',
                '6' => 'Brindando servicios públicos de calidad',
                '99' => 'No tengo opinión',
            ],
            '2_1' => [
                '1' => 'Fomento al desarrollo de grandes empresas',
                '2' => 'Inversión en infraestructura comunitaria',
                '3' => 'Implementación de programas económicos para las pequeñas y medianas empresas',
                '4' => 'Apoyo a los sectores productivos estratégicos',
                '5' => 'Impulso a emprendedores',
                '99' => 'No tengo opinión',
            ],
            '2_2' => [
                '1' => 'Establecer programas de capacitación y apoyo a emprendedores locales',
                '2' => 'Implementar políticas de austeridad',
                '3' => 'Promover el acceso a financiamiento para la pequeña y mediana empresa',
                '4' => 'Fomentar el desarrollo del turismo',
                '5' => 'Desarrollar programas de inclusión laboral para grupos vulnerables',
                '6' => 'Fortalecer la educación técnica y vocacional en áreas rurales y marginadas',
                '7' => 'Impulsar la educación para todos',
                '99' => 'No tengo opinión',
            ],
            '3_1' => [
                '1' => 'Programas de capacitación laboral',
                '2' => 'Instalación de empresas en su comunidad',
                '3' => 'Orientación sobre proyectos emprendedores',
                '4' => 'Instalación de centros educativos tecnológicos',
                '5' => 'Obras públicas generadoras de empleo',
                '99' => 'No tengo opinión',
            ],
            '3_2' => [
                '1' => 'Promoviendo proyectos de urbanización',
                '2' => 'Impulsando la innovación tecnológica local',
                '3' => 'Capacitando a la población trabajadora',
                '4' => 'Desarrollando políticas de financiamiento a las pequeñas y medianas empresas',
                '99' => 'No tengo opinión',
            ],
            '4_1' => [
                '1' => 'Aumentar la producción industrial con el cuidado al medio ambiente',
                '2' => 'Implementar políticas públicas que protejan los recursos naturales',
                '3' => 'Desarrollar proyectos urbanos considerando la eficiencia energética',
                '4' => 'Crear leyes que protejan el medio ambiente',
                '99' => 'No tengo opinión',
            ],
            '4_2' => [
                '1' => 'Desarrollar proyectos urbanos',
                '2' => 'Aumentar las regulaciones medio ambientales',
                '3' => 'Promover la educación ambiental',
                '4' => 'Proponer leyes que supervisen a las empresas que consumen recursos naturales',
                '99' => 'No tengo opinión',
            ],
            '5_1' => [
                '1' => 'Eficiencia del transporte público',
                '2' => 'Mantenimiento de áreas verdes y espacios públicos',
                '3' => 'Vivienda accesible',
                '4' => 'Gestión de residuos contaminantes',
                '5' => 'Infraestructura vial moderna',
                '6' => 'Uso de energías renovables',
                '7' => 'Abasto de agua potable',
                '99' => 'No tengo opinión',
            ],
            '5_2' => [
                '521' => 'Servicios públicos',
                '522' => 'Estabilidad económica',
                '523' => 'Movilidad sustentable',
                '524' => 'Planteles educativos',
                '525' => 'Infraestructura urbana',
                '526' => 'Centrales de abasto',
                '527' => 'Servicios de salud',
                '528' => 'Seguridad pública',
                '529' => 'No tengo opinión',
            ],
            '6_1' => [
                '611' => 'Mejorar el acceso a la justicia para todas las personas',
                '612' => 'Garantizar que las instituciones judiciales sean imparciales',
                '613' => 'Asegurar que los delincuentes sean procesados y sancionados conforme a la ley',
                '614' => 'Aumentar la confianza en las instituciones de justicia',
                '615' => 'Capacitar al personal en seguridad pública',
                '616' => 'Equipar a las fuerzas policiales',
                '617' => 'No tengo opinión',
            ],
            '6_2' => [
                '621' => 'Realizar auditorías frecuentemente',
                '622' => 'Aumentar los salarios de las fuerzas policiales',
                '623' => 'Incrementar las evaluaciones a los servidores públicos',
                '624' => 'Mayor supervisión en el uso del dinero público',
                '625' => 'Promover la ética e integridad',
                '626' => 'No tengo opinión',
            ],
            '6_3' => [
                '1' => 'Aumentar la presencia militar',
                '2' => 'Mejorar la profesionalización de la fuerza policial',
                '3' => 'Aumentar los programas de prevención de delitos',
                '4' => 'Ampliar la vinculación con el ejército',
                '99' => 'No tengo opinión',
            ],
            '7_1' => [
                '1' => 'Aumentar la participación ciudadana',
                '2' => 'Escuchar a todos los sectores de la población',
                '3' => 'Priorizar las políticas públicas',
                '4' => 'Garantizar el acceso universal a servicios básicos',
                '5' => 'Crear políticas que combatan la discriminación y promuevan la equidad',
                '6' => 'Establecer programas de sensibilización de los derechos humanos',
                '7' => 'Fortalecer las capacidades de las autoridades locales',
                '99' => 'No tengo opinión',
            ],
            '7_2' => [
                '1' => 'Implementar el desarrollo integral en áreas rurales',
                '2' => 'Desarrollar programas de infraestructura que lleguen a los municipios marginados',
                '3' => 'Incluir a las comunidades rurales en programas de inversión pública',
                '99' => 'No tengo opinión',
            ],
            '8_1' => [
                '1' => 'Igualdad de oportunidades para todos',
                '2' => 'Respeto a los derechos',
                '3' => 'Evolución cultural y de valores',
                '4' => 'Protección al medio ambiente',
                '5' => 'Innovación tecnológica',
                '6' => 'Educación de calidad',
                '99' => 'No tengo opinión',
            ],
            '8_2' => [
                '1' => 'Gobierno capaz y con legitimidad',
                '2' => 'Ciudadanía participativa',
                '3' => 'Empresarios emprendedores',
                '4' => 'Jóvenes con visión y preparación',
                '5' => 'Maestros preparados',
                '99' => 'No tengo opinión',
            ],
            '9_1' => [
                '1' => 'Femenino',
                '2' => 'Masculino',
                '3' => 'No binario',
            ],
            '9_2' => [
                '1' => '13-18 años',
                '2' => '19-25 años',
                '3' => '26-35 años',
                '4' => '36-45 años',
                '5' => '46-55 años',
                '6' => '56-65 años',
                '7' => '66-75 años',
                '8' => '76-85 años',
                '9' => '86-100 años',
            ],
            '9_3' => [
                '1' => 'Ninguno',
                '2' => 'Primaria incompleta',
                '3' => 'Primaria completa',
                '4' => 'Secundaria incompleta',
                '5' => 'Secundaria completa',
                '6' => 'Preparatoria/técnica incompleta',
                '7' => 'Preparatoria/técnica completa',
                '8' => 'Universidad incompleta',
                '9' => 'Universidad completa',
                '10' => 'Posgrado',
            ],
            '9_4' => [
                '1' => 'Funcionario',
                '2' => 'Profesionista',
                '3' => 'Técnico',
                '4' => 'Comerciante',
                '5' => 'Ventas',
                '6' => 'Servicios personales',
                '7' => 'Seguridad pública y privada',
                '8' => 'Actividades agrícolas',
                '9' => 'Actividades ganaderas',
                '10' => 'Artesano',
                '11' => 'Obrero',
                '12' => 'Labores del hogar',
                '13' => 'Desempleado',
                '14' => 'Servicio religioso',
                '15' => 'Otro',
            ],
            '9_5' => [
                '1' => 'Soltera(o)',
                '2' => 'Casada(o)',
                '3' => 'Otro',
            ],
            '9_6' => [
                '1' => 'Sí',
                '2' => 'No',
            ],
            '9_6_1' => [
                '9611' => 'Totonaco',
                '9612' => 'Mazateco',
                '9613' => 'Mixteco',
                '9614' => 'Popoloca',
                '9615' => 'Otomí',
                '9616' => 'Tepehua',
                '9617' => 'Náhuatl',
                '9618' => 'Otro(s)',
            ],
            '9_7' => [
                '1' => 'Sí',
                '2' => 'No',
            ],
            '9_7_1' => [
                '9711' => 'Visual',
                '9712' => 'Sensorial',
                '9713' => 'Motriz',
                '9714' => 'Mental',
                '9715' => 'Múltiple',
                '9716' => 'Comunicación',
                '9717' => 'Otro(s)',
            ],
        ];
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
