@extends('layouts.app_encuesta')

@section('title', 'Encuesta Ciudadana')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 sidebar">
                <div class="sidebar__inner">
                    <div class="sidebar__container">
                        <img width="250" class="sidebar__img" src="{{ asset('img/logo_amarrillo.webp') }}"
                            alt="Logotipo Estado de Puebla">

                        <h1 class="sidebar__title text-center">
                            Encuesta Ciudadana en el Estado de Puebla para la integración del <span
                                class="sidebar__title--span">Plan Estatal de Desarrollo 2025-2030.</span>
                        </h1>

                        <p class="sidebar__description">
                            El siguiente cuestionario tiene como objetivo conocer su opinión sobre diversos aspectos del
                            estado de Puebla relacionados con sus problemas y su desarrollo para los próximos años. Su
                            opinión es de gran importancia para construir un mejor futuro para Puebla. Sus respuestas serán
                            confidenciales. ¡Gracias por participar!
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-9 registration py-5">
                <form class="registration__inner" action="{{ route('cuestionario_store') }}" method="POST">
                    @csrf

                    <h2 class="registration__title">Encuesta <span class="registration__title--span">Ciudadana</span>
                    </h2>

                    <h3 class="subtitle mt-4">1. Puebla humana y con bienestar</h3>

                    <ol class="registration__list">
                        <li class="registration__item">
                            De las siguientes opciones de respuesta
                            indique, ¿qué acción debe priorizar el gobierno estatal para garantizar el bienestar
                            integral de la ciudadanía?
                            <select class="form-select mt-3 @error('1_1') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="1_1" required
                                @error('1_1') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="1" @if (old('1_1') == '1') selected @endif>Promover el
                                    crecimiento económico</option>
                                <option value="2" @if (old('1_1') == '2') selected @endif>Financiar proyectos
                                    de infraestructura</option>
                                <option value="3" @if (old('1_1') == '3') selected @endif>Asegurar el acceso
                                    a la educación universal</option>
                                <option value="4" @if (old('1_1') == '4') selected @endif>Promover la
                                    igualdad social</option>
                                <option value="5" @if (old('1_1') == '5') selected @endif>Mejorar los
                                    servicios de salud</option>
                                <option value="6" @if (old('1_1') == '6') selected @endif>Fortalecer el
                                    sistema de justicia</option>
                                <option value="99" @if (old('1_1') == '99') selected @endif>No tengo opinión
                                </option>
                            </select>
                            @error('1_1')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                        <li class="registration__item">
                            De acuerdo con lo que usted observa, ¿cuál de las siguientes acciones considera que es
                            fundamental para promover la inclusión social y el respeto a la diversidad?
                            <select class="form-select mt-3 @error('1_2') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="1_2" required
                                @error('1_2') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="1" @if (old('1_2') == '1') selected @endif>Garantizar
                                    servicios públicos de calidad</option>
                                <option value="2" @if (old('1_2') == '2') selected @endif>Implementar
                                    políticas públicas que promuevan la igualdad</option>
                                <option value="3" @if (old('1_2') == '3') selected @endif>Crear programas
                                    específicos para grupos vulnerables</option>
                                <option value="4" @if (old('1_2') == '4') selected @endif>Legislar en
                                    materia de igualdad</option>
                                <option value="99" @if (old('1_2') == '99') selected @endif>No tengo opinión
                                </option>
                            </select>
                            @error('1_2')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                        <li class="registration__item">
                            Considerando la situación actual del estado de Puebla, ¿de qué manera cree usted que el
                            gobierno estatal puede mejorar la calidad de vida de los sectores más vulnerables en el
                            estado?
                            <select class="form-select mt-3 @error('1_3') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="1_3" required
                                @error('1_3') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="1" @if (old('1_3') == '1') selected @endif>Invirtiendo en
                                    grandes proyectos de infraestructura</option>
                                <option value="2" @if (old('1_3') == '2') selected @endif>Fomentando la
                                    participación ciudadana</option>
                                <option value="3" @if (old('1_3') == '3') selected @endif>Priorizando la
                                    inversión extranjera</option>
                                <option value="4" @if (old('1_3') == '4') selected @endif>Desarrollando
                                    programas sociales dirigidos a comunidades vulnerables</option>
                                <option value="5" @if (old('1_3') == '5') selected @endif>Garantizando
                                    acceso a la educación</option>
                                <option value="6" @if (old('1_3') == '6') selected @endif>Brindando
                                    servicios públicos de calidad</option>
                                <option value="99" @if (old('1_3') == '99') selected @endif>No tengo opinión
                                </option>
                            </select>
                            @error('1_3')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                    </ol>

                    <h3 class="subtitle mt-4">2. Prosperidad para todos</h3>

                    <ol class="registration__list">
                        <li class="registration__item">
                            De las siguientes medidas, ¿cuál impulsaría mejor una economía equitativa y sostenible en el
                            estado de Puebla?
                            <select class="form-select mt-3 @error('2_1') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="2_1" required
                                @error('2_1') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="1" @if (old('2_1') == '1') selected @endif>Fomento al
                                    desarrollo de grandes empresas</option>
                                <option value="2" @if (old('2_1') == '2') selected @endif>Inversión en
                                    infraestructura comunitaria</option>
                                <option value="3" @if (old('2_1') == '3') selected @endif>Implementación de
                                    programas económicos para las pequeñas y medianas empresas</option>
                                <option value="4" @if (old('2_1') == '4') selected @endif>Apoyo a los
                                    sectores productivos estratégicos</option>
                                <option value="5" @if (old('2_1') == '5') selected @endif>Impulso a
                                    emprendedores</option>
                                <option value="99" @if (old('2_1') == '99') selected @endif>No tengo opinión
                                </option>
                            </select>
                            @error('2_1')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                        <li class="registration__item">
                            De las siguientes acciones, ¿cuál considera que sería la que más ayudaría a reducir la
                            desigualdad económica en el estado?
                            <select class="form-select mt-3 @error('2_2') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="2_2" required
                                @error('2_2') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="1" @if (old('2_2') == '1') selected @endif>Establecer
                                    programas de capacitación y apoyo a emprendedores locales</option>
                                <option value="2" @if (old('2_2') == '2') selected @endif>Implementar
                                    políticas de austeridad</option>
                                <option value="3" @if (old('2_2') == '3') selected @endif>Promover el
                                    acceso a financiamiento para la pequeña y mediana empresa</option>
                                <option value="4" @if (old('2_2') == '4') selected @endif>Fomentar el
                                    desarrollo del turismo</option>
                                <option value="5" @if (old('2_2') == '5') selected @endif>Desarrollar
                                    programas de inclusión laboral para grupos vulnerables</option>
                                <option value="6" @if (old('2_2') == '6') selected @endif>Fortalecer la
                                    educación técnica y vocacional en áreas rurales y marginadas</option>
                                <option value="7" @if (old('2_2') == '7') selected @endif>Impulsar la
                                    educación para todos</option>
                                <option value="99" @if (old('2_2') == '99') selected @endif>No tengo opinión
                                </option>
                            </select>
                            @error('2_2')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                    </ol>

                    <h3 class="subtitle mt-4">3. Empleo y estabilidad económica</h3>

                    <ol class="registration__list">
                        <li class="registration__item">
                            ¿Cuál de las siguientes estrategias de gobierno considera que le beneficiaría más a usted y
                            a su familia en el ámbito laboral?
                            <select class="form-select mt-3 @error('3_1') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="3_1" required
                                @error('3_1') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="1" @if (old('3_1') == '1') selected @endif>Programas de
                                    capacitación laboral</option>
                                <option value="2" @if (old('3_1') == '2') selected @endif>Instalación de
                                    empresas en su comunidad</option>
                                <option value="3" @if (old('3_1') == '3') selected @endif>Orientación sobre
                                    proyectos emprendedores</option>
                                <option value="4" @if (old('3_1') == '4') selected @endif>Instalación de
                                    centros educativos tecnológicos</option>
                                <option value="5" @if (old('3_1') == '5') selected @endif>Obras públicas
                                    generadoras de empleo</option>
                                <option value="99" @if (old('3_1') == '99') selected @endif>No tengo opinión
                                </option>
                            </select>
                            @error('3_1')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                        <li class="registration__item">
                            De las siguientes acciones, ¿cuál considera usted que puede mejorar la competitividad
                            económica en su comunidad de la mejor manera?
                            <select class="form-select mt-3 @error('3_2') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="3_2" required
                                @error('3_2') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="1" @if (old('3_2') == '1') selected @endif>Promoviendo
                                    proyectos de urbanización</option>
                                <option value="2" @if (old('3_2') == '2') selected @endif>Impulsando la
                                    innovación tecnológica local</option>
                                <option value="3" @if (old('3_2') == '3') selected @endif>Capacitando a la
                                    población trabajadora</option>
                                <option value="4" @if (old('3_2') == '4') selected @endif>Desarrollando
                                    políticas de financiamiento a las pequeñas y medianas empresas</option>
                                <option value="99" @if (old('3_2') == '99') selected @endif>No tengo opinión
                                </option>
                            </select>
                            @error('3_2')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                    </ol>

                    <h3 class="subtitle mt-4">4. Puebla con visión sostenible</h3>

                    <ol class="registration__list">
                        <li class="registration__item">
                            ¿Cuál de las siguientes acciones considera clave para promover un desarrollo sustentable en
                            el estado?
                            <select class="form-select mt-3 @error('4_1') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="4_1" required
                                @error('4_1') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="1" @if (old('4_1') == '1') selected @endif>Aumentar la
                                    producción industrial con el cuidado al medio ambiente</option>
                                <option value="2" @if (old('4_1') == '2') selected @endif>Implementar
                                    políticas públicas que protejan los recursos naturales</option>
                                <option value="3" @if (old('4_1') == '3') selected @endif>Desarrollar
                                    proyectos urbanos considerando la eficiencia energética</option>
                                <option value="4" @if (old('4_1') == '4') selected @endif>Crear leyes que
                                    protejan el medio ambiente</option>
                                <option value="99" @if (old('4_1') == '99') selected @endif>No tengo opinión
                                </option>
                            </select>
                            @error('4_1')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                        <li class="registration__item">
                            De las siguientes medidas, ¿cuál propondría para asegurar el uso eficiente de los recursos
                            naturales en el estado?
                            <select class="form-select mt-3 @error('4_2') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="4_2" required
                                @error('4_2') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="1" @if (old('4_2') == '1') selected @endif>Desarrollar
                                    proyectos urbanos</option>
                                <option value="2" @if (old('4_2') == '2') selected @endif>Aumentar las
                                    regulaciones medio ambientales</option>
                                <option value="3" @if (old('4_2') == '3') selected @endif>Promover la
                                    educación ambiental</option>
                                <option value="4" @if (old('4_2') == '4') selected @endif>Proponer leyes
                                    que supervisen a las empresas que consumen recursos naturales</option>
                                <option value="99" @if (old('4_2') == '99') selected @endif>No tengo opinión
                                </option>
                            </select>
                            @error('4_2')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                    </ol>

                    <h3 class="subtitle mt-4">5. Desarrollo urbano sustentable y crecimiento metropolitano</h3>

                    <ol class="registration__list">
                        <li class="registration__item">
                            ¿Cuál de los siguientes aspectos del desarrollo urbano en el estado requiere mayor atención?
                            <select class="form-select mt-3 @error('5_1') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="5_1" required
                                @error('5_1') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="1" @if (old('5_1') == '1') selected @endif>Eficiencia del
                                    transporte público</option>
                                <option value="2" @if (old('5_1') == '2') selected @endif>Mantenimiento de
                                    áreas verdes y espacios públicos</option>
                                <option value="3" @if (old('5_1') == '3') selected @endif>Vivienda
                                    accesible</option>
                                <option value="4" @if (old('5_1') == '4') selected @endif>Gestión de
                                    residuos contaminantes</option>
                                <option value="5" @if (old('5_1') == '5') selected @endif>Infraestructura
                                    vial moderna</option>
                                <option value="6" @if (old('5_1') == '6') selected @endif>Uso de energías
                                    renovables</option>
                                <option value="7" @if (old('5_1') == '7') selected @endif>Abasto de agua
                                    potable</option>
                                <option value="99" @if (old('5_1') == '99') selected @endif>No tengo opinión
                                </option>
                            </select>
                            @error('5_1')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                        <li class="registration__item">
                            ¿Cuáles de los siguientes aspectos considera que son los más importantes para que su
                            comunidad prospere?
                            <div class="form-text d-none d-md-block">
                                Mantenga presionada la tecla Ctrl (o Cmd en Mac) para seleccionar múltiples opciones.
                            </div>
                            <select class="form-select mt-3 @error('5_2') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="5_2[]" multiple required
                                @error('5_2') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="521" @if (is_array(old('5_2')) && in_array('521', old('5_2'))) selected @endif>Servicios
                                    públicos</option>
                                <option value="522" @if (is_array(old('5_2')) && in_array('522', old('5_2'))) selected @endif>Estabilidad
                                    económica</option>
                                <option value="523" @if (is_array(old('5_2')) && in_array('523', old('5_2'))) selected @endif>Movilidad
                                    sustentable</option>
                                <option value="524" @if (is_array(old('5_2')) && in_array('524', old('5_2'))) selected @endif>Planteles
                                    educativos</option>
                                <option value="525" @if (is_array(old('5_2')) && in_array('525', old('5_2'))) selected @endif>Infraestructura
                                    urbana</option>
                                <option value="526" @if (is_array(old('5_2')) && in_array('526', old('5_2'))) selected @endif>Centrales de
                                    abasto</option>
                                <option value="527" @if (is_array(old('5_2')) && in_array('527', old('5_2'))) selected @endif>Servicios de
                                    salud</option>
                                <option value="528" @if (is_array(old('5_2')) && in_array('528', old('5_2'))) selected @endif>Seguridad
                                    pública</option>
                                <option value="529" @if (is_array(old('5_2')) && in_array('529', old('5_2'))) selected @endif>No tengo opinión
                                </option>
                            </select>
                            @error('5_2')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                    </ol>

                    <hr>

                    <h3 class="subtitle mt-4">6. Puebla segura y con paz social</h3>

                    <ol class="registration__list">
                        <li class="registration__item">
                            ¿Cuáles de las siguientes opciones serían las que usted considera más eficaces para mejorar
                            la paz en el estado de Puebla?
                            <div class="form-text d-none d-md-block">
                                Mantenga presionada la tecla Ctrl (o Cmd en Mac) para seleccionar múltiples opciones.
                            </div>
                            <select class="form-select mt-3 @error('6_1') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="6_1[]" multiple required
                                @error('6_1') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="611" @if (is_array(old('6_1')) && in_array('611', old('6_1'))) selected @endif>Mejorar el
                                    acceso a la justicia para todas las personas</option>
                                <option value="612" @if (is_array(old('6_1')) && in_array('612', old('6_1'))) selected @endif>Garantizar que
                                    las instituciones judiciales sean imparciales</option>
                                <option value="613" @if (is_array(old('6_1')) && in_array('613', old('6_1'))) selected @endif>Asegurar que los
                                    delincuentes sean procesados y sancionados conforme a la ley</option>
                                <option value="614" @if (is_array(old('6_1')) && in_array('614', old('6_1'))) selected @endif>Aumentar la
                                    confianza en las instituciones de justicia </option>
                                <option value="615" @if (is_array(old('6_1')) && in_array('615', old('6_1'))) selected @endif>Capacitar al
                                    personal en seguridad pública</option>
                                <option value="616" @if (is_array(old('6_1')) && in_array('616', old('6_1'))) selected @endif>Equipar a las
                                    fuerzas policiales</option>
                                <option value="617" @if (is_array(old('6_1')) && in_array('617', old('6_1'))) selected @endif>No tengo opinión
                                </option>
                            </select>
                            @error('6_1')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                        <li class="registration__item">
                            ¿Qué medidas considera más efectivas para combatir la corrupción?
                            <div class="form-text d-none d-md-block">
                                Mantenga presionada la tecla Ctrl (o Cmd en Mac) para seleccionar múltiples opciones.
                            </div>
                            <select class="form-select mt-3 @error('6_2') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="6_2[]" multiple required
                                @error('6_2') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="621" @if (is_array(old('6_2')) && in_array('621', old('6_2'))) selected @endif>Realizar
                                    auditorías frecuentemente</option>
                                <option value="622" @if (is_array(old('6_2')) && in_array('622', old('6_2'))) selected @endif>Aumentar los
                                    salarios de las fuerzas policiales</option>
                                <option value="623" @if (is_array(old('6_2')) && in_array('623', old('6_2'))) selected @endif>Incrementar las
                                    evaluaciones a los servidores públicos</option>
                                <option value="624" @if (is_array(old('6_2')) && in_array('624', old('6_2'))) selected @endif>Mayor
                                    supervisión en el uso del dinero público</option>
                                <option value="625" @if (is_array(old('6_2')) && in_array('625', old('6_2'))) selected @endif>Promover la
                                    ética e integridad</option>
                                <option value="626" @if (is_array(old('6_2')) && in_array('626', old('6_2'))) selected @endif>No tengo opinión
                                </option>
                            </select>
                            @error('6_2')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                        <li class="registration__item">
                            De las siguientes acciones ¿cuál cree usted que funcionaría como la estrategia más efectiva
                            para mejorar la seguridad pública en el estado?
                            <select class="form-select mt-3 @error('6_3') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="6_3" required
                                @error('6_3') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="1" @if (old('6_3') == '1') selected @endif>Aumentar la
                                    presencia militar</option>
                                <option value="2" @if (old('6_3') == '2') selected @endif>Mejorar la
                                    profesionalización de la fuerza policial</option>
                                <option value="3" @if (old('6_3') == '3') selected @endif>Aumentar los
                                    programas de prevención de delitos</option>
                                <option value="4" @if (old('6_3') == '4') selected @endif>Ampliar la
                                    vinculación con el ejército</option>
                                <option value="99" @if (old('6_3') == '99') selected @endif>No tengo
                                    opinión</option>
                            </select>
                            @error('6_3')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                    </ol>

                    <h3 class="subtitle mt-4">7. Gobierno incluyente, abierto, innovador y de resultados</h3>

                    <ol class="registration__list">
                        <li class="registration__item">
                            ¿Qué acción considera que es la más importante para garantizar un gobierno incluyente en el
                            estado?
                            <select class="form-select mt-3 @error('7_1') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="7_1" required
                                @error('7_1') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="1" @if (old('7_1') == '1') selected @endif>Aumentar la
                                    participación ciudadana</option>
                                <option value="2" @if (old('7_1') == '2') selected @endif>Escuchar a
                                    todos los sectores de la población</option>
                                <option value="3" @if (old('7_1') == '3') selected @endif>Priorizar las
                                    políticas públicas</option>
                                <option value="4" @if (old('7_1') == '4') selected @endif>Garantizar el
                                    acceso universal a servicios básicos</option>
                                <option value="5" @if (old('7_1') == '5') selected @endif>Crear políticas
                                    que combatan la discriminación y promuevan la equidad</option>
                                <option value="6" @if (old('7_1') == '6') selected @endif>Establecer
                                    programas de sensibilización de los derechos humanos</option>
                                <option value="7" @if (old('7_1') == '7') selected @endif>Fortalecer las
                                    capacidades de las autoridades locales</option>
                                <option value="99" @if (old('7_1') == '99') selected @endif>No tengo
                                    opinión</option>
                            </select>
                            @error('7_1')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                        <li class="registration__item">
                            ¿Qué acción considera que es la más importante para garantizar un gobierno incluyente en las
                            áreas rurales y marginadas del estado de Puebla?
                            <select class="form-select mt-3 @error('7_2') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="7_2" required
                                @error('7_2') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="1" @if (old('7_2') == '1') selected @endif>Implementar el
                                    desarrollo integral en áreas rurales</option>
                                <option value="2" @if (old('7_2') == '2') selected @endif>Desarrollar
                                    programas de infraestructura que lleguen a los municipios marginados</option>
                                <option value="3" @if (old('7_2') == '3') selected @endif>Incluir a las
                                    comunidades rurales en programas de inversión pública</option>
                                <option value="99" @if (old('7_2') == '99') selected @endif>No tengo
                                    opinión</option>
                            </select>
                            @error('7_2')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                    </ol>

                    <h3 class="subtitle mt-4">8. Gobierno transformador</h3>

                    <ol class="registration__list">
                        <li class="registration__item">
                            ¿Qué factor considera que será el más importante en los próximos 6 años para transformar su
                            comunidad o el municipio donde usted vive?
                            <select class="form-select mt-3 @error('8_1') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="8_1" required
                                @error('8_1') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="1" @if (old('8_1') == '1') selected @endif>Igualdad de
                                    oportunidades para todos</option>
                                <option value="2" @if (old('8_1') == '2') selected @endif>Respeto a los
                                    derechos</option>
                                <option value="3" @if (old('8_1') == '3') selected @endif>Evolución
                                    cultural y de valores</option>
                                <option value="4" @if (old('8_1') == '4') selected @endif>Protección al
                                    medio ambiente</option>
                                <option value="5" @if (old('8_1') == '5') selected @endif>Innovación
                                    tecnológica</option>
                                <option value="6" @if (old('8_1') == '6') selected @endif>Educación de
                                    calidad</option>
                                <option value="99" @if (old('8_1') == '99') selected @endif>No tengo
                                    opinión</option>
                            </select>
                            @error('8_1')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                        <li class="registration__item">
                            ¿Qué factor considera más importante para lograr transformar a la sociedad poblana?
                            <select class="form-select mt-3 @error('8_2') is-invalid @enderror"
                                aria-label="Selector cuestionario PED 2025" name="8_2" required
                                @error('8_2') autofocus @enderror>
                                <option selected disabled>Seleccione su respuesta:</option>
                                <option value="1" @if (old('8_2') == '1') selected @endif>Gobierno capaz
                                    y con legitimidad</option>
                                <option value="2" @if (old('8_2') == '2') selected @endif>Ciudadanía
                                    participativa</option>
                                <option value="3" @if (old('8_2') == '3') selected @endif>Empresarios
                                    emprendedores</option>
                                <option value="4" @if (old('8_2') == '4') selected @endif>Jóvenes con
                                    visión y preparación</option>
                                <option value="5" @if (old('8_2') == '5') selected @endif>Maestros
                                    preparados</option>
                                <option value="99" @if (old('8_2') == '99') selected @endif>No tengo
                                    opinión</option>
                            </select>
                            @error('8_2')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </li>
                    </ol>

                    <h3 class="subtitle mt-4">9. Perfil de la entrevistada(o)</h3>

                    <ol class="registration__list registration__list--nolist">
                        <li class="registration__item">
                            <div class="form-floating">
                                <select class="form-select @error('9_1') is-invalid @enderror" id="9_1"
                                    name="9_1" aria-label="Seleccione su respuesta" required
                                    @error('9_1') autofocus @enderror>
                                    <option selected disabled>Seleccione su respuesta</option>
                                    <option value="1" @if (old('9_1') == '1') selected @endif>Femenino
                                    </option>
                                    <option value="2" @if (old('9_1') == '2') selected @endif>Masculino
                                    </option>
                                    <option value="3" @if (old('9_1') == '3') selected @endif>No binario
                                    </option>
                                </select>
                                @error('9_1')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="9_1">Género</label>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="form-floating">
                                <select class="form-select @error('9_2') is-invalid @enderror" id="9_2"
                                    name="9_2" aria-label="Seleccione su respuesta" required
                                    @error('9_2') autofocus @enderror>
                                    <option selected disabled>Seleccione su respuesta</option>
                                    <option value="1" @if (old('9_2') == '1') selected @endif>13-18 años
                                    </option>
                                    <option value="2" @if (old('9_2') == '2') selected @endif>19-25 años
                                    </option>
                                    <option value="3" @if (old('9_2') == '3') selected @endif>26-35 años
                                    </option>
                                    <option value="4" @if (old('9_2') == '4') selected @endif>36-45 años
                                    </option>
                                    <option value="5" @if (old('9_2') == '5') selected @endif>46-55 años
                                    </option>
                                    <option value="6" @if (old('9_2') == '6') selected @endif>56-65
                                        años
                                    </option>
                                    <option value="7" @if (old('9_2') == '7') selected @endif>66-75
                                        años
                                    </option>
                                    <option value="8" @if (old('9_2') == '8') selected @endif>76-85
                                        años
                                    </option>
                                    <option value="9" @if (old('9_2') == '9') selected @endif>86-100
                                        años
                                    </option>
                                </select>
                                @error('9_2')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="9_2">Edad</label>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="form-floating">
                                <select class="form-select @error('9_3') is-invalid @enderror" id="9_3"
                                    name="9_3" aria-label="Seleccione su respuesta" required
                                    @error('9_3') autofocus @enderror>
                                    <option selected disabled>Seleccione su respuesta</option>
                                    <option value="1" @if (old('9_3') == '1') selected @endif>Ninguno
                                    </option>
                                    <option value="2" @if (old('9_3') == '2') selected @endif>Primaria
                                        incompleta
                                    </option>
                                    <option value="3" @if (old('9_3') == '3') selected @endif>Primaria
                                        completa
                                    </option>
                                    <option value="4" @if (old('9_3') == '4') selected @endif>Secundaria
                                        incompleta</option>
                                    <option value="5" @if (old('9_3') == '5') selected @endif>Secundaria
                                        completa
                                    </option>
                                    <option value="6" @if (old('9_3') == '6') selected @endif>
                                        Preparatoria/
                                        técnica incompleta</option>
                                    <option value="7" @if (old('9_3') == '7') selected @endif>
                                        Preparatoria/
                                        técnica completa</option>
                                    <option value="8" @if (old('9_3') == '8') selected @endif>
                                        Universidad
                                        incompleta</option>
                                    <option value="9" @if (old('9_3') == '9') selected @endif>
                                        Universidad
                                        completa
                                    </option>
                                    <option value="10" @if (old('9_3') == '10') selected @endif>Posgrado
                                    </option>
                                </select>
                                @error('9_3')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="9_3">¿Cuál es su nivel de escolaridad?</label>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="form-floating">
                                <select class="form-select @error('9_4') is-invalid @enderror" id="9_4"
                                    name="9_4" aria-label="Seleccione su respuesta" required
                                    @error('9_4') autofocus @enderror>
                                    <option selected disabled>Seleccione su respuesta</option>
                                    <option value="1" @if (old('9_4') == '1') selected @endif>
                                        Funcionario
                                    </option>
                                    <option value="2" @if (old('9_4') == '2') selected @endif>
                                        Profesionista
                                    </option>
                                    <option value="3" @if (old('9_4') == '3') selected @endif>Técnico
                                    </option>
                                    <option value="4" @if (old('9_4') == '4') selected @endif>
                                        Comerciante
                                    </option>
                                    <option value="5" @if (old('9_4') == '5') selected @endif>Ventas
                                    </option>
                                    <option value="6" @if (old('9_4') == '6') selected @endif>Servicios
                                        personales
                                    </option>
                                    <option value="7" @if (old('9_4') == '7') selected @endif>Seguridad
                                        pública y
                                        privada</option>
                                    <option value="8" @if (old('9_4') == '8') selected @endif>
                                        Actividades
                                        agrícolas</option>
                                    <option value="9" @if (old('9_4') == '9') selected @endif>
                                        Actividades
                                        ganaderas</option>
                                    <option value="10" @if (old('9_4') == '10') selected @endif>Artesano
                                    </option>
                                    <option value="11" @if (old('9_4') == '11') selected @endif>Obrero
                                    </option>
                                    <option value="12" @if (old('9_4') == '12') selected @endif>Labores
                                        del
                                        hogar
                                    </option>
                                    <option value="13" @if (old('9_4') == '13') selected @endif>
                                        Desempleado
                                    </option>
                                    <option value="14" @if (old('9_4') == '14') selected @endif>Servicio
                                        religioso
                                    </option>
                                    <option value="15" @if (old('9_4') == '15') selected @endif>Otro
                                    </option>
                                </select>
                                @error('9_4')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="9_4">¿Cuál es su ocupación?</label>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="form-floating">
                                <select class="form-select @error('9_5') is-invalid @enderror" id="9_5"
                                    name="9_5" aria-label="Seleccione su respuesta" required
                                    @error('9_5') autofocus @enderror>
                                    <option selected disabled>Seleccione su respuesta</option>
                                    <option value="1" @if (old('9_5') == '1') selected @endif>Soltera(o)
                                    </option>
                                    <option value="2" @if (old('9_5') == '2') selected @endif>Casada(o)
                                    </option>
                                    <option value="3" @if (old('9_5') == '3') selected @endif>Otro
                                    </option>
                                </select>
                                @error('9_5')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="9_5">Estado civil</label>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="form-floating">
                                <select class="form-select @error('9_8') is-invalid @enderror" id="9_8"
                                    name="9_8" aria-label="Seleccione su respuesta" required
                                    @error('9_8') autofocus @enderror>
                                    <option selected disabled>Seleccione su respuesta</option>
                                    @foreach ($municipios as $municipio)
                                        <option value="{{ $municipio->nombre_municipio }}"
                                            @if (old('9_8') == $municipio->nombre_municipio) selected @endif>
                                            {{ $municipio->nombre_municipio }}</option>
                                    @endforeach
                                </select>
                                @error('9_8')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="9_8">¿En qué municipio del estado de Puebla vive?</label>
                            </div>
                        </li>
                        <li class="registration__item">
                            <p class="form-label">¿Habla alguna lengua indígena?</p>
                            @error('9_6')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                            <div class="mb-3 ps-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="9_6" id="lengua_9_6_1"
                                        value="1" @if (old('9_6') == '1') checked @endif
                                        @error('9_6') autofocus @enderror>
                                    <label class="form-check-label" for="lengua_9_6_1">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="9_6" id="lengua_indigena_2"
                                        value="2" @if (old('9_6') == '2') checked @endif
                                        @error('9_6') autofocus @enderror>
                                    <label class="form-check-label" for="lengua_indigena_2">No</label>
                                </div>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="{{ $errors->has('9_6_1') || old('9_6') == '1' ? 'd-block' : 'd-none' }}"
                                id="container_lengua_9_6_1">
                                <label for="select_lengua_9_6_1">¿Cuál o cuáles?</label>
                                <div class="form-text d-none d-md-block">
                                    Mantenga presionada la tecla Ctrl (o Cmd en Mac) para seleccionar múltiples opciones.
                                </div>
                                <select class="form-select mt-3 @error('9_6_1') is-invalid @enderror"
                                    id="select_lengua_9_6_1" name="9_6_1[]" aria-label="Seleccione su(s) respuesta(s)"
                                    multiple @error('9_6_1') autofocus @enderror>
                                    <option selected disabled>Seleccione su(s) respuesta(s)</option>
                                    <option value="9611" @if (is_array(old('9_6_1')) && in_array('9611', old('9_6_1'))) selected @endif>Totonaco
                                    </option>
                                    <option value="9612" @if (is_array(old('9_6_1')) && in_array('9612', old('9_6_1'))) selected @endif>Mazateco
                                    </option>
                                    <option value="9613" @if (is_array(old('9_6_1')) && in_array('9613', old('9_6_1'))) selected @endif>Mixteco
                                    </option>
                                    <option value="9614" @if (is_array(old('9_6_1')) && in_array('9614', old('9_6_1'))) selected @endif>Popoloca
                                    </option>
                                    <option value="9615" @if (is_array(old('9_6_1')) && in_array('9615', old('9_6_1'))) selected @endif>Otomí
                                    </option>
                                    <option value="9616" @if (is_array(old('9_6_1')) && in_array('9616', old('9_6_1'))) selected @endif>Tepehua
                                    </option>
                                    <option value="9617" @if (is_array(old('9_6_1')) && in_array('9617', old('9_6_1'))) selected @endif>Náhuatl
                                    </option>
                                    <option value="9618" @if (is_array(old('9_6_1')) && in_array('9618', old('9_6_1'))) selected @endif>Otro(s)
                                    </option>
                                </select>
                                @error('9_6_1')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </li>
                        <li class="registration__item">
                            <p for="9_7" class="form-label">¿Tiene alguna discapacidad?</p>
                            @error('9_7')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                            <div class="mb-3 ps-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="9_7" id="discapacidad_si"
                                        value="1" @if (old('9_7') == '1') checked @endif
                                        @error('9_7') autofocus @enderror>
                                    <label class="form-check-label" for="discapacidad_si">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="9_7" id="discapacidad_no"
                                        value="2" @if (old('9_7') == '2') checked @endif
                                        @error('9_7') autofocus @enderror>
                                    <label class="form-check-label" for="discapacidad_no">No</label>
                                </div>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="{{ $errors->has('9_7_1') || old('discapacidad') == '1' ? 'd-block' : 'd-none' }}"
                                id="container_discapacidad_9_7_1">
                                <label for="select_discapacidad_9_7_1">¿Cuál o cuáles?</label>
                                <div class="form-text d-none d-md-block">
                                    Mantenga presionada la tecla Ctrl (o Cmd en Mac) para seleccionar múltiples opciones.
                                </div>
                                <select class="form-select mt-3 @error('9_7_1') is-invalid @enderror"
                                    id="select_discapacidad_9_7_1" name="9_7_1[]"
                                    aria-label="Seleccione su(s) respuesta(s)" multiple
                                    @error('9_7_1') autofocus @enderror>
                                    <option selected disabled>Seleccione su(s) respuesta(s)</option>
                                    <option value="9711" @if (is_array(old('9_7_1')) && in_array('9711', old('9_7_1'))) selected @endif>Visual
                                    </option>
                                    <option value="9712" @if (is_array(old('9_7_1')) && in_array('9712', old('9_7_1'))) selected @endif>Sensorial
                                    </option>
                                    <option value="9713" @if (is_array(old('9_7_1')) && in_array('9713', old('9_7_1'))) selected @endif>Motriz
                                    </option>
                                    <option value="9714" @if (is_array(old('9_7_1')) && in_array('9714', old('9_7_1'))) selected @endif>Mental
                                    </option>
                                    <option value="9715" @if (is_array(old('9_7_1')) && in_array('9715', old('9_7_1'))) selected @endif>Múltiple
                                    </option>
                                    <option value="9716" @if (is_array(old('9_7_1')) && in_array('9716', old('9_7_1'))) selected @endif>
                                        Comunicación</option>
                                    <option value="9717" @if (is_array(old('9_7_1')) && in_array('9717', old('9_7_1'))) selected @endif>Otro(s)
                                    </option>
                                </select>
                                @error('9_7_1')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </li>
                        <li class="registration__item" style="grid-column: span 2;">
                            <p class="form-label">Si desea realizar algún comentario adicional puede anotarlo a
                                continuación:</p>
                            <div class="form-floating mb-3">
                                <textarea class="form-control @error('9_9') is-invalid @enderror" placeholder="Describa su problemática"
                                    id="9_9" name="9_9" maxlength="500" style="height: 150px" @error('9_9') autofocus @enderror>{{ old('9_9') }}</textarea>
                                @error('9_9')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="9_9">Describa su problemática <span class="registration__required">(*)
                                        <small>Máximo 500 caracteres</small></span></label>
                            </div>
                        </li>
                    </ol>

                    <div class="d-md-flex justify-content-between align-items-end">
                        <a href="{{ url('consultaciudadana2025') }}" class="btn btn__secondary">
                            Atrás
                        </a>

                        <div
                            class="d-flex flex-column align-items-center flex-md-row justify-content-md-end align-items-end mt-4 mt-md-0">
                            {!! NoCaptcha::display() !!}

                            <button class="btn btn__submit ms-md-4 mt-3" type="submit">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('css')
@endsection

@section('js')
@endsection
