<x-app-layout>
    @section('title', 'Sesiones COPLADEP')

    <div class="tarjeta-admin overflow-hidden">
        <div class="form-header px-4 py-4">
            <h1 class="h2 mb-2">Sesiones COPLADEP</h1>
            <p class="mb-0 text-white">Seleccione una sesión para consultar sus registros o revisar su página pública.</p>
        </div>

        <div class="p-3 p-md-4">
            <div class="list-group list-group-flush border-top border-bottom">
                @foreach ($sesiones as $sesion)
                    <div class="list-group-item px-0 py-4">
                        <div class="row align-items-center g-3">
                            <div class="col-lg-7">
                                <div class="d-flex align-items-start gap-3">
                                    <span class="rounded-circle bg-light text-primary border d-inline-flex align-items-center justify-content-center flex-shrink-0"
                                        style="width: 2.75rem; height: 2.75rem;" aria-hidden="true">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </span>
                                    <div>
                                        <h2 class="h4 mb-1">{{ $sesion['nombre'] }}</h2>
                                        <p class="mb-2 text-muted">{{ $sesion['descripcion'] }}</p>
                                        <span class="badge {{ $sesion['estado_clase'] }}">{{ $sesion['estado'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="d-flex flex-column flex-sm-row justify-content-lg-end gap-2">
                                    <a href="{{ route($sesion['ruta_registros']) }}" class="btn btn-custom-primary">
                                        Ver registros
                                    </a>
                                    <a href="{{ url($sesion['ruta_publica']) }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">
                                        Ver sitio público
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <p class="small text-muted mb-0 mt-4">Las próximas sesiones ordinarias y extraordinarias se incorporarán aquí desde el módulo de administración de sesiones.</p>
        </div>
    </div>
</x-app-layout>
