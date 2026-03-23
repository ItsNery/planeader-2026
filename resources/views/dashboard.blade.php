<x-app-layout>
    {{-- local --}}
    @section('title', 'Inicio')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <div class="container py-5">
        <div class="row g-4">
            {{-- Docs. Subcomités --}}
            @can('ver-doc-subcomite')
                <div class="col-md-4 col-lg-3">
                    <div class="card tarjeta-admin h-100 border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-file-alt fa-2x texto-terracota me-3"></i>
                                <h5 class="card-title mb-0 fw-bold">Docs. Subcomités</h5>
                            </div>
                            <p class="card-text flex-grow-1">
                                Actualmente se han subido <br>
                                <span class="fs-4 fw-bold text-primary">{{ $cantidad_documentos_subcomites }}</span>
                                documentos.
                            </p>
                            <a href="{{ url('/panel-documentos-subcomites') }}" class="btn btn-custom-primary mt-auto">Ver
                                panel</a>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- Docs. COPLADEP --}}
            @can('ver-doc-copladep')
                <div class="col-md-4 col-lg-3">
                    <div class="card tarjeta-admin h-100 border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-folder-open fa-2x texto-terracota me-3"></i>
                                <h5 class="card-title mb-0 fw-bold">Docs. COPLADEP</h5>
                            </div>
                            <p class="card-text flex-grow-1">
                                Actualmente se han subido <br>
                                <span class="fs-4 fw-bold text-primary">{{ $cantidad_documentos_copladep }}</span>
                                documentos.
                            </p>
                            <a href="{{ url('/panel-documentos-copladep') }}" class="btn btn-custom-primary mt-auto">Ver
                                panel</a>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- Planes Municipales --}}
            @can('ver-plan-municipal')
                <div class="col-md-4 col-lg-3">
                    <div class="card tarjeta-admin h-100 border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-map-marked-alt fa-2x texto-terracota me-3"></i>
                                <h5 class="card-title mb-0 fw-bold">Planes Municipales</h5>
                            </div>
                            <p class="card-text flex-grow-1">
                                Actualmente se han subido <br>
                                <span class="fs-4 fw-bold text-primary">{{ $cantidad_documentos_planesmun }}</span>
                                planes de desarrollo.
                            </p>
                            <a href="{{ url('/panel-planes-municipales') }}" class="btn btn-custom-primary mt-auto">Ver
                                panel</a>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- Planes Estatales --}}
            @can('ver-plan-estatal')
                <div class="col-md-4 col-lg-3">
                    <div class="card tarjeta-admin h-100 border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-landmark fa-2x texto-terracota me-3"></i>
                                <h5 class="card-title mb-0 fw-bold">Planes Estatales</h5>
                            </div>
                            <p class="card-text flex-grow-1">
                                Actualmente se han subido <br>
                                <span class="fs-4 fw-bold text-primary">{{ $cantidad_documentos_planesest }}</span>
                                documentos.
                            </p>
                            <a href="{{ url('/panel-planes-estatales') }}" class="btn btn-custom-primary mt-auto">Ver
                                panel</a>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- Programas Derivados --}}
            @can('ver-programa-derivado')
                <div class="col-md-4 col-lg-3">
                    <div class="card tarjeta-admin h-100 border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-project-diagram fa-2x texto-terracota me-3"></i>
                                <h5 class="card-title mb-0 fw-bold">Programas Derivados</h5>
                            </div>
                            <p class="card-text flex-grow-1">
                                Actualmente se han subido <br>
                                <span class="fs-4 fw-bold text-primary">{{ $cantidad_programas_derivados }}</span>
                                documentos.
                            </p>
                            <a href="{{ url('/panel-programas-derivados') }}" class="btn btn-custom-primary mt-auto">Ver
                                panel</a>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- Subcomites --}}
            @can('ver-subcomite')
                <div class="col-md-4 col-lg-3">
                    <div class="card tarjeta-admin h-100 border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-users fa-2x texto-terracota me-3"></i>
                                <h5 class="card-title mb-0 fw-bold">Subcomités</h5>
                            </div>
                            <p class="card-text flex-grow-1">
                                Actualmente tienes <br>
                                <span class="fs-4 fw-bold text-primary">{{ $cantidad_subcomites }}</span>
                                registrados.
                            </p>
                            <a href="{{ url('/panel-subcomites') }}" class="btn btn-custom-primary mt-auto">Ver panel</a>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- Banners --}}
            @can('ver-banner')
                <div class="col-md-4 col-lg-3">
                    <div class="card tarjeta-admin h-100 border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-image fa-2x texto-terracota me-3"></i>
                                <h5 class="card-title mb-0 fw-bold">Banners</h5>
                            </div>
                            <p class="card-text flex-grow-1">
                                Actualmente tienes <br>
                                <span class="fs-4 fw-bold text-primary">{{ $cantidad_banners }}</span>
                                publicados.
                            </p>
                            <a href="{{ url('/panel-banners') }}" class="btn btn-custom-primary mt-auto">Ver panel</a>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- Docs. Marco Jurídico --}}
            @can('ver-marco-juridico')
                <div class="col-md-4 col-lg-3">
                    <div class="card tarjeta-admin h-100 border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-gavel fa-2x texto-terracota me-3"></i>
                                <h5 class="card-title mb-0 fw-bold">Marco Jurídico</h5>
                            </div>
                            <p class="card-text flex-grow-1">
                                Actualmente tienes <br>
                                <span class="fs-4 fw-bold text-primary">{{ $cantidad_docsMarco }}</span>
                                documentos.
                            </p>
                            <a href="{{ url('/panel-marco-juridico') }}" class="btn btn-custom-primary mt-auto">Ver panel</a>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- Mensajes de contacto --}}
            @can('ver-contacto')
                <div class="col-md-4 col-lg-3">
                    <div class="card tarjeta-admin h-100 border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-envelope fa-2x texto-terracota me-3"></i>
                                <h5 class="card-title mb-0 fw-bold">Mensajes</h5>
                            </div>
                            <p class="card-text flex-grow-1">
                                Actualmente tienes <br>
                                <span class="fs-4 fw-bold text-primary">{{ $cantidad_mensajes }}</span>
                                mensaje(s) nuevos.
                            </p>
                            <a href="{{ url('/panel-contacto') }}" class="btn btn-custom-primary mt-auto">Ver mensajes</a>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- Usuarios --}}
            @can('ver-usuario')
                <div class="col-md-4 col-lg-3">
                    <div class="card tarjeta-admin h-100 border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-user-shield fa-2x texto-terracota me-3"></i>
                                <h5 class="card-title mb-0 fw-bold">Usuarios</h5>
                            </div>
                            <p class="card-text flex-grow-1">
                                Actualmente tienes <br>
                                <span class="fs-4 fw-bold text-primary">{{ $cantidad_usuarios }}</span>
                                usuario(s) activos.
                            </p>
                            <a href="{{ url('/panel-admin') }}" class="btn btn-custom-primary mt-auto">Ver panel</a>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- Programas Estatales --}}
            @can('ver-programa-estatales')
                <div class="col-md-4 col-lg-3">
                    <div class="card tarjeta-admin h-100 border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-clipboard-list fa-2x texto-terracota me-3"></i>
                                <h5 class="card-title mb-0 fw-bold">Progs. Estatales</h5>
                            </div>
                            <p class="card-text flex-grow-1">
                                Actualmente tienes <br>
                                <span class="fs-4 fw-bold text-primary">{{ $cantidad_prog_estatales }}</span>
                                programas.
                            </p>
                            <a href="{{ url('/panel-programas-estatales') }}" class="btn btn-custom-primary mt-auto">Ver panel</a>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- Capacitaciones municipales --}}
            @can('ver-capacitacion')
                <div class="col-md-4 col-lg-3">
                    <div class="card tarjeta-admin h-100 border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-chalkboard-teacher fa-2x texto-terracota me-3"></i>
                                <h5 class="card-title mb-0 fw-bold">Capacitaciones</h5>
                            </div>
                            <p class="card-text flex-grow-1">
                                Actualmente tienes <br>
                                <span class="fs-4 fw-bold text-primary">{{ $cantidad_capacitaciones }}</span>
                                capacitaciones.
                            </p>
                            <a href="{{ url('/capacitaciones') }}" class="btn btn-custom-primary mt-auto">Ver panel</a>
                        </div>
                    </div>
                </div>
            @endcan

            <div class="col-12 mt-5">
                <div class="card tarjeta-admin border-0 p-4">
                    <h3 class="card-title text-center text-primary mb-4 fw-bold">
                        Encuesta de Satisfacción
                    </h3>

                    @if ($encuesta_feliz || $encuesta_indiferente || $encuesta_enojado)
                        <div class="row align-items-center">
                            <div class="col-md-6 d-flex justify-content-center">
                                <div id="chart"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="rounded-circle me-2"
                                            style="width:15px; height:15px; background:#00E396;"></div>
                                        <span>Feliz: <strong>{{ $encuesta_feliz }}</strong></span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="rounded-circle me-2"
                                            style="width:15px; height:15px; background:#FEB019;"></div>
                                        <span>Indiferente: <strong>{{ $encuesta_indiferente }}</strong></span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="rounded-circle me-2"
                                            style="width:15px; height:15px; background:#FF4560;"></div>
                                        <span>Molesto: <strong>{{ $encuesta_enojado }}</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                            <p class="fs-5 text-muted">Aún no hay datos de encuestas disponibles</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <script>
            var options = {
                series: [{{ $encuesta_feliz }}, {{ $encuesta_indiferente }}, {{ $encuesta_enojado }}],
                chart: {
                    width: 380,
                    type: 'pie',
                },
                labels: ['Feliz', 'Indiferente', 'Molesto'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        </script>
    </div>
</x-app-layout>
