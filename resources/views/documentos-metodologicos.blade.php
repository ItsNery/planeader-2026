@extends('layouts.plantilla')
@section('title', 'Documentos metodológicos del COPLADEMUN')
@section('meta-description',
    'Página principal de los documentos metodológicos del Comité de Planeación Municipal del
    Sistema Estatal de Planeación Democrática del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'Documentos Metodológicos del COPLADEMUN - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Página principal de los documentos metodológicos del Comité de Planeación Municipal del
    Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'Documentos Metodológicos del COPLADEMUN - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
    'Página principal de los documentos metodológicos del Comité de Planeación Municipal del
    Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('css')
@endsection

@section('content')
    <section class="contenedor-imagen-docsmetodologicos">
        <h1>Documentos metodológicos</h1>
    </section>
    <section class="documentos-metodologicos">
        <div class="container">
            <p class="corra-light text-justify my-5">
                Herramientas de apoyo técnico y metodológico para la integración de
                documentos municipales en materia de evaluación y planeación.
            </p>
            <div class="row my-5">
                @foreach ($documentos as $documento)
                    <div class="mx-auto px-4 py-4 col-lg-4 col-md-6 col-sm-12 col-12">
                        <x-tarjeta-documento 
                            :titulo="$documento->titulo"
                            :imagen="$documento->imagen"
                            :archivo="$documento->ruta_documento"
                            rutaBase="documentos/metodologicos"
                            rutaImagenBase="imagen/metodologicos"
                        />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    </section>
@endsection

@section('scripts')
@endsection
