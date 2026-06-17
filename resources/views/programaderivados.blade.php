@extends('layouts.plantilla')
@section('title', 'Programas Derivados del Plan Estatal de Desarrollo')
@section('meta-description',
    'Programas Derivados del Plan Estatal de Desarrollo
    2024-2030 del Gobierno del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'Programas Derivados - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Bienvenido a la página de visión general de los Programas Derivados del Plan Estatal de Desarrollo
    2024-2030 del Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'Programas Derivados - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
    'Bienvenido a la página de visión general de los Programas Derivados del Plan Estatal de Desarrollo
    2024-2030 del Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('content')
    <section class="contenedor-imagen-programasest">
        <h1>Programas Derivados</h1>
    </section>
    {{-- <section class="ped-programas-inicio">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="titulo-seccion">
                        Programas Derivados
                    </div>
                    <div class="subtitulo-seccion">
                    <a href="https://ped2024-2030.puebla.gob.mx/programas/" title="Programas Derivados" rel="noopener">Conócelos</a>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="programas-derivados bckgrnd-gradient-plan">
        <div class="container derivadosnew">
            <div class="container py-5">
                <div class="text-center mb-3 pb-3">
                    <p class="text-black">Documentos de carácter estatal que son derivados del Plan Estatal de Desarrollo
                    </p>
                </div>
            </div>
            <div class="container mb-5">
                <a href="https://ped2024-2030.puebla.gob.mx/programas/" target="_blank" ref="noopener"
                    title="Programas Derivados" class="subtitulo-seccion">
                    Conócelos
                </a>
            </div>
            @if ($programasDerivados->isEmpty())
            @else
                <!-- Buscador de Programas Derivados -->
                <div class="row justify-content-center mt-4">
                    <div class="col-md-6">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="buscador-programas" class="form-control border-start-0 ps-0" placeholder="Buscar programa por nombre...">
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs justify-content-center mt-4" id="programasActualesTab" role="tablist">
                    @foreach ($programasDerivadosActuales as $tipo => $programas)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if ($loop->first) active @endif"
                                id="actual-{{ Str::slug($tipo) }}-tab" data-bs-toggle="tab"
                                data-bs-target="#actual-{{ Str::slug($tipo) }}-pane" type="button" role="tab"
                                aria-controls="actual-{{ Str::slug($tipo) }}-pane"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $tipo }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content" id="programasActualesTabContent">
                    @foreach ($programasDerivadosActuales as $tipo => $programasPorTipo)
                        <div class="tab-pane fade @if ($loop->first) show active @endif"
                            id="actual-{{ Str::slug($tipo) }}-pane" role="tabpanel"
                            aria-labelledby="actual-{{ Str::slug($tipo) }}-tab" tabindex="0">

                            <div class="content-container py-4">

                                @if (Str::contains(strtolower($tipo), ['institucional', 'regional']))
                                    <div class="container mb-4">
                                        <div class="alert alert-warning shadow-sm" role="alert">
                                            <h4 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Aviso para PLANEADER</h4>
                                            <p>Derivado del proceso de actualización de la regionalización del estado y con la finalidad de mantener la consistencia entre los instrumentos del Sistema Estatal de Planeación Democrática, se realizaron ajustes en los identificadores numéricos de los Programas Regionales.</p>
                                            <p>En consecuencia, los identificadores numéricos de los Programas Regionales modificados, generaron también cambios en los Programas Institucionales, por lo que es importante tener en cuenta estos cambios.</p>
                                            <hr>
                                            <p class="mb-0">Es importante señalar que estas modificaciones tienen efectos exclusivamente para fines de vinculación entre los Instrumentos de Planeación y no cambios en el contenido de los componentes estratégicos.</p>
                                        </div>
                                    </div>
                                @endif

                                <div class="d-flex flex-wrap justify-content-center">
                                    @foreach ($programasPorTipo as $programa)
                                        <div class="m-3 programa-card" data-nombre="{{ strtolower($programa->nombre) }}">

                                            <div class="tarjeta_histder">
                                                <div class="tarjeta_histder-details">
                                                    <img class="w-100"
                                                        src="{{ asset('portadaprogder/' . $programa->portada) }}"
                                                        alt="Portada de {{ $programa->nombre }}"
                                                        title="{{ $programa->nombre }}" loading="lazy">
                                                </div>

                                                <a class="tarjeta_histder-button no_s js-ver-documento" rel="noopener"
                                                    href="{{ asset('progderi/' . $programa->ruta_documento) }}" target="_blank"
                                                    data-src="{{ asset('progderi/' . $programa->ruta_documento) }}"
                                                    data-title="{{ $programa->nombre }}">
                                                    Consultar
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

            @if ($programasDerivados->isNotEmpty())
                @php
                    $ultimaActualizacion = $programasDerivados->max('updated_at');
                @endphp

                <p class="text-black" style="font-size: 10px">Última actualización:

                    {{ $ultimaActualizacionProgramas->format('d/m/Y H:i:s') }} UTC
                </p>
            @else
                <p class="text-black" style="font-size: 10px">Última actualización:
                    No hay información disponible.</p>
                <p>
            @endif
        </div>
    </section>
    <section class="programas-derivados-historico bckgrnd-gradient-plan">
        <div class="container mx-auto px-4">
            <div class="row">
                <div class="col-12">
                    <div class="subtitulo-tematica">
                        Archivo Histórico de los
                    </div>
                    <div class="titulo-tematica">
                        Programas Derivados
                    </div>
                </div>
            </div>
            @if ($programasDerivadosHistorico->isEmpty())
                <div class="container"
                    style="display: flex; justify-content:center; align-items:center; flex-direction:column">
                    <img class="w-30p" src="{{ asset('imagen/no-file.png') }}" alt="Imagen de Not Found"
                        title="Imagen de Not Found" loading="lazy">
                    <p class="texto-color1 text-center pb-5">Upps, no se encontraron registros.</p>
                </div>
            @else
                <div class="accordion" id="accordionPrincipalPlanes">

                    @foreach ($programasDerivadosHistorico->groupBy('planestatal.nombre') as $nombrePlan => $programasDelPlan)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-plan-{{ Str::slug($nombrePlan) }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-plan-{{ Str::slug($nombrePlan) }}" aria-expanded="false"
                                    aria-controls="collapse-plan-{{ Str::slug($nombrePlan) }}">

                                    {{-- Encabezado con nombre y periodo del plan --}}
                                    <strong>{{ $nombrePlan }}</strong>
                                    <span class="ms-2 fst-italic fw-normal">
                                        ({{ $programasDelPlan->first()->planestatal->periodo }})
                                    </span>
                                </button>
                            </h2>
                            <div id="collapse-plan-{{ Str::slug($nombrePlan) }}" class="accordion-collapse collapse"
                                aria-labelledby="heading-plan-{{ Str::slug($nombrePlan) }}"
                                data-bs-parent="#accordionPrincipalPlanes">
                                <div class="accordion-body">

                                    {{-- 2. ACORDEÓN SECUNDARIO (INTERNO) - Agrupado por Tipo de Programa --}}
                                    <div class="accordion" id="accordionInternoTipos-{{ Str::slug($nombrePlan) }}">
                                        @foreach ($programasDelPlan->groupBy('tipo_derivado') as $tipoNombre => $programasPorTipo)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header"
                                                    id="heading-tipo-{{ Str::slug($nombrePlan) }}-{{ Str::slug($tipoNombre) }}">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse-tipo-{{ Str::slug($nombrePlan) }}-{{ Str::slug($tipoNombre) }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapse-tipo-{{ Str::slug($nombrePlan) }}-{{ Str::slug($tipoNombre) }}">
                                                        {{ $tipoNombre }}
                                                    </button>
                                                </h2>
                                                <div id="collapse-tipo-{{ Str::slug($nombrePlan) }}-{{ Str::slug($tipoNombre) }}"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="heading-tipo-{{ Str::slug($nombrePlan) }}-{{ Str::slug($tipoNombre) }}"
                                                    data-bs-parent="#accordionInternoTipos-{{ Str::slug($nombrePlan) }}">
                                                    <div class="accordion-body">

                                                        {{-- 3. LISTA FINAL DE PROGRAMAS --}}
                                                        <ul class="list-group list-group-flush">
                                                            {{-- Ahora iteramos sobre los programas de este plan en específico --}}
                                                            @foreach ($programasPorTipo as $programa)
                                                                <li class="document-item programa-card" data-nombre="{{ strtolower($programa->nombre) }}">
                                                                    <div class="document-item__main-content">
                                                                        <p class="document-item__name">
                                                                            {{ $programa->nombre }}
                                                                        </p>
                                                                        <span
                                                                            class="document-badge badge-{{ strtolower(pathinfo($programa->ruta_documento, PATHINFO_EXTENSION)) }}">
                                                                            {{ strtoupper(pathinfo($programa->ruta_documento, PATHINFO_EXTENSION)) }}
                                                                        </span>
                                                                    </div>

                                                                    <div class="document-item__actions">

                                                                        <a href="#" class="js-ver-documento"
                                                                            data-src="{{ asset('progderi/' . $programa->ruta_documento) }}"
                                                                            data-title="{{ $programa->nombre }}"
                                                                            title="Ver aquí">
                                                                            <i class="fas fa-eye"></i> <span>Ver aquí</span>
                                                                        </a>
                                                                        <a href="{{ asset('progderi/' . $programa->ruta_documento) }}"
                                                                            target="_blank" rel="noopener noreferrer" 
                                                                            title="Abrir en nueva pestaña">
                                                                            <i class="fas fa-external-link-alt"></i> <span>Abrir</span>
                                                                        </a>
                                                                        <a href="{{ asset('progderi/' . $programa->ruta_documento) }}"
                                                                            download rel="noopener"
                                                                            title="Descargar documento">
                                                                            <i class="fas fa-download"></i>
                                                                            <span>Descargar</span>
                                                                        </a>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <!-- Suponiendo que $documentos es una colección de documentos de COPLADEP obtenidos de tu base de datos -->
            @if ($programasDerivadosHistorico->isNotEmpty())
                <!-- Itera sobre los documentos y obtén la fecha de actualización más reciente -->
                @php
                    $ultimaActualizacion = $programasDerivadosHistorico->max('updated_at');
                @endphp
                <!-- Muestra la leyenda con la fecha de la última actualización -->
                <p class="text-black mb-0 py-1" style="font-size: 10px">Última actualización:
                    {{-- {{ $ultimaActualizacion->format('d/m/Y H:i:s') }}</p> --}}
                    {{ $ultimaActualizacionProgramasHistorico->format('d/m/Y H:i:s') }} UTC
                @else
                <p class="text-black" style="font-size: 10px; margin-bottom:inherit">Última actualización:
                    No hay información disponible.</p>
                <p>
            @endif
        </div>
    </section>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buscador = document.getElementById('buscador-programas');
        if (buscador) {
            buscador.addEventListener('input', function() {
                const term = this.value.toLowerCase().trim();
                const cards = document.querySelectorAll('.programa-card');
                
                cards.forEach(card => {
                    const nombre = card.getAttribute('data-nombre');
                    if (nombre.includes(term)) {
                        card.style.display = ''; // Restaurar el display por defecto
                    } else {
                        card.style.display = 'none'; // Ocultar
                    }
                });
            });
        }
    });
</script>
@endsection
