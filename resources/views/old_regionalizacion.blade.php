@extends('layouts.plantilla')
@section('title', 'Regionalización')
@section('meta-description', 'Visión general de las regiones del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'Regionalización - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Bienvenido a la página de visión general de las regiones del estado, parte del Sistema
    Estatal de Planeación Democrática del Estado de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'Regionalización - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
    'Bienvenido a la página de visión general de las regiones del estado, parte del Sistema
    Estatal de Planeación Democrática del Estado de Puebla.')
@section('css')
<style>
    .table>:not(caption)>*>* {
        padding: .1rem .1rem !important;
    }
</style>
@endsection
@section('content')
    <section class="coplademun-regiones" id="regionalizacion">
        <div class="container-fluid bg-breadcrumb-regionalizacion">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h3 class="text-black display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">
                    Regionalización
                </h3>
                <ol class="breadcrumb justify-content-center text-white mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-black" rel="noopener">
                            Inicio
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" class="text-black">
                            Regionalización
                        </a>
                    </li>
                </ol>
            </div>
        </div>
        <div class="col py-4">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-white text-uppercase h6_planeader">
                    Conoce las
                </h6>
                <h1 class="subtitulo_sitios text-white">
                    Regiones del estado
                </h1>
                <div class="container text-white">
                    Bienvenidos a la sección de Regionalización del Portal de Planeación para el Desarrollo del Estado
                    de Puebla. Aquí podrás explorar un mapa interactivo que te permitirá conocer de manera sencilla las
                    distintas regiones del estado y los municipios que las componen. Nuestro objetivo es facilitar la
                    identificación de cada región y promover un entendimiento más claro de la estructura territorial de
                    Puebla para fomentar un desarrollo equilibrado y sostenible.
                </div>
            </div>
        </div>
        <div class="container mx-auto py-4">
            <div class="row">
                <div class="col-md-4">
                    <article class="leaderboard main-article-regionalizacion">
                        <header>
                            <img src="{{ asset('Regiones/mapas/Mapa_puebla_gris.png') }}"
                                class="imagen-header-tabla-regiones" title="Mapa de Puebla en gris"
                                alt="Mapa de Puebla en gris">
                            <h2 class="leaderboard__title">
                                <span class="leaderboard__title--top">
                                    Regiones
                                </span>
                            </h2>
                        </header>
                        <table class="table tabla-regiones">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="container bg-light rounded">
                                            <input id="buscar-regiones" type="text" onkeyup="searchNames()"
                                                placeholder="Buscar por nombre...">
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick="clickaction(this)" id="Xicotepec">
                                            <img src="{{ asset('Regiones/regiones_01.png') }}" alt="Xicotepec"
                                                class="leaderboard__picture"
                                                title="Ubicación de la Región 1 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">1. Xicotepec</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Huauchinango">
                                            <img src="{{ asset('Regiones/regiones_02.png') }}" alt="Huauchinango"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 2 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">2. Huauchinango</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Zacatlan">
                                            <img src="{{ asset('Regiones/regiones_03.png') }}" alt="Zacatlan"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 3 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">3. Zacatlán</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Huehuetlan">
                                            <img src="{{ asset('Regiones/regiones_04.png') }}" alt="Huehuetlan"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 4 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">4. Huehuetla</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Zacapoaxtla">
                                            <img src="{{ asset('Regiones/regiones_05.png') }}" alt="Zacapoaxtla"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 5 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">5. Zacapoaxtla</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Teziutlán">
                                            <img src="{{ asset('Regiones/regiones_06.png') }}" alt="Teziutlán"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 6 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">6. Teziutlán</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Chignahuapan">
                                            <img src="{{ asset('Regiones/regiones_07.png') }}" alt="Chignahuapan"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 7 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">7. Chignahuapan</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Libres">
                                            <img src="{{ asset('Regiones/regiones_08.png') }}" alt="Libres"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 8 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">8. Libres</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Quimixtlán">
                                            <img src="{{ asset('Regiones/regiones_09.png') }}" alt="Quimixtlán"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 9 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">9. Quimixtlán</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Acatzingo">
                                            <img src="{{ asset('Regiones/regiones_10.png') }}" alt="Acatzingo"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 10 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">10. Acatzingo</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this)
                                            id="Ciudad_Serdán">
                                            <img src="{{ asset('Regiones/regiones_11.png') }}" alt="Ciudad Serdán"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 11 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">11. Ciudad Serdán</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Tecamachalco">
                                            <img src="{{ asset('Regiones/regiones_12.png') }}" alt="Tecamachalco"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 12 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">12. Tecamachalco</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Tehuacán">
                                            <img src="{{ asset('Regiones/regiones_13.png') }}" alt="Tehuacán"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 13 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">13. Tehuacán</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Sierra_Negra">
                                            <img src="{{ asset('Regiones/regiones_14.png') }}" alt="Sierra Negra"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 14 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">14. Sierra Negra</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Izúcar">
                                            <img src="{{ asset('Regiones/regiones_15.png') }}" alt="Izúcar"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 15 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">15. Izúcar de Matamoros</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Chiautla">
                                            <img src="{{ asset('Regiones/regiones_16.png') }}" alt="Chiautla"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 16 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">16. Chiautla</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Acatlán">
                                            <img src="{{ asset('Regiones/regiones_17.png') }}" alt="Acatlán"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 17 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">17. Acatlán</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Tepexi">
                                            <img src="{{ asset('Regiones/regiones_18.png') }}" alt="Tepexi"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 18 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">18. Tepexi de Rodríguez</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Atlixco">
                                            <img src="{{ asset('Regiones/regiones_19.png') }}" alt="Atlixco"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 19 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">19. Atlixco</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Texmelucan">
                                            <img src="{{ asset('Regiones/regiones_20.png') }}" alt="Texmelucan"
                                                class="leaderboard__picture "
                                                title="Ubicación de la Región 20 en el Mapa de Puebla">
                                            <h3 class="leaderboard__name">20. San Martín Texmelucan</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Puebla">
                                            <img src="{{ asset('Regiones/regiones_21.png') }}" alt="Puebla"
                                                title="Ubicación de la Región 21 en el Mapa de Puebla"
                                                class="leaderboard__picture ">
                                            <h3 class="leaderboard__name">21. Área Metropolitana de Puebla</h3>
                                        </article>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Tepeaca">
                                            <img src="{{ asset('Regiones/regiones_22.png') }}" alt="Tepeaca"
                                                title="Ubicación de la Región 22 en el Mapa de Puebla"
                                                class="leaderboard__picture ">
                                            <h3 class="leaderboard__name">22. Tepeaca</h3>
                                        </article>
                                    </td>
                                </tr>
                            </tbody>
                            {{-- <main class="leaderboard__profiles">
                                <div class="container">
                                    <input type="text" id="searchInput" onkeyup="searchNames()"
                                        placeholder="Buscar por nombre..."
                                        style="margin-top: 3%; margin-bottom:0; margin-left:1%">
                                </div>
                                <tr>
                                    <td>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Xicotepec">
                                            <img src="{{ asset('Regiones/regiones_01.png') }}" width="100%"
                                                alt="Xicotepec" class="leaderboard__picture"
                                                title="Ubicación de la Región 1 en el Mapa de Puebla">
                                            <span class="leaderboard__name">1. Xicotepec</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Huauchinango">
                                            <img src="{{ asset('Regiones/regiones_02.png') }}" width="100%"
                                                alt="Huauchinango" class="leaderboard__picture"
                                                title="Ubicación de la Región 2 en el Mapa de Puebla">
                                            <span class="leaderboard__name">2. Huauchinango</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Zacatlan">
                                            <img src="{{ asset('Regiones/regiones_03.png') }}" width="100%" alt="Zacatlan"
                                                class="leaderboard__picture"
                                                title="Ubicación de la Región 3 en el Mapa de Puebla">
                                            <span class="leaderboard__name">3. Zacatlán</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Huehuetlan">
                                            <img src="{{ asset('Regiones/regiones_04.png') }}" width="100%"
                                                alt="Huehuetlan" class="leaderboard__picture"
                                                title="Ubicación de la Región 4 en el Mapa de Puebla">
                                            <span class="leaderboard__name">4. Huehuetla</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Zacapoaxtla">
                                            <img src="{{ asset('Regiones/regiones_05.png') }}" width="100%"
                                                alt="Zacapoaxtla" class="leaderboard__picture"
                                                title="Ubicación de la Región 5 en el Mapa de Puebla">
                                            <span class="leaderboard__name">5. Zacapoaxtla</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Teziutlán">
                                            <img src="{{ asset('Regiones/regiones_06.png') }}" width="100%"
                                                alt="Teziutlán" class="leaderboard__picture"
                                                title="Ubicación de la Región 6 en el Mapa de Puebla">
                                            <span class="leaderboard__name">6. Teziutlán</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Chignahuapan">
                                            <img src="{{ asset('Regiones/regiones_07.png') }}" width="100%"
                                                alt="Chignahuapan" class="leaderboard__picture"
                                                title="Ubicación de la Región 7 en el Mapa de Puebla">
                                            <span class="leaderboard__name">7. Chignahuapan</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Libres">
                                            <img src="{{ asset('Regiones/regiones_08.png') }}" width="100%"
                                                alt="Libres" class="leaderboard__picture"
                                                title="Ubicación de la Región 8 en el Mapa de Puebla">
                                            <span class="leaderboard__name">8. Libres</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Quimixtlán">
                                            <img src="{{ asset('Regiones/regiones_09.png') }}" width="100%"
                                                alt="Quimixtlán" class="leaderboard__picture"
                                                title="Ubicación de la Región 9 en el Mapa de Puebla">
                                            <span class="leaderboard__name">9. Quimixtlán</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Acatzingo">
                                            <img src="{{ asset('Regiones/regiones_10.png') }}" width="100%"
                                                alt="Acatzingo" class="leaderboard__picture"
                                                title="Ubicación de la Región 10 en el Mapa de Puebla">
                                            <span class="leaderboard__name">10. Acatzingo</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this)
                                            id="Ciudad_Serdán">
                                            <img src="{{ asset('Regiones/regiones_11.png') }}" width="100%"
                                                alt="Ciudad Serdán" class="leaderboard__picture"
                                                title="Ubicación de la Región 11 en el Mapa de Puebla">
                                            <span class="leaderboard__name">11. Ciudad Serdán</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Tecamachalco">
                                            <img src="{{ asset('Regiones/regiones_12.png') }}" width="100%"
                                                alt="Tecamachalco" class="leaderboard__picture"
                                                title="Ubicación de la Región 12 en el Mapa de Puebla">
                                            <span class="leaderboard__name">12. Tecamachalco</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Tehuacán">
                                            <img src="{{ asset('Regiones/regiones_13.png') }}" width="100%"
                                                alt="Tehuacán" class="leaderboard__picture"
                                                title="Ubicación de la Región 13 en el Mapa de Puebla">
                                            <span class="leaderboard__name">13. Tehuacán</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Sierra_Negra">
                                            <img src="{{ asset('Regiones/regiones_14.png') }}" width="100%"
                                                alt="Sierra Negra" class="leaderboard__picture"
                                                title="Ubicación de la Región 14 en el Mapa de Puebla">
                                            <span class="leaderboard__name">14. Sierra Negra</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Izúcar">
                                            <img src="{{ asset('Regiones/regiones_15.png') }}" width="100%"
                                                alt="Izúcar" class="leaderboard__picture"
                                                title="Ubicación de la Región 15 en el Mapa de Puebla">
                                            <span class="leaderboard__name">15. Izúcar de Matamoros</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Chiautla">
                                            <img src="{{ asset('Regiones/regiones_16.png') }}" width="100%"
                                                alt="Chiautla" class="leaderboard__picture"
                                                title="Ubicación de la Región 16 en el Mapa de Puebla">
                                            <span class="leaderboard__name">16. Chiautla</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Acatlán">
                                            <img src="{{ asset('Regiones/regiones_17.png') }}" width="100%"
                                                alt="Acatlán" class="leaderboard__picture"
                                                title="Ubicación de la Región 17 en el Mapa de Puebla">
                                            <span class="leaderboard__name">17. Acatlán</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Tepexi">
                                            <img src="{{ asset('Regiones/regiones_18.png') }}" width="100%"
                                                alt="Tepexi" class="leaderboard__picture"
                                                title="Ubicación de la Región 18 en el Mapa de Puebla">
                                            <span class="leaderboard__name">18. Tepexi de Rodríguez</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Atlixco">
                                            <img src="{{ asset('Regiones/regiones_19.png') }}" width="100%"
                                                alt="Atlixco" class="leaderboard__picture"
                                                title="Ubicación de la Región 19 en el Mapa de Puebla">
                                            <span class="leaderboard__name">19. Atlixco</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Texmelucan">
                                            <img src="{{ asset('Regiones/regiones_20.png') }}" width="100%"
                                                alt="Texmelucan" class="leaderboard__picture"
                                                title="Ubicación de la Región 20 en el Mapa de Puebla">
                                            <span class="leaderboard__name">20. San Martín Texmelucan</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Puebla">
                                            <img src="{{ asset('Regiones/regiones_21.png') }}" width="100%"
                                                alt="Puebla" title="Ubicación de la Región 21 en el Mapa de Puebla"
                                                class="leaderboard__picture">
                                            <span class="leaderboard__name">21. Área Metropolitana de Puebla</span>
                                        </article>
                                        <article class="leaderboard__profile" onclick=clickaction(this) id="Tepeaca">
                                            <img src="{{ asset('Regiones/regiones_22.png') }}" width="100%"
                                                alt="Tepeaca" title="Ubicación de la Región 22 en el Mapa de Puebla"
                                                class="leaderboard__picture">
                                            <span class="leaderboard__name">22. Tepeaca</span>
                                        </article>
                                    </td>
                                </tr>
                            </main> --}}
                        </table>
                    </article>
                </div>
                <div class="col-md-8" id="mapa">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <div class="container">
                                <img class="img-fluid w-90p" src="{{ asset('Regiones/mapas/Mapa_Puebla_2.png') }}"
                                    id="mapa_general" alt="Mapa de Puebla a grises con las regiones del estado">
                                <img class="img-fluid w-90p" src="{{ asset('Regiones/mapas/Region_1_Xicotepec.png') }}"
                                    id="mapa_01" style="display:none;" alt="Mapa de Puebla resaltado con la región 1"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p"
                                    src="{{ asset('Regiones/mapas/Region_2_Huauchinango.png') }}" id="mapa_02"
                                    style="display:none;" alt="Mapa de Puebla resaltado con la región 2"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p" src="{{ asset('Regiones/mapas/Region_3_Zacatlán.png') }}"
                                    id="mapa_03" style="display:none;" alt="Mapa de Puebla resaltado con la región 3"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p" src="{{ asset('Regiones/mapas/Region_4_Huehuetla.png') }}"
                                    id="mapa_04" style="display:none;" alt="Mapa de Puebla resaltado con la región 4"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p" src="{{ asset('Regiones/mapas/Region_5_Zacapoaxtla.png') }}"
                                    id="mapa_05" style="display:none;" alt="Mapa de Puebla resaltado con la región 5"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p" src="{{ asset('Regiones/mapas/Region_6_Teziutlán.png') }}"
                                    id="mapa_06" style="display:none;" alt="Mapa de Puebla resaltado con la región 6"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p"
                                    src="{{ asset('Regiones/mapas/Region_7_Chignahuapan.png') }}" id="mapa_07"
                                    style="display:none;" alt="Mapa de Puebla resaltado con la región 7"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p" src="{{ asset('Regiones/mapas/Region_8_Libres.png') }}"
                                    id="mapa_08" style="display:none;" alt="Mapa de Puebla resaltado con la región 8"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p" src="{{ asset('Regiones/mapas/Region_9_Quimixtlán.png') }}"
                                    id="mapa_09" style="display:none;" alt="Mapa de Puebla resaltado con la región 9"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p" src="{{ asset('Regiones/mapas/Region_10_Acatzingo.png') }}"
                                    id="mapa_10" style="display:none;" alt="Mapa de Puebla resaltado con la región 10"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p"
                                    src="{{ asset('Regiones/mapas/Region_11_Ciudad_Serdán.png') }}" id="mapa_11"
                                    style="display:none;" alt="Mapa de Puebla resaltado con la región 11"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p"
                                    src="{{ asset('Regiones/mapas/Region_12_Tecamachalco.png') }}" id="mapa_12"
                                    style="display:none;" alt="Mapa de Puebla resaltado con la región 12"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p" src="{{ asset('Regiones/mapas/Region_13_Tehuacán.png') }}"
                                    id="mapa_13" style="display:none;" alt="Mapa de Puebla resaltado con la región 13"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p"
                                    src="{{ asset('Regiones/mapas/Region_14_Sierra_Negra.png') }}" id="mapa_14"
                                    style="display:none;" alt="Mapa de Puebla resaltado con la región 14"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p"
                                    src="{{ asset('Regiones/mapas/Region_15_Izúcar_de_Matamoros.png') }}" id="mapa_15"
                                    style="display:none;" alt="Mapa de Puebla resaltado con la región 15"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p" src="{{ asset('Regiones/mapas/Region_16_Chiautla.png') }}"
                                    id="mapa_16" style="display:none;" alt="Mapa de Puebla resaltado con la región 16"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p" src="{{ asset('Regiones/mapas/Region_17_Acatlán.png') }}"
                                    id="mapa_17" style="display:none;" alt="Mapa de Puebla resaltado con la región 17"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p"
                                    src="{{ asset('Regiones/mapas/Region_18_Tepexi_de_Rodríguez.png') }}" id="mapa_18"
                                    style="display:none;" alt="Mapa de Puebla resaltado con la región 18"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p" src="{{ asset('Regiones/mapas/Region_19_Atlixco.png') }}"
                                    id="mapa_19" style="display:none;" alt="Mapa de Puebla resaltado con la región 19"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p"
                                    src="{{ asset('Regiones/mapas/Region_20_San_Martín_Texmelucan.png') }}"
                                    id="mapa_20" style="display:none;" alt="Mapa de Puebla resaltado con la región 20"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p"
                                    src="{{ asset('Regiones/mapas/Region_21_Área_Metropolitana_de_la_Ciudad_de_Puebla.png') }}"
                                    id="mapa_21" style="display:none;" alt="Mapa de Puebla resaltado con la región 21"
                                    title="Región número de Puebla">
                                <img class="img-fluid w-90p" src="{{ asset('Regiones/mapas/Region_22_Tepeaca.png') }}"
                                    id="mapa_22" style="display:none;" alt="Mapa de Puebla resaltado con la región 22"
                                    title="Región número de Puebla">
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            </div> --}}
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region1" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region01.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 1. Xicotepec</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Xicotepec se encuentra en
                                la
                                sierra norte del
                                estado y colinda al norte y al este con el estado de Veracruz, al sur con la región de
                                Huauchinango y al oeste con el estado de Hidalgo; esta región se conforma por 11
                                municipios:
                            </p>
                            &nbsp;
                            @php
                                $municipios_region1 = App\Models\Municipio::where('region_id', '1')->get();
                            @endphp
                            @if ($municipios_region1->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region1 as $municipio1)
                                        <li class="text-dark">
                                            {{ $municipio1->id }} {{ $municipio1->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-8 regiones" id="region2" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region02.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 2. Huauchinango</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Huauchinango se encuentra
                                en la sierra norte del
                                estado y colinda con la región de Huauchinango al norte, con Zacatlán al sur, con el
                                estado
                                de Hidalgo al oeste y con Huehuetla al este; esta región se conforma por 7 municipios:
                            </p>
                            &nbsp;
                            @php
                                $municipios_region2 = App\Models\Municipio::where('region_id', '2')->get();
                            @endphp
                            @if ($municipios_region2->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region2 as $municipio2)
                                        <li class="text-dark">
                                            {{ $municipio2->id }} {{ $municipio2->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region3" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region03.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 3. Zacatlán</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Zacatlán se encuentra en la
                                sierra norte del
                                estado
                                y colinda con la región de Huauchinango al norte, al este con la región de Huehuetla y
                                al
                                oeste con el estado de Hidalgo; esta región se conforma por 9 municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region3 = App\Models\Municipio::where('region_id', '3')->get();
                            @endphp
                            @if ($municipios_region3->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region3 as $municipio3)
                                        <li class="text-dark">
                                            {{ $municipio3->id }} {{ $municipio3->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region4" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region04.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 4. Huehuetla</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Huehuetla se encuentra en
                                la sierra norte del
                                estado y colinda al norte, con el estado de Veracruz, al sur con la región de
                                Zacapoaxtla,
                                al este con Veracruz y al oeste con la región Zacatlán; esta región se conforma por 10
                                municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region4 = App\Models\Municipio::where('region_id', '4')->get();
                            @endphp
                            @if ($municipios_region4->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region4 as $municipio4)
                                        <li class="text-dark">
                                            {{ $municipio4->id }} {{ $municipio4->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region5" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region05.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 5. Zacapoaxtla</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Zacapoaxtla se encuentra en
                                la sierra nororiental
                                del estado y colinda al norte, con el estado de Veracruz, al sur con la región de
                                Libres, al
                                este con la región Teziutlán y al oeste con la región Huehuetla; esta región se conforma
                                por
                                9 municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region5 = App\Models\Municipio::where('region_id', '5')->get();
                            @endphp
                            @if ($municipios_region5->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region5 as $municipio5)
                                        <li class="text-dark">
                                            {{ $municipio5->id }} {{ $municipio5->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region6" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region06.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 6. Teziutlán</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Teziutlán se encuentra en
                                la sierra nororiental
                                del
                                estado y colinda al norte, con el estado de Veracruz, al sur con la región de Libres, al
                                este con el estado de Veracruz y al oeste con la región Zacapoaxtla; esta región se
                                conforma
                                por 12 municipios.</p>
                            &nbsp;
                            @php
                                $municipios_region6 = App\Models\Municipio::where('region_id', '6')->get();
                            @endphp
                            @if ($municipios_region4->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region6 as $municipio6)
                                        <li class="text-dark">
                                            {{ $municipio6->id }} {{ $municipio6->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region7" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region07.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 7. Chignahuapan</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Chignahuapan se encuentra
                                en la sierra norte del
                                estado y colinda al norte, con la región de Zacatlán, al sur con el estado de Tlaxcala,
                                al
                                oeste con el estado de Hidalgo y al poniente con la región Zacapoaxtla; esta región se
                                conforma por 5 municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region7 = App\Models\Municipio::where('region_id', '7')->get();
                            @endphp
                            @if ($municipios_region4->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region7 as $municipio7)
                                        <li class="text-dark">
                                            {{ $municipio7->id }} {{ $municipio7->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region8" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region08.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 8. Libres</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Libres se encuentra en la
                                parte centro norte del
                                estado y colinda al norte, con la región de Chignahuapan, al sur con el estado de
                                Tlaxcala,
                                al este con el estado de Veracruz y al oeste con Tlaxcala esta región se conforma por 11
                                municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region8 = App\Models\Municipio::where('region_id', '8')->get();
                            @endphp
                            @if ($municipios_region8->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region8 as $municipio8)
                                        <li class="text-dark">
                                            {{ $municipio8->id }} {{ $municipio8->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region9" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region09.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 9. Quimixtlán</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Quimixtlán se encuentra en
                                la parte centro-este
                                del
                                estado y colinda al norte, con el estado de Veracruz, al sur con la región Ciudad
                                Serdán, el
                                este con el estado de Veracruz y al oeste con la región de Libres, esta región se
                                conforma
                                por 7 municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region9 = App\Models\Municipio::where('region_id', '9')->get();
                            @endphp
                            @if ($municipios_region9->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region9 as $municipio9)
                                        <li class="text-dark">
                                            {{ $municipio9->id }} {{ $municipio9->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region10" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region10.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 10. Acatzingo</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Acatzingo se encuentra en
                                la parte central del
                                estado y colinda al norte, con la región de Libres, al sur con la región de Tecamachalco
                                y
                                al oeste con la región de Tepeaca, esta región se conforma por 6 municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region10 = App\Models\Municipio::where('region_id', '10')->get();
                            @endphp
                            @if ($municipios_region4->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region10 as $municipio10)
                                        <li class="text-dark">
                                            {{ $municipio10->id }} {{ $municipio10->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region11" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region11.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 11. Ciudad Serdán</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Ciudad Serdán se encuentra
                                en la parte centro este
                                del estado y colinda al norte, con la región de Quimixtlán, al sur con la región de
                                Tehuacán, al este con el estado de Veracruz y al oeste con la región de Tecamachalco,
                                esta
                                región se conforma por 7 municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region11 = App\Models\Municipio::where('region_id', '11')->get();
                            @endphp
                            @if ($municipios_region11->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region11 as $municipio11)
                                        <li class="text-dark">
                                            {{ $municipio11->id }} {{ $municipio11->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region12" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region12.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 12. Tecamachalco</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Tecamachalco se encuentra
                                en la parte sureste del
                                estado y colinda al norte, con la región de Acatzingo, al sur con la región de Tepexi de
                                Rodríguez, al este con la región de Tehuacán y al oeste con la región de Tepeaca, esta
                                región se conforma por 5 municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region12 = App\Models\Municipio::where('region_id', '12')->get();
                            @endphp
                            @if ($municipios_region12->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region12 as $municipio12)
                                        <li class="text-dark">
                                            {{ $municipio12->id }} {{ $municipio12->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region13" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region13.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 13. Tehuacán</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Tehuacán se encuentra en la
                                parte sureste del
                                estado y colinda al norte, con el estado de Veracruz, al sur con el estado de Oaxaca, al
                                este con la región de Sierra Negra y al oeste con el estado de Oaxaca, esta región se
                                conforma por 13 municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region13 = App\Models\Municipio::where('region_id', '13')->get();
                            @endphp
                            @if ($municipios_region13->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region13 as $municipio13)
                                        <li class="text-dark">
                                            {{ $municipio13->id }} {{ $municipio13->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region14" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region14.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 14. Sierra Negra</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región Sierra Negra se encuentra en
                                la parte sureste del
                                estado y colinda al norte, con el estado de Veracruz, al sur con el estado de Oaxaca, al
                                este con el estado de Veracruz y al oeste con la región de Tehuacán, esta región se
                                conforma
                                por 6 municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region14 = App\Models\Municipio::where('region_id', '14')->get();
                            @endphp
                            @if ($municipios_region14->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region14 as $municipio14)
                                        <li class="text-dark">
                                            {{ $municipio14->id }} {{ $municipio14->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region15" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region15.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 15. Izúcar de Matamoros</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Izúcar de Matamoros se
                                encuentra en la parte
                                suroeste del estado y colinda al norte con la región de Atlixco, al sur con la región de
                                Chiautla, al este con la región de Tepexi de Rodríguez y al oeste con el estado de
                                Morelos
                                esta región se conforma por 13 municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region15 = App\Models\Municipio::where('region_id', '15')->get();
                            @endphp
                            @if ($municipios_region15->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region15 as $municipio15)
                                        <li class="text-dark">
                                            {{ $municipio15->id }} {{ $municipio15->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region16" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region16.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 16. Chiautla</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Chiautla se encuentra en la
                                parte suroeste del
                                estado y colinda al norte, con el estado de Morelos al sur con el estado de Guerrero, al
                                este con la región de Acatlán y al oeste con el estado de Morelos esta región se
                                conforma
                                por 9 municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region16 = App\Models\Municipio::where('region_id', '16')->get();
                            @endphp
                            @if ($municipios_region16->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region16 as $municipio16)
                                        <li class="text-dark">
                                            {{ $municipio16->id }} {{ $municipio16->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region17" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region17.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 17. Acatlán</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Acatlán se encuentra en la
                                parte sur del estado y
                                colinda al norte, con la región de Tepexi de Rodríguez, al sur y al este con el estado
                                de
                                Oaxaca y al oeste con la región de Chiautla esta región se conforma por 17 municipios:
                            </p>
                            &nbsp;
                            @php
                                $municipios_region17 = App\Models\Municipio::where('region_id', '17')->get();
                            @endphp
                            @if ($municipios_region17->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region17 as $municipio17)
                                        <li class="text-dark">
                                            {{ $municipio17->id }} {{ $municipio17->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region18" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region18.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 18. Tepexi de Rodríguez</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Tepexi de Rodríguez se
                                encuentra en la parte sur
                                del estado y colinda al norte, con la región de Tecamachalco, al sur con la región de
                                Acatlán, al este con la región de Tehuacán y al oeste con la región de Izúcar de
                                Matamoros
                                esta región se conforma por 16 municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region18 = App\Models\Municipio::where('region_id', '18')->get();
                            @endphp
                            @if ($municipios_region18->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region18 as $municipio18)
                                        <li class="text-dark">
                                            {{ $municipio18->id }} {{ $municipio18->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region19" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region19.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 19. Atlixco</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Atlixco se encuentra en la
                                parte centro oeste del
                                estado y colinda al norte, con la región de San Martín Texmelucan, al sur con la región
                                de
                                Izúcar de Matamoros, al este con la región Área Metropolitana de la Ciudad de Puebla y
                                al
                                oeste con el estado de Morelos esta región se conforma por 10 municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region19 = App\Models\Municipio::where('region_id', '19')->get();
                            @endphp
                            @if ($municipios_region19->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region19 as $municipio19)
                                        <li class="text-dark">
                                            {{ $municipio19->id }} {{ $municipio19->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region20" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region20.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 20. San Martín Texmelucan</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de San Martín Texmelucan se
                                encuentra en la parte
                                centro oeste del estado y colinda al norte con el estado de Tlaxcala, al sur con la
                                región
                                de Atlixco, al este con la región Área Metropolitana de la Ciudad de Puebla y al oeste
                                con
                                el Estado de México esta región se conforma por 11 municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region20 = App\Models\Municipio::where('region_id', '20')->get();
                            @endphp
                            @if ($municipios_region20->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region20 as $municipio20)
                                        <li class="text-dark">
                                            {{ $municipio20->id }} {{ $municipio20->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region21" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region21.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 21. Área Metropolitana de Puebla</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región Área Metropolitana de la
                                Ciudad de Puebla se
                                encuentra
                                en la parte centro oeste del estado y colinda al norte con el estado de Tlaxcala, al sur
                                con
                                la región de Tepexi de Rodríguez, al este con la región de Tepeaca y al oeste con la
                                región
                                de San Martín Texmelucan esta región se conforma por 11 municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region21 = App\Models\Municipio::where('region_id', '21')->get();
                            @endphp
                            @if ($municipios_region21->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region21 as $municipio21)
                                        <li class="text-dark">
                                            {{ $municipio21->id }} {{ $municipio21->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8 regiones" id="region22" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="img-fluid w-100" src="{{ asset('Regiones/mapas/Mapa_region22.png') }}"
                                title="Mapa de la Region con sus municipios"
                                alt="Mapa con las demarcaciones municipales de la región">
                        </div>
                        <div class="col-md-4">
                            <h2 class="text-white">Región 22. Tepeaca</h2>
                            &nbsp;
                            <p class="text-white" style="text-align:justify;">La región de Tepeaca se encuentra en la
                                parte centro del estado
                                y colinda al norte con el estado de Tlaxcala, al sur con la región de Tepexi de
                                Rodríguez,
                                al este con la región de Acatzingo y al oeste con la región Área Metropolitana de la
                                Ciudad
                                de Puebla esta región se conforma por 12 municipios:</p>
                            &nbsp;
                            @php
                                $municipios_region22 = App\Models\Municipio::where('region_id', '22')->get();
                            @endphp
                            @if ($municipios_region22->isEmpty())
                                <div class="container">
                                    <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                        ¡Algo anda mal! No se cargaron los municipios para esta región
                                    </h3>
                                </div>
                            @else
                                <ul class="neumorphic-list">
                                    @foreach ($municipios_region22 as $municipio22)
                                        <li class="text-dark">
                                            {{ $municipio22->id }} {{ $municipio22->nombre }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mx-auto py-4 ">
            <h2 class="subtitulo_sitios text-white text-center">
                Base de datos de las regiones
            </h2>
            <p class="text-center text-white">
                Aquí podrás descargar la base de datos con la relación de las regiones y
                sus municipios
            </p>
            <div class="container d-flex justify-content-center">
                <a class="btn-download w-25" href="{{ asset('documentos/Regiones_y_municipios.xlsx') }}"
                    download="">
                    Descargar Documento
                    <i style="margin-right: 5px;" class="fas fa-download"></i>
                    <img class="justify-items-center w-9p" src="{{ asset('imagen/excel.png') }}" alt="imagen de excel">
                </a>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    function searchNames() {
        // Obtener el valor del input de búsqueda
        var input = document.getElementById('buscar-regiones');
        var filter = input.value.toUpperCase();

        // Obtener todos los elementos <article> con la clase .leaderboard__profile
        var articles = document.querySelectorAll('.leaderboard__profile');
        
        // Recorrer los artículos y mostrar u ocultar los <tr> según coincidan con la búsqueda
        articles.forEach(function(article) {
            var name = article.querySelector('.leaderboard__name');
            var trElement = article.closest('tr');  // Obtener el <tr> más cercano
            if (name.innerHTML.toUpperCase().indexOf(filter) > -1) {
                trElement.style.display = '';  // Mostrar el <tr>
            } else {
                trElement.style.display = 'none';  // Ocultar el <tr>
            }
        });
    }
</script>

    <script src="{{ asset('web/js/mostrar-regiones.js') }}"></script>
@endsection
