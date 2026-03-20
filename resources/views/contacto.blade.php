@extends('layouts.plantilla')
@section('title', 'Contacto')
@section('meta-description', 'Página de contacto del Sistema Estatal de Planeación Democrática del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'Contacto - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Bienvenido a la página de contacto del Sistema Estatal de Planeación Democrática del Estado
    de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'Contacto - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
    'Bienvenido a la página de contacto del Sistema Estatal de Planeación Democrática del
    Estado de Puebla.')
@section('css')
    {!! NoCaptcha::renderJs() !!}
@endsection
@section('content')
    @if ($message = Session::get('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '{{ $message }}'
                });
            });
        </script>
    @endif
    <section class="contenedor-imagen-contacto">
        <h1>Contáctanos</h1>
    </section>
    <section id="contact" class="contacto">
        <div class="container-fluid contact overflow-hidden py-5">
            <div class="container py-5">
                <div class="row g-5 mb-5">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                        <div class="sub-style">
                            <h5 class="sub-title text-main-color pe-3 corra-light">
                                Contacto Rápido
                            </h5>
                        </div>
                        <h2 class="display-5 mb-4 texto-color1 fw-bolder gilroy-bold">
                            ¿Tienes preguntas?
                        </h2>
                        <p class="mb-5 text-justify corra-light">
                            Acércate a la
                            Dirección de Planeación y Desarrollo de la Subsecretaría de Planeación.
                        </p>
                        <div class="d-flex border-bottom mb-4 pb-4">
                            <i class="fas fa-map-marked-alt fa-4x text-main-color bg-light p-3 rounded"></i>
                            <div class="ps-3">
                                <h5 class="corra-bold">
                                    Ubicación
                                </h5>
                                <p class="corra-light">
                                    Avenida 11 Oriente 2224 Tercer Piso,
                                    72501 Puebla, Puebla
                                </p>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-xl-6">
                                <div class="d-flex">
                                    <i class="fas fa-tty fa-3x"></i>
                                    <div class="ps-3">
                                        <h5 class="mb-3 corra-bold">
                                            Contácto rápido
                                        </h5>
                                        <div class="mb-3">
                                            <h6 class="mb-0 corra-bold">
                                                Telefóno:
                                            </h6>
                                            <a href="tel:2222297000" class="fs-5 corra-light text-decoration-none text-inherit">
                                                222 229 7000 Ext.
                                                5012
                                            </a>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="mb-0 corra-bold">
                                                Correo:
                                            </h6>
                                            <a href="mailto:planeacion@puebla.gob.mx" class="fs-5 corra-light text-decoration-none text-inherit">
                                                planeacion@puebla.gob.mx
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="d-flex">
                                    <i class="fas fa-clone fa-3x"></i>
                                    <div class="ps-3">
                                        <h5 class="mb-3 corra-bold">
                                            Horario laboral
                                        </h5>
                                        <div class="mb-3">
                                            <h6 class="mb-0 corra-bold">
                                                Lun - Vie:
                                            </h6>
                                            <p class="fs-5">
                                                09:00 am a 06:00 pm
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.3">
                        <div class="sub-style">
                            <h5 class="corra-light pe-3">
                                Ponte en contacto
                            </h5>
                        </div>
                        <h2 class="display-5 mb-4 texto-color1 fw-bolder gilroy-bold">
                            Envíanos un mensaje
                        </h2>
                        <p class="mb-3 text-justify corra-light">
                            Si tienes alguna
                            duda o comentario para mejorar la página escríbenos. Asimismo, recuerda que los
                            documentos que se presentan son responsabilidad de la Institución
                            correspondiente.
                        </p>
                        <form action="{{ route('formulariocontacto.store') }}" method="post" novalidate>
                            @csrf
                            <div class="row g-4">
                                <div class="col-lg-12 col-xl-6">
                                    <div class="form-floating">
                                        <input type="text" name="nombre"
                                            class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                                            placeholder="Tu nombre" value="{{ old('nombre') }}">
                                        <label for="nombre">Tu nombre</label>
                                        @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control @error('correo') is-invalid @enderror"
                                            id="correo" name="correo" placeholder="Tu correo"
                                            value="{{ old('correo') }}">
                                        <label for="correo">Tu correo</label>
                                        @error('correo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control @error('telefono') is-invalid @enderror"
                                            id="telefono" placeholder="Tu teléfono" name="telefono"
                                            value="{{ old('telefono') }}">
                                        <label for="telefono">Tu teléfono</label>
                                        @error('telefono')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('asunto') is-invalid @enderror"
                                            name="asunto" id="asunto" placeholder="Asunto" value="{{ old('asunto') }}">
                                        <label for="asunto">Asunto</label>
                                        @error('asunto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="h-160px form-control @error('mensaje') is-invalid @enderror" name="mensaje"
                                            placeholder="Déjanos un mensaje aquí" id="mensaje">{{ old('mensaje') }}</textarea>
                                        <label for="mensaje">Mensaje</label>
                                        @error('mensaje')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    {!! NoCaptcha::display() !!}
                                    @error('g-recaptcha-response')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="contenedor-boton">
                                        <button type="submit" class="btn btn-descargar py-3">
                                            <span class="btn-descargar__texto">Enviar</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
