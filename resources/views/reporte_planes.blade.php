<div id="informacion-municipio">
    <div class="container custom-card">
        <div class="custom-card-header">
            <h2 class="custom-card-title">Información del Municipio</h2>
            <button class="btn btn-close" onclick="cerrarInfoMunicipio()"></button>
        </div>
        <div class="custom-card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img class="card-img-top"
                            src="{{ asset('Municipios/escudos/Escudo_Municipio' . $municipio->id . '.svg') }}"
                            alt="Escudo del municipio" title="Escudo del municipio">
                        <div class="card-body">
                            <h6 class="seccion-titulo">Nombre del Municipio</h6>
                            <h5 class="card-title mt-0">{{ $municipio->nombre }}</h5>
                            <h6 class="seccion-titulo mt-3">Regionalización</h6>
                            <p class="card-text mb-0"><strong>Macrorregión:</strong> {{ $municipio->macrorregion }}</p>
                            <p class="card-text"><strong>Microrregión:</strong> {{ $municipio->microrregion }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <img class="card-img-top" src="{{ asset('Municipios/imagen/' . $municipio->id . '.jpg') }}"
                            alt="Imagen del municipio" title="Imagen del municipio">
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    {{-- También corregí el estilo inline aquí --}}
                    <div class="card" style="background-color: var(--gobierno); color: black;">
                        <div class="card-body">
                            <h5 class="card-title">Información adicional</h5>
                            <p class="card-text">
                                <i class="fas fa-globe"></i> <strong>Sitio Web:</strong>
                                <a href="{{ $municipio->sitio_web }}" target="_blank"
                                    rel="noopener">{{ $municipio->sitio_web }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container pmd-list-section">
        <div class="mb-4">
            <h3 class="titulo-planesmun">Listado de Planes Municipales de Desarrollo (PMD)</h3>
        </div>

        @if ($planes_municipales->isEmpty())

            {{-- ESTADO VACÍO --}}
            <div class="text-center py-5">
                <img src="{{ asset('imagen/no-file.png') }}" alt="No se encontraron registros"
                    style="width: 200px; opacity: 0.7;">
                <p class="text-muted mt-3 fs-5">Upps, no se encontraron planes municipales.</p>
            </div>
        @else
            {{-- LISTADO DE PLANES --}}
            <ul class="list-group list-group-flush">
                @foreach ($planes_municipales as $plan)
                    <li class="document-item">
                        <div class="document-item__main-content">
                            <p class="document-item__name">
                                {{ $plan->nombre }}
                            </p>
                            <span class="document-badge badge-pdf">PDF</span>
                        </div>

                        <div class="document-item__actions">

                            <a href="#" class="js-open-modal"
                                data-src="{{ asset('planesmun/' . $plan->ruta_documento) }}"
                                data-title="{{ $plan->nombre }}" title="Ver documento">
                                <i class="fas fa-eye"></i> <span>Ver</span>
                            </a>

                            <a href="{{ asset('planesmun/' . $plan->ruta_documento) }}" download rel="noopener"
                                title="Descargar documento">
                                <i class="fas fa-download"></i>
                                <span>Descargar</span>
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="row">
                <div class="col-12">
                    @php
                        $ultimaActualizacion = $planes_municipales->max('updated_at');
                    @endphp
                    <p class="pmd-footer-info">
                        Última actualización:
                        {{ $ultimaActualizacion ? $ultimaActualizacion->format('d/m/Y H:i:s') : 'No disponible' }}
                    </p>
                </div>
            </div>

        @endif
    </div>
</div>
