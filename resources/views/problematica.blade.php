@extends('layouts.app_encuesta')

@section('title', 'Problemáticas y Soluciones')

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
                            Puebla requiere del trabajo conjunto, bajo los principios del Humanismo Mexicano para tener un
                            mejor diseño de estrategias, de estimar los recursos necesarios en la implementación de
                            proyectos estratégicos, regionales y prioritarios. El pueblo y su importante participación
                            ciudadana asegura la gobernanza local teniendo como prioridad un mejor futuro para todas y
                            todos, es por esto que la elaboración del Plan Estatal de Desarrollo 2024-2030 busca integrar a
                            todos los sectores y tomar en cuenta cada una de las opiniones de las y los poblanos.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-9 registration py-5">
                <form class="registration__inner" action="{{ route('problematica_store') }}" method="POST">
                    @csrf

                    <h2 class="registration__title">Problemáticas y <span
                            class="registration__title--span">Soluciones</span>
                    </h2>

                    <h3 class="subtitle mt-4">Perfil de la entrevistada(o)</h3>

                    <ol class="registration__list registration__list--nolist p-0 mb-0">
                        <li class="registration__item">
                            <div class="form-floating">
                                <select class="form-select @error('genero') is-invalid @enderror" id="genero"
                                    name="genero" aria-label="Seleccione su respuesta" required
                                    @error('genero') autofocus @enderror>
                                    <option selected disabled>Seleccione su respuesta</option>
                                    <option value="1" @if (old('genero') == '1') selected @endif>Femenino
                                    </option>
                                    <option value="2" @if (old('genero') == '2') selected @endif>Masculino
                                    </option>
                                    <option value="3" @if (old('genero') == '3') selected @endif>No binario
                                    </option>
                                </select>
                                @error('genero')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="genero">Género</label>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="form-floating">
                                <select class="form-select @error('edad') is-invalid @enderror" id="edad"
                                    name="edad" aria-label="Seleccione su respuesta" required
                                    @error('edad') autofocus @enderror>
                                    <option selected disabled>Seleccione su respuesta</option>
                                    <option value="1" @if (old('edad') == '1') selected @endif>13-18 años
                                    </option>
                                    <option value="2" @if (old('edad') == '2') selected @endif>19-25 años
                                    </option>
                                    <option value="3" @if (old('edad') == '3') selected @endif>26-35 años
                                    </option>
                                    <option value="4" @if (old('edad') == '4') selected @endif>36-45 años
                                    </option>
                                    <option value="5" @if (old('edad') == '5') selected @endif>46-55 años
                                    </option>
                                    <option value="6" @if (old('edad') == '6') selected @endif>56-65
                                        años
                                    </option>
                                    <option value="7" @if (old('edad') == '7') selected @endif>66-75
                                        años
                                    </option>
                                    <option value="8" @if (old('edad') == '8') selected @endif>76-85
                                        años
                                    </option>
                                    <option value="9" @if (old('edad') == '9') selected @endif>86-100
                                        años
                                    </option>
                                </select>
                                @error('edad')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="edad">Edad</label>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="form-floating">
                                <select class="form-select @error('escolaridad') is-invalid @enderror" id="escolaridad"
                                    name="escolaridad" aria-label="Seleccione su respuesta" required
                                    @error('escolaridad') autofocus @enderror>
                                    <option selected disabled>Seleccione su respuesta</option>
                                    <option value="1" @if (old('escolaridad') == '1') selected @endif>Ninguno
                                    </option>
                                    <option value="2" @if (old('escolaridad') == '2') selected @endif>Primaria
                                        incompleta
                                    </option>
                                    <option value="3" @if (old('escolaridad') == '3') selected @endif>Primaria
                                        completa
                                    </option>
                                    <option value="4" @if (old('escolaridad') == '4') selected @endif>Secundaria
                                        incompleta</option>
                                    <option value="5" @if (old('escolaridad') == '5') selected @endif>Secundaria
                                        completa
                                    </option>
                                    <option value="6" @if (old('escolaridad') == '6') selected @endif>
                                        Preparatoria/
                                        técnica incompleta</option>
                                    <option value="7" @if (old('escolaridad') == '7') selected @endif>
                                        Preparatoria/
                                        técnica completa</option>
                                    <option value="8" @if (old('escolaridad') == '8') selected @endif>
                                        Universidad
                                        incompleta</option>
                                    <option value="9" @if (old('escolaridad') == '9') selected @endif>
                                        Universidad
                                        completa
                                    </option>
                                    <option value="10" @if (old('escolaridad') == '10') selected @endif>Posgrado
                                    </option>
                                </select>
                                @error('escolaridad')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="escolaridad">¿Cuál es su nivel de escolaridad?</label>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="form-floating">
                                <select class="form-select @error('ocupacion') is-invalid @enderror" id="ocupacion"
                                    name="ocupacion" aria-label="Seleccione su respuesta" required
                                    @error('ocupacion') autofocus @enderror>
                                    <option selected disabled>Seleccione su respuesta</option>
                                    <option value="1" @if (old('ocupacion') == '1') selected @endif>
                                        Funcionario
                                    </option>
                                    <option value="2" @if (old('ocupacion') == '2') selected @endif>
                                        Profesionista
                                    </option>
                                    <option value="3" @if (old('ocupacion') == '3') selected @endif>Técnico
                                    </option>
                                    <option value="4" @if (old('ocupacion') == '4') selected @endif>
                                        Comerciante
                                    </option>
                                    <option value="5" @if (old('ocupacion') == '5') selected @endif>Ventas
                                    </option>
                                    <option value="6" @if (old('ocupacion') == '6') selected @endif>Servicios
                                        personales
                                    </option>
                                    <option value="7" @if (old('ocupacion') == '7') selected @endif>Seguridad
                                        pública y
                                        privada</option>
                                    <option value="8" @if (old('ocupacion') == '8') selected @endif>
                                        Actividades
                                        agrícolas</option>
                                    <option value="9" @if (old('ocupacion') == '9') selected @endif>
                                        Actividades
                                        ganaderas</option>
                                    <option value="10" @if (old('ocupacion') == '10') selected @endif>Artesano
                                    </option>
                                    <option value="11" @if (old('ocupacion') == '11') selected @endif>Obrero
                                    </option>
                                    <option value="12" @if (old('ocupacion') == '12') selected @endif>Labores
                                        del
                                        hogar
                                    </option>
                                    <option value="13" @if (old('ocupacion') == '13') selected @endif>
                                        Desempleado
                                    </option>
                                    <option value="14" @if (old('ocupacion') == '14') selected @endif>Servicio
                                        religioso
                                    </option>
                                    <option value="15" @if (old('ocupacion') == '15') selected @endif>Otro
                                    </option>
                                </select>
                                @error('ocupacion')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="ocupacion">¿Cuál es su ocupación?</label>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="form-floating">
                                <select class="form-select @error('estado_civil') is-invalid @enderror" id="estado_civil"
                                    name="estado_civil" aria-label="Seleccione su respuesta" required
                                    @error('estado_civil') autofocus @enderror>
                                    <option selected disabled>Seleccione su respuesta</option>
                                    <option value="1" @if (old('estado_civil') == '1') selected @endif>Soltera(o)
                                    </option>
                                    <option value="2" @if (old('estado_civil') == '2') selected @endif>Casada(o)
                                    </option>
                                    <option value="3" @if (old('estado_civil') == '3') selected @endif>Otro
                                    </option>
                                </select>
                                @error('estado_civil')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="estado_civil">Estado civil</label>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="form-floating">
                                <select class="form-select @error('municipio') is-invalid @enderror" id="municipio"
                                    name="municipio" aria-label="Seleccione su respuesta" required
                                    @error('municipio') autofocus @enderror>
                                    <option selected disabled>Seleccione su respuesta</option>
                                    @foreach ($municipios as $municipio)
                                        <option value="{{ $municipio->nombre_municipio }}"
                                            @if (old('municipio') == $municipio->nombre_municipio) selected @endif>
                                            {{ $municipio->nombre_municipio }}</option>
                                    @endforeach
                                </select>
                                @error('municipio')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="municipio">¿En qué municipio del estado de Puebla vive?</label>
                            </div>
                        </li>
                        <li class="registration__item">
                            <p class="form-label">¿Habla alguna lengua indígena?</p>
                            @error('lengua_indigena')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                            <div class="mb-3 ps-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="lengua_indigena"
                                        id="lengua_9_6_1" value="1"
                                        @if (old('lengua_indigena') == '1') checked @endif
                                        @error('lengua_indigena') autofocus @enderror>
                                    <label class="form-check-label" for="lengua_9_6_1">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="lengua_indigena"
                                        id="lengua_indigena_2" value="2"
                                        @if (old('lengua_indigena') == '2') checked @endif
                                        @error('lengua_indigena') autofocus @enderror>
                                    <label class="form-check-label" for="lengua_indigena_2">No</label>
                                </div>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="{{ $errors->has('lengua_indigena_si') || old('lengua_indigena') == '1' ? 'd-block' : 'd-none' }}"
                                id="container_lengua_indigena">
                                <label for="select_lengua_indigena">¿Cuál o cuáles?</label>
                                <div class="form-text d-none d-md-block">
                                    Mantenga presionada la tecla Ctrl (o Cmd en Mac) para seleccionar múltiples opciones.
                                </div>
                                <select class="form-select mt-3 @error('lengua_indigena_si') is-invalid @enderror"
                                    id="select_lengua_indigena" name="lengua_indigena_si[]"
                                    aria-label="Seleccione su(s) respuesta(s)" multiple
                                    @error('lengua_indigena_si') autofocus @enderror>
                                    <option selected disabled>Seleccione su(s) respuesta(s)</option>
                                    <option value="9611" @if (is_array(old('lengua_indigena_si')) && in_array('9611', old('lengua_indigena_si'))) selected @endif>Totonaco
                                    </option>
                                    <option value="9612" @if (is_array(old('lengua_indigena_si')) && in_array('9612', old('lengua_indigena_si'))) selected @endif>Mazateco
                                    </option>
                                    <option value="9613" @if (is_array(old('lengua_indigena_si')) && in_array('9613', old('lengua_indigena_si'))) selected @endif>Mixteco
                                    </option>
                                    <option value="9614" @if (is_array(old('lengua_indigena_si')) && in_array('9614', old('lengua_indigena_si'))) selected @endif>Popoloca
                                    </option>
                                    <option value="9615" @if (is_array(old('lengua_indigena_si')) && in_array('9615', old('lengua_indigena_si'))) selected @endif>Otomí
                                    </option>
                                    <option value="9616" @if (is_array(old('lengua_indigena_si')) && in_array('9616', old('lengua_indigena_si'))) selected @endif>Tepehua
                                    </option>
                                    <option value="9617" @if (is_array(old('lengua_indigena_si')) && in_array('9617', old('lengua_indigena_si'))) selected @endif>Náhuatl
                                    </option>
                                    <option value="9618" @if (is_array(old('lengua_indigena_si')) && in_array('9618', old('lengua_indigena_si'))) selected @endif>Otro(s)
                                    </option>
                                </select>
                                @error('lengua_indigena_si')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </li>
                        <li class="registration__item">
                            <p class="form-label">¿Tiene alguna discapacidad?</p>
                            @error('discapacidad')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                            <div class="mb-3 ps-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="discapacidad"
                                        id="discapacidad_si" value="1"
                                        @if (old('discapacidad') == '1') checked @endif
                                        @error('discapacidad') autofocus @enderror>
                                    <label class="form-check-label" for="discapacidad_si">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="discapacidad"
                                        id="discapacidad_no" value="2"
                                        @if (old('discapacidad') == '2') checked @endif
                                        @error('discapacidad') autofocus @enderror>
                                    <label class="form-check-label" for="discapacidad_no">No</label>
                                </div>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="{{ $errors->has('discapacidad_si') || old('discapacidad') == '1' ? 'd-block' : 'd-none' }}"
                                id="container_discapacidad_si">
                                <label for="select_discapacidad_si">¿Cuál o cuáles?</label>
                                <div class="form-text d-none d-md-block">
                                    Mantenga presionada la tecla Ctrl (o Cmd en Mac) para seleccionar múltiples opciones.
                                </div>
                                <select class="form-select mt-3 @error('discapacidad_si') is-invalid @enderror"
                                    id="select_discapacidad_si" name="discapacidad_si[]"
                                    aria-label="Seleccione su(s) respuesta(s)" multiple
                                    @error('discapacidad_si') autofocus @enderror>
                                    <option selected disabled>Seleccione su(s) respuesta(s)</option>
                                    <option value="9711" @if (is_array(old('discapacidad_si')) && in_array('9711', old('discapacidad_si'))) selected @endif>Visual
                                    </option>
                                    <option value="9712" @if (is_array(old('discapacidad_si')) && in_array('9712', old('discapacidad_si'))) selected @endif>Sensorial
                                    </option>
                                    <option value="9713" @if (is_array(old('discapacidad_si')) && in_array('9713', old('discapacidad_si'))) selected @endif>Motriz
                                    </option>
                                    <option value="9714" @if (is_array(old('discapacidad_si')) && in_array('9714', old('discapacidad_si'))) selected @endif>Mental
                                    </option>
                                    <option value="9715" @if (is_array(old('discapacidad_si')) && in_array('9715', old('discapacidad_si'))) selected @endif>Múltiple
                                    </option>
                                    <option value="9716" @if (is_array(old('discapacidad_si')) && in_array('9716', old('discapacidad_si'))) selected @endif>
                                        Comunicación</option>
                                    <option value="9717" @if (is_array(old('discapacidad_si')) && in_array('9717', old('discapacidad_si'))) selected @endif>Otro(s)
                                    </option>
                                </select>
                                @error('discapacidad_si')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </li>
                    </ol>

                    <h3 class="subtitle">Temática</h3>

                    <div class="form-floating mt-4 mb-5">
                        <input type="text" class="form-control @error('tematica') is-invalid @enderror"
                            placeholder="Describa su temática" id="tematica" name="tematica" maxlength="190" required
                            @error('tematica') autofocus @enderror value="{{ old('tematica') }}">
                        @error('tematica')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                        <label for="tematica">Temática</label>
                        <div class="form-text">Máximo 190 caracteres</div>
                    </div>

                    <div class="form-floating mb-5">
                        <textarea class="form-control @error('problematica') is-invalid @enderror" placeholder="Describa su problemática"
                            id="problematica" name="problematica" maxlength="1500" style="height: 150px" required>{{ old('problematica') }}</textarea>
                        @error('problematica')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                        <label for="problematica">Describa su problemática</label>
                        <div class="form-text">Máximo 1500 caracteres</div>
                    </div>

                    <div class="form-floating mb-5">
                        <textarea class="form-control @error('solucion') is-invalid @enderror" placeholder="Describa su solución"
                            id="solucion" name="solucion" maxlength="1500" style="height: 150px" required>{{ old('solucion') }}</textarea>
                        @error('solucion')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                        <label for="solucion">Describa su solución</label>
                        <div class="form-text">Máximo 1500 caracteres</div>
                    </div>

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
