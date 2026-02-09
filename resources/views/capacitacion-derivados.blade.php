@extends('layouts.plantilla')
@section('title', 'Capacitación de los Programas Derivados del Plan Estatal de Desarrollo 2024-2030')
@section('meta-description',
    'Documentos de apoyo durante la Capacitación de los Programas Derivados del Plan Estatal de
    Desarrollo 2024-2030')
@section('canonical-url', url()->current())
@section('og-title', 'Capacitación de los Programas Derivados del Plan Estatal de Desarrollo 2024-2030')
@section('og-description',
    'Bienvenido a la página de documentos de apoyo durante la Capacitación de los Programas Derivados del Plan Estatal de
    Desarrollo 2024-2030, parte del Sistema
    Estatal de Planeación Democrática del Estado de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'Capacitación de los Programas Derivados del Plan Estatal de Desarrollo 2024-2030')
@section('twitter-description',
    'Bienvenido a la página de documentos de apoyo durante la Capacitación de los Programas Derivados del Plan Estatal de
    Desarrollo 2024-2030, parte del
    Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('content')
    <section class="contenedor-imagen-subcomites">
        <h1>Capacitación de los Programas Derivados</h1>
    </section>
    <section class="documentos-marco py-2">
        <div class="container contenedor-flex">
            <div class="container row">
                <div class="container px-4 col-12 col-lg-3 col-md-6">
                    <div class="tarjeta-marco">
                        <div class="imagen">
                            <img src="{{ asset('img/PortadaManualDerivadosSectoriales.jpeg') }}"
                                alt="Portada de Documento Manual de Programas Derivados Sectoriales"
                                title="Manual de Programas Derivados Sectoriales">
                        </div>
                        <div class="contenedor-boton">
                            <a href="{{ asset('documentos/capacitaciones-derivados/ManualDerivadosSectoriales.pdf') }}"
                                target="_blank" class="btn-descargar" title="Manual de Programas Derivados Sectoriales">
                                <span class="btn-descargar__texto">Consultar documento</span>

                                <span class="btn-descargar__icono">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 15.586l-4.293-4.293a1 1 0 0 1 1.414-1.414L11 11.586V4a1 1 0 0 1 2 0v7.586l1.879-1.879a1 1 0 0 1 1.414 1.414L12 15.586z" />
                                        <path
                                            d="M18 21H6a3 3 0 0 1-3-3V11a1 1 0 0 1 2 0v7a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-7a1 1 0 0 1 2 0v7a3 3 0 0 1-3 3z" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                    {{-- </div>
                <div class="container px-4 col-12 col-lg-3 col-md-6">
                    <div class="tarjeta-marco">
                        <div class="imagen">
                            <img src="{{ asset('img/PortadaFormulacionProgramaDerSec.jpg') }}"
                                alt="Portada de Documento Manual de Programas Derivados Sectoriales"
                                title="Manual de Programas Derivados Sectoriales">
                        </div>
                        <div class="contenedor-boton">
                            <a href="{{ asset('documentos/capacitaciones-derivados/FormulaciondelProgramaSectorialBuenGobiernoHonestoydeResultados.pdf') }}"
                                target="_blank" class="btn-descargar" title="Manual de Programas Derivados Sectoriales">
                                <span class="btn-descargar__texto">Consultar documento</span>

                                <span class="btn-descargar__icono">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 15.586l-4.293-4.293a1 1 0 0 1 1.414-1.414L11 11.586V4a1 1 0 0 1 2 0v7.586l1.879-1.879a1 1 0 0 1 1.414 1.414L12 15.586z" />
                                        <path
                                            d="M18 21H6a3 3 0 0 1-3-3V11a1 1 0 0 1 2 0v7a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-7a1 1 0 0 1 2 0v7a3 3 0 0 1-3 3z" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div> --}}
                </div>
            </div>
    </section>
@endsection

@push('scripts')
@endpush
