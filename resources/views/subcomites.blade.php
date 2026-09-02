@extends('layouts.plantilla')
@section('title', 'Subcomites del COPLADEP')
@section('meta-description', 'Subcomités que conforman el Comite de Planeación para el Desarrollo del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'Subcomités - Sistema Estatal de Planeación Democrática')
@section(
    'og-description',
    'Bienvenido a la página de visión general de los subcomités del COPLADEP, parte del Sistema
    Estatal de Planeación Democrática del Estado de Puebla.'
)
@section('og:url', url()->current())
@section('twitter-title', 'Subcomités - Sistema Estatal de Planeación Democrática')
@section(
    'twitter-description',
    'Bienvenido a la página de visión general de los subcomités del COPLADEP, parte del
    Sistema Estatal de Planeación Democrática del Estado de Puebla.'
)
@section('content')
    <section class="contenedor-imagen-subcomites">
        <h1>Subcomités</h1>
    </section>
    <section class="subcomites-actual">
        <div class="container pt-5 pb-4 text-center">
            <div class="subtitulo-tematica mb-2">Integración vigente</div>
            <h2 class="titulo-tematica mt-0">Subcomités actuales</h2>
            <p class="text-black mb-0">
                Órganos auxiliares del COPLADEP definidos de acuerdo a las prioridades del Gobierno del Estado.
            </p>
        </div>
        <div class="container">
            @if ($subcomites_actual->isNotEmpty())
                @php $primerGrupoActual = true; @endphp
                <div class="accordion" id="accordionActual">
                    @foreach ($tipos_subcomites as $tipo_subcomite)
                        @php
                            $subcomites_del_tipo = $subcomites_actual->where('tipo_subcomite', $tipo_subcomite);
                        @endphp
                        @if ($subcomites_del_tipo->isNotEmpty())
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-actual-{{ $loop->index }}">
                                    <button class="accordion-button {{ $primerGrupoActual ? '' : 'collapsed' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-actual-{{ $loop->index }}"
                                        aria-expanded="{{ $primerGrupoActual ? 'true' : 'false' }}"
                                        aria-controls="collapse-actual-{{ $loop->index }}">
                                        <strong>
                                            @if($tipo_subcomite === 'Sectoriales')
                                                Subcomités Sectoriales para el Desarrollo Regional y Riqueza Comunitaria
                                            @else
                                                {{ $tipo_subcomite }}
                                            @endif
                                        </strong>
                                    </button>
                                </h2>
                                <div id="collapse-actual-{{ $loop->index }}"
                                    class="accordion-collapse collapse {{ $primerGrupoActual ? 'show' : '' }}"
                                    aria-labelledby="heading-actual-{{ $loop->index }}" data-bs-parent="#accordionActual">
                                    <div class="accordion-body">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($subcomites_del_tipo as $subcomite)
                                                <li
                                                    class="list-group-item d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                                                    <span>{{ $subcomite->nombre }}</span>
                                                    <a href="{{ route('subcomites.showPublic', ['slug' => $subcomite->slug]) }}"
                                                        class="btn btn-sm btn-outline-color-1 flex-shrink-0" rel="noopener"
                                                        title="Ver detalle de {{ $subcomite->nombre }}">
                                                        Ver detalle
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @php $primerGrupoActual = false; @endphp
                        @endif
                    @endforeach
                </div>
            @else
                <div class="subtitulo-seccion">Próximamente</div>
            @endif
            @if ($subcomites_actual->isNotEmpty())
                @php
                    $ultimaActualizacion = $subcomites_actual->max('updated_at');
                @endphp
                <p class="text-black" style="font-size: 10px; margin-bottom:inherit; margin-top: 1rem;">Última actualización:
                    {{ $ultimaActualizacion->format('d/m/Y H:i:s') }}
                </p>
            @else
                <p>No hay información disponible.</p>
            @endif
        </div>
    </section>
    <section class="container py-5 mesas-tecnicas" aria-labelledby="mesas-tecnicas-title">
        <div class="border rounded-3 overflow-hidden shadow-sm">
            <div class="d-flex align-items-center px-3 px-md-4 py-3 text-white"
                style="background-color: var(--color2);">
                <span class="d-block small text-uppercase fw-bold">Calendario</span>
            </div>
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 p-3 p-md-4 bg-white">
                <div>
                    <h2 id="mesas-tecnicas-title" class="h5 mb-1">Mesas Técnicas de Trabajo de Programas Especiales</h2>
                    <p class="mb-0 small text-muted">Consulta las fechas y detalles de las próximas mesas de trabajo.</p>
                </div>
                <a href="{{ route('subcomites.mesas-tecnicas-programas-especiales') }}"
                    class="btn btn-sm btn-outline-color-1 flex-shrink-0 align-self-start align-self-md-center"
                    rel="noopener" title="Ver detalle de Mesas Técnicas de Trabajo de Programas Especiales">
                    Consultar calendario
                </a>
            </div>
        </div>
    </section>
    <section class="historicos-subcomites">
        <div class="container mt-5">
            <div class="row">
                <div class="row">
                    <div class="col-12">
                        <div class="subtitulo-tematica">
                            Archivo Histórico de los
                        </div>
                        <div class="titulo-tematica">
                            Subcomités
                        </div>
                    </div>
                </div>
                <div class="col-md-10 mx-auto">

                    @if ($subcomites_historicos_agrupados->isNotEmpty())

                        {{-- El div padre del acordeón. Necesita un ID único. --}}
                        <div class="accordion" id="accordionHistorico">

                            @foreach ($subcomites_historicos_agrupados as $plan_id => $subcomites_del_plan)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-{{ $plan_id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-{{ $plan_id }}" aria-expanded="false"
                                            aria-controls="collapse-{{ $plan_id }}">
                                            {{-- Usamos el primer subcomité del grupo para obtener el nombre del plan --}}
                                            <strong>{{ $subcomites_del_plan->first()->planEstatal->nombre }}</strong>
                                        </button>
                                    </h2>

                                    {{-- El ID aquí debe coincidir con el `data-bs-target` del botón --}}
                                    {{-- El `data-bs-parent` apunta al ID del acordeón padre para que solo uno esté abierto a la vez
                                    --}}
                                    <div id="collapse-{{ $plan_id }}" class="accordion-collapse collapse"
                                        aria-labelledby="heading-{{ $plan_id }}" data-bs-parent="#accordionHistorico">
                                        <div class="accordion-body">
                                            <ul class="list-group list-group-flush">
                                                @foreach ($subcomites_del_plan as $subcomite)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{ $subcomite->nombre }}
                                                        <a href="{{ route('subcomites.showPublic', ['slug' => $subcomite->slug]) }}"
                                                            class="btn btn-sm btn-outline-color-1" rel="noopener"
                                                            title="Ver detalle de {{ $subcomite->nombre }}">
                                                            Ver detalle
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @else
                        <p class="text-center text-muted">No hay registros históricos de subcomités disponibles.</p>
                    @endif

                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
