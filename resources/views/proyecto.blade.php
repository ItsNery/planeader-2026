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
                <form class="registration__inner" action="{{ route('proyecto_store') }}" method="POST">
                    @csrf

                    <h2 class="registration__title">Propuesta de <span class="registration__title--span">Proyecto</span>
                    </h2>

                    <h3 class="subtitle mt-4">Información General</h3>

                    <ol class="registration__list registration__list--nolist p-0 mb-0">
                        <li class="registration__item">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('responsable') is-invalid @enderror"
                                    placeholder="Persona Responsable" id="responsable" name="responsable" maxlength="190"
                                    required @error('responsable') autofocus @enderror value="{{ old('responsable') }}">
                                @error('responsable')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="responsable">Persona Responsable</label>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('organizacion') is-invalid @enderror"
                                    placeholder="Organización o Institución" id="organizacion" name="organizacion"
                                    maxlength="190" required @error('organizacion') autofocus @enderror
                                    value="{{ old('organizacion') }}">
                                @error('organizacion')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="organizacion">Organización o Institución</label>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="form-floating">
                                <input type="number" class="form-control @error('telefono') is-invalid @enderror"
                                    placeholder="Número telefónico" id="telefono" name="telefono" maxlength="190" required
                                    @error('telefono') autofocus @enderror value="{{ old('telefono') }}">
                                @error('telefono')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="telefono">Número telefónico</label>
                            </div>
                        </li>
                        <li class="registration__item">
                            <div class="form-floating">
                                <input type="email" class="form-control @error('correo') is-invalid @enderror"
                                    placeholder="Correo electrónico" id="correo" name="correo" maxlength="190" required
                                    @error('correo') autofocus @enderror value="{{ old('correo') }}">
                                @error('correo')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                                <label for="correo">Correo electrónico</label>
                            </div>
                        </li>
                    </ol>

                    <h3 class="subtitle">Proyecto</h3>

                    <div class="form-floating mt-4 mb-5">
                        <input type="text" class="form-control @error('nombre_proyecto') is-invalid @enderror"
                            placeholder="Nombre del proyecto" id="nombre_proyecto" name="nombre_proyecto" maxlength="190"
                            required @error('nombre_proyecto') autofocus @enderror value="{{ old('nombre_proyecto') }}">
                        @error('nombre_proyecto')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                        <label for="nombre_proyecto">Nombre del proyecto</label>
                    </div>

                    <div class="form-floating mb-5">
                        <textarea class="form-control @error('antecedentes') is-invalid @enderror" placeholder="Describa sus antecedentes"
                            id="antecedentes" name="antecedentes" maxlength="6000" style="height: 150px;padding-top: 2.5rem;" required>{{ old('antecedentes') }}</textarea>
                        @error('antecedentes')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                        <label for="antecedentes">Describa a continuación la problemática que su proyecto o estrategia busca
                            atender, así como la experiencia que se tiene en entorno a esta.</label>
                        <div class="form-text">Máximo 6000 caracteres</div>
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
