@extends('layouts.plantilla')
@section('title', 'Página 404')
@section('meta-description', 'Página 404 del Sistema Estatal de Planeación Democrática del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'Página 404 - Sistema Estatal de Planeación Democrática')
@section('og-description', 'Página 404 del Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'Página 404 - Sistema Estatal de Planeación Democrática')
@section('twitter-description', 'Página 404 del Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('css')
@endsection
@section('content')

    <main id="#" class="">
        <div class="container">
            <div class="envoltura-404">
                <div class="error-404">
                    <div class="number-404">4</div>
                    <div class="illustration-404">
                        <div class="circle"></div>
                        <div class="clip">
                            <div class="paper">
                                <div class="face">
                                    <div class="eyes">
                                        <div class="eye eye__left"></div>
                                        <div class="eye eye__right"></div>
                                    </div>
                                    <div class="cheeks cheeks__left"></div>
                                    <div class="cheeks cheeks__right"></div>
                                    <div class="mouth"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="number-404">4</div>
                </div>
                <div class="texto-404">
                    Oops. La página que estás buscando no se encuentra. Esto se puede deber a los siguientes
                    motivos:
                    <ul>
                        <li>
                            Ha cambiado de nombre
                        </li>
                        <li>
                            Está temporalmente fuera de línea
                        </li>
                        <li>
                            Ha sido removida
                        </li>
                        <li>
                            Un marcador o favorito caducado
                        </li>
                        <li>
                            Una dirección mal escrita
                        </li>
                        <li>
                            Un motor de búsquedas que tiene un listado caducado para este sitio
                        </li>
                        <li>
                            Usted no tiene acceso a esta página
                        </li>
                    </ul>
                    Prueba revisar la página, o usa nuestro menú superior.
                    <br>
                    Tambien puede ir a la página de inicio dando clic en el menú superior.
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
@endpush
