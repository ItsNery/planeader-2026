@extends('layouts.plantilla')
@section('title', 'Subcomites del COPLADEP')
@section('meta-description', 'Subcomités que conforman el Comite de Planeación para el Desarrollo del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'Subcomités - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Bienvenido a la página de visión general de los subcomités del COPLADEP, parte del Sistema
    Estatal de Planeación Democrática del Estado de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'Subcomités - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
    'Bienvenido a la página de visión general de los subcomités del COPLADEP, parte del
    Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('content')
    <section class="contenedor-imagen-subcomites">
        <h1>Subcomités</h1>
    </section>
    {{-- <section class="subcomites-actual"> --}}
    {{-- <div class="container py-5">
            <div class="text-center mb-3 pb-3">
                <p class="text-black">
                    Órganos auxiliares del COPLADEP definidos de acuerdo a las prioridades del Gobierno del Estado.
                </p>
            </div>
        </div> --}}
    {{-- Se comenta en espera de los nuevos subcomités --}}
    {{-- <div class="container">
            @if ($subcomites_actual->isNotEmpty())
                @foreach ($tipos_subcomites as $tipo_subcomite)
                    <div class="three">
                        <h2 class="titulo-tematica">{{ $tipo_subcomite }}</h2>
                    </div>
                    <div class="row">
                        @foreach ($subcomites_actual->where('tipo_subcomite', $tipo_subcomite) as $subcomite)
                            <div class="col-sm-12 col-md-6 col-lg-4 item mb-5">
                                <a href="{{ route('subcomites.showPublic', ['slug' => $subcomite->slug]) }}" target="_self"
                                    title="{{ $subcomite->nombre }}" rel="noopener" class="text-decoration-none">
                                    <div class="tarjeta-moderna">
                                        <div class="tarjeta-icono-wrap">
                                            <div class="tarjeta-icono">
                                                <img src="{{ asset('icono_subcomites/' . $subcomite->icono) }}"
                                                    alt="Icono de {{ $subcomite->nombre }}" />
                                            </div>
                                        </div>
                                        <div class="tarjeta-texto">
                                            @php
                                                // Tu lógica de PHP para separar el título se mantiene igual
                                                $nombre = $subcomite->nombre;
                                                $tipo = '';
                                                if (Str::startsWith($nombre, 'Subcomité Sectorial')) {
                                                    $tipo = 'Subcomité Sectorial';
                                                    $nombre = Str::replaceFirst('Subcomité Sectorial', '', $nombre);
                                                } // ... (agrega tus otros else if aquí)
                                                $nombre = trim(Str::replaceFirst('de', '', $nombre));
                                            @endphp

                                            <span class="tipo-subcomite">{{ $tipo }}</span>
                                            <span class="nombre-subcomite">{{ $nombre }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @else
                <div class="subtitulo-seccion">Próximamente</div>
            @endif
            <!-- Suponiendo que $documentos es una colección de documentos de COPLADEP obtenidos de tu base de datos -->
            @if ($subcomites_actual->isNotEmpty())
                <!-- Itera sobre los documentos y obtén la fecha de actualización más reciente -->
                @php
                    $ultimaActualizacion = $subcomites_actual->max('updated_at');
                @endphp
                <!-- Muestra la leyenda con la fecha de la última actualización -->
                <p class="text-white" style="font-size: 10px; margin-bottom:inherit">Última actualización:
                    {{ $ultimaActualizacion->format('d/m/Y H:i:s') }}</p>
            @else
                <p>No hay información disponible.</p>
            @endif
        </div> --}}
    {{-- </section> --}}
    <section class="historicos-subcomites">
        <div class="container mt-5">
            <div class="text-center mb-3 pb-3">
                <p class="text-black">
                    Órganos auxiliares del COPLADEP definidos de acuerdo a las prioridades del Gobierno del Estado.
                </p>
            </div>
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
                                    {{-- El `data-bs-parent` apunta al ID del acordeón padre para que solo uno esté abierto a la vez --}}
                                    <div id="collapse-{{ $plan_id }}" class="accordion-collapse collapse"
                                        aria-labelledby="heading-{{ $plan_id }}" data-bs-parent="#accordionHistorico">
                                        <div class="accordion-body">
                                            <ul class="list-group list-group-flush">
                                                @foreach ($subcomites_del_plan as $subcomite)
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
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