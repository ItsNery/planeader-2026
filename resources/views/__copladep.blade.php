@extends('layouts.plantilla')
@section('title', 'Comité de Planeación para el Desarrollo del Estado de Puebla')
@section('meta-description',
    'Visión general del Comité de Planeación para el Desarrollo del Estado de Puebla del
    Sistema Estatal de Planeación Democrática del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'COPLADEP - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Bienvenido a la página de visión general del Comité de Planeación para el Desarrollo del
    Estado de Puebla del Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'COPLADEP - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
    'Bienvenido a la página de visión general del Comité de Planeación para el Desarrollo
    del Estado de Puebla del Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('content')
    <main id="#" class="">
        <div class="carrusel">
            <div class="container-fluid p-0">
                <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <!-- Verificar si hay banners dinámicos -->
                        @if ($banners && count($banners) > 0)
                            <!-- Banners dinámicos -->
                            @foreach ($banners as $banner)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <a href="{{ $banner->enlace }}" target="_blank">
                                        <img class="w-100" src="/baners/{{ $banner->imagen }}"
                                            alt="{{ $banner->nombre }}" />
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <!-- Banner estático si no hay banners dinámicos -->
                            <div class="carousel-item active">
                                <a href="#">
                                    <img class="w-100" src="/baners/20240411231551.png" alt="Image" />
                                </a>
                            </div>
                        @endif
                    </div>
                    @if ($banners && count($banners) > 1)
                        <a title="Boton de previo" class="carousel-control-prev" href="#header-carousel"
                            data-bs-slide="prev">
                            <div class="btn btn-dark previo_next">
                                <span class="carousel-control-prev-icon mb-n2"></span>
                            </div>
                        </a>
                        <a title="Siguiente slider" class="carousel-control-next" href="#header-carousel"
                            data-bs-slide="next">
                            <div class="btn btn-dark previo_next">
                                <span class="carousel-control-next-icon mb-n2"></span>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <section class="inicio bckgrnd-gradient-home">
            <div class="container mx-auto px-4">
                <h2
                    class="font-bold text-white text-center text-5xl titulo-seccion-inicio animate__animated animate__bounce">
                    Bienvenido al COPLADEP
                </h2>
            </div>
            <div class="container text-center">
                <ul class="my-breadcrumb">
                    <li><a class="text-white" href="{{ url('/') }}" rel="noopener">Inicio</a></li>
                    <li class="text-white">COPLADEP</li>
                </ul>
                <div class="custom-divider">
                    <div class="divider-line"></div>
                    <div class="divider-arrow">&#10148;</div>
                    <div class="divider-line"></div>
                </div>
            </div>
            <div class="container-fluid services py-5">
                <div class="container">
                    <div class="row g-5 services-inner">
                        <div class="col-md-12 col-lg-12">
                            <div class="services-item-no-anim bg-light">
                                <div class="p-4 text-center services-content">
                                    <div class="services-content-icon">
                                        <div class="container">
                                            <h4 class="mb-3 text-white copladep-titulo">¿Qué es?</h4>
                                        </div>
                                        <p class="mb-4 text-justify">
                                            El Comité de Planeación para el Desarrollo del Estado de Puebla (COPLADEP) es el
                                            órgano público, colegiado e interinstitucional en materia de planeación, cuyos
                                            objetivos fundamentales son promover y coadyuvar en la formulación,
                                            actualización, instrumentación y evaluación del Plan Estatal de Desarrollo y de
                                            los programas sectoriales, especiales y regionales, mediante la participación
                                            del sector público, social y privado, en el marco del Sistema Estatal de
                                            Planeación Democrática.
                                        </p>
                                        <p>
                                            Asimismo, el COPLADEP cuenta con las siguientes atribuciones:
                                        </p>
                                        <ul>
                                            <li style="text-align:justify">
                                                Promover, con la participación de los diversos sectores de la sociedad, la
                                                elaboración y
                                                actualización del Plan Estatal de Desarrollo y los programas sectoriales,
                                                especiales y regionales, procurando que se realicen atendiendo los
                                                principios
                                                que rigen el Sistema Estatal de Planeación Democrática;
                                            </li>
                                            <li style="text-align:justify">
                                                Aprobar en asamblea plenaria el Plan Estatal de Desarrollo, dentro de los
                                                términos y
                                                plazos que fija la Ley de Planeación para el Desarrollo del Estado de
                                                Puebla;
                                            </li>
                                            <li style="text-align:justify">
                                                Acordar el establecimiento de subcomités sectoriales, especiales y
                                                regionales, los
                                                cuales actuarán como auxiliares del COPLADEP y se integrarán conforme a lo
                                                que
                                                éste determine;
                                            </li>
                                            <li style="text-align:justify">
                                                Promover el uso del Sistema Estatal de Información para la Planeación del
                                                Desarrollo del
                                                Estado;
                                            </li>
                                            <li style="text-align:justify">
                                                Promover que el control, seguimiento y evaluación del Plan Estatal de
                                                Desarrollo y de
                                                los programas sectoriales, especiales y regionales se realice con
                                                perspectiva
                                                de género, a fin de visibilizar el gasto realizado específicamente para la
                                                promoción, garantía, respeto y protección de los derechos humanos.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <div class="services-item-no-anim bg-light">
                                <div class="p-4 text-center services-content">
                                    <div class="services-content-icon">
                                        <div class="container">
                                            <h4 class="mb-3 text-white copladep-titulo">Integrantes</span>
                                            </h4>
                                        </div>
                                        <img src="{{ asset('subcomitesconformacion/COPLADEP.png') }}"
                                            alt="Integración de COPLADEP" title="Integración de COPLADEP" width="100%">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="custom-divider">
                            <div class="divider-line"></div>
                            <div class="divider-arrow">&#10148;</div>
                            <div class="divider-line"></div>
                        </div>
                        <div class="container row">
                            <div id="myModal" class="modal">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal()">
                                        <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="10" stroke="#1C274C"
                                                stroke-width="1.5" />
                                            <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="#1C274C"
                                                stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </span>
                                    <iframe src="" width="100%" height="100%"></iframe>
                                </div>
                            </div>
                            <div class="container mx-auto px-4">
                                <h3 class="font-bold text-white text-center text-5xl titulo-seccion-inicio">
                                    Documentos
                                </h3>
                            </div>
                        </div>
                        <div class="container row" style="display: flex; justify-content:center; align-items:center">
                            @php
                                $anios = App\Models\DocumentoCopladep::where('publicado', 1) // Filtrar solo los documentos que estén publicados
                                    ->select('anio')
                                    ->distinct()
                                    ->get();
                            @endphp
                            @if ($anios->isEmpty())
                                <div class="container"
                                    style="display: flex; justify-content:center; align-items:center; flex-direction:column">
                                    <img src="{{ asset('imagen/no-file.png') }}" alt="" style="width: 30%">
                                    <p class="text-white text-center pb-5">Upps, no se encontraron registros.</p>
                                </div>
                            @else
                                <div class="accordion" id="accordionExample">
                                    @foreach ($anios->sortByDesc('anio') as $anio)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading{{ $anio->anio }}">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{ $anio->anio }}" aria-expanded="false"
                                                    aria-controls="collapse{{ $anio->anio }}">
                                                    {{ $anio->anio }}
                                                </button>
                                            </h2>
                                            <div id="collapse{{ $anio->anio }}" class="accordion-collapse collapse"
                                                aria-labelledby="heading{{ $anio->anio }}"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    @php
                                                        $documentosPorTipo = App\Models\DocumentoCopladep::where(
                                                            'anio',
                                                            $anio->anio,
                                                        )
                                                            ->where('publicado', 1)
                                                            ->orderBy('tipo_documento')
                                                            ->get()
                                                            ->groupBy('tipo_documento');
                                                    @endphp
                                                    @foreach ($documentosPorTipo as $tipo => $documentos)
                                                        @if ($tipo === 'Acta')
                                                            <h4>
                                                                Actas
                                                            </h4>
                                                        @elseif ($tipo === 'Informe')
                                                            <h4>
                                                                IAT
                                                            </h4>
                                                        @elseif ($tipo === 'Programa')
                                                            <h4>
                                                                PAT
                                                            </h4>
                                                        @else
                                                            <h4>
                                                                {{ $tipo }}s
                                                            </h4>
                                                        @endif
                                                        <ul>
                                                            @foreach ($documentos as $documento)
                                                                <li>
                                                                    <a rel="noopener"
                                                                        class="text-dark no_s cursor-pointer"
                                                                        onclick="openModal('{{ asset('documentocopladep/' . $documento->ruta_documento) }}')">
                                                                        {{ $documento->nombre }}
                                                                    </a>
                                                                    <a class="no_s"
                                                                        href="{{ asset('documentocopladep/' . $documento->ruta_documento) }}"
                                                                        download="" rel="noopener">
                                                                        <img class="justify-items-center"
                                                                            title="Imagen de PDF" src="/imagen/pdf.png"
                                                                            alt="imagen de PDF" width="2%">
                                                                        <i class="fas fa-download text dark"></i>

                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <!-- Suponiendo que $documentos es una colección de documentos de COPLADEP obtenidos de tu base de datos -->
                            @if ($documentos->isNotEmpty())
                                <!-- Itera sobre los documentos y obtén la fecha de actualización más reciente -->
                                @php
                                    $ultimaActualizacion = $documentos->max('updated_at');
                                @endphp
                                <!-- Muestra la leyenda con la fecha de la última actualización -->
                                <p class="text-white" style="font-size: 10px">Última actualización:
                                    {{ $ultimaActualizacion->format('d/m/Y H:i:s') }} UTC</p>
                            @else
                                <p>No hay información disponible.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script>
        function openModal(src) {
            var iframe = document.querySelector('#myModal iframe');
            if (iframe) {
                iframe.setAttribute('src', src);
                document.getElementById('myModal').style.display = 'block'; // Mostrar la ventana modal
            }
        }

        function closeModal() {
            document.getElementById('myModal').style.display = 'none'; // Ocultar la ventana modal
        }
    </script>
    <script src="{{ asset('web/js/popper.min.js') }}"></script>
@endsection
{{-- Borradores --}}

{{-- <div class="col-md-12 col-lg-4 mb-3">
    <div class="services-item-no-anim bg-light">
                                    <div class="p-4 text-center services-content">
                                        <div class="services-content-icon">
                                            <!-- <img
                                                              src="assets/img/plan.png"
                                                              alt=""
                                                              style="width: 250px"
                                                            /> -->
                                            <h4 class="mb-3">Programa Anual de Trabajo</h4>
                                            <a href="assets/documentos/planeader/programasanualesdetrabajo/2024/Programa Anual de Trabajo 2024.pdf"
                                                download="">
                                                <button class="boton-tarjetadocs">
                                                    Descarga <i class="fas fa-download"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4 mb-3">
                                <div class="services-item-no-anim bg-light">
                                    <div class="p-4 text-center services-content">
                                        <div class="services-content-icon">
                                            <!-- <img
                                                              src="assets/img/plan.png"
                                                              alt=""
                                                              style="width: 250px"
                                                            /> -->
                                            <h4 class="mb-3">Informe Anual de Trabajo</h4>
                                            <a href="assets/documentos/planeader/informesanualesdetrabajo/2022/Informe Anual de Trabajo 2022.pdf"
                                                download="">
                                                <button class="boton-tarjetadocs">
                                                    Descarga <i class="fas fa-download"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4 mb-3">
                                <div class="services-item-no-anim bg-light">
                                    <div class="p-4 text-center services-content">
                                        <div class="services-content-icon">
                                            <h4 class="mb-3">Acta más reciente</h4>
                                            <a href="assets/documentos/planeader/actas/2023/Acta Segunda Sesion 2023 Copladep.pdf"
                                                download="">
                                                <button class="boton-tarjetadocs">
                                                    Descarga <i class="fas fa-download"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
{{-- Botones de mas recientes documentos --}}

{{-- <div class="col-md-12 col-lg-4 mb-3">
                                <div class="services-item-no-anim bg-light">
                                    <div class="p-4 text-center services-content">
                                        <div class="services-content-icon">
                                            <h4 class="mb-3">Programa Anual de Trabajo</h4>
                                            @if ($programa_mas_reciente)
                                                <a href="{{ asset('documentocopladep/' . $programa_mas_reciente->ruta_documento) }}"
                                                    download class="boton-tarjetadocs">
                                                    Descargar <i class="fas fa-download"></i>
                                                </a>
                                            @else
                                                <p>No hay programa disponible.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-4 mb-3">
                                <div class="services-item-no-anim bg-light">
                                    <div class="p-4 text-center services-content">
                                        <div class="services-content-icon">
                                            <h4 class="mb-3">Informe Anual de Trabajo</h4>
                                            @if ($informe_mas_reciente)
                                                <a href="{{ asset('documentocopladep/' . $informe_mas_reciente->ruta_documento) }}"
                                                    download class="boton-tarjetadocs">
                                                    Descargar <i class="fas fa-download"></i>
                                                </a>
                                            @else
                                                <p>No hay informe disponible.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-4 mb-3">
                                <div class="services-item-no-anim bg-light">
                                    <div class="p-4 text-center services-content">
                                        <div class="services-content-icon">
                                            <h4 class="mb-3">Acta más reciente</h4>
                                            @if ($acta_mas_reciente)
                                                <a href="{{ asset('documentocopladep/' . $acta_mas_reciente->ruta_documento) }}"
                                                    download class="boton-tarjetadocs">
                                                    Descargar <i class="fas fa-download"></i>
                                                </a>
                                            @else
                                                <p>No hay acta disponible.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
