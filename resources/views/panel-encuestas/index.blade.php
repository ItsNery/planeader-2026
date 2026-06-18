<x-app-layout>
    @section('title', 'Evaluaciones y Comentarios')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Evaluaciones y Comentarios del Sitio</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="myTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 50px;">ID</th>
                            <th scope="col" style="width: 80px;">Nivel</th>
                            <th scope="col">Comentario</th>
                            <th scope="col">Página Evaluada</th>
                            <th scope="col">Info. Técnica</th>
                            <th scope="col" style="width: 150px;">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($encuestas as $encuesta)
                        <tr>
                            <td>{{ $encuesta->id }}</td>
                            <td class="text-center">
                                @if($encuesta->satisfaccion == 3)
                                    <span class="badge bg-success rounded-pill px-3 py-2" title="Útil">😊 Útil</span>
                                @elseif($encuesta->satisfaccion == 2)
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2" title="Regular">😐 Regular</span>
                                @else
                                    <span class="badge bg-danger rounded-pill px-3 py-2" title="Poco útil">😞 Poco útil</span>
                                @endif
                            </td>
                            <td>
                                @if($encuesta->comentario)
                                    {{ $encuesta->comentario }}
                                @else
                                    <span class="text-muted fst-italic">Sin comentario</span>
                                @endif
                            </td>
                            <td>
                                @if($encuesta->url_evaluada)
                                    <a href="{{ $encuesta->url_evaluada }}" target="_blank" rel="noopener noreferrer" class="text-truncate d-inline-block" style="max-width: 250px;" title="{{ $encuesta->url_evaluada }}">
                                        {{ \Illuminate\Support\Str::limit($encuesta->url_evaluada, 35) }}
                                        <i class="fa-solid fa-arrow-up-right-from-square fa-xs ms-1"></i>
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#techInfoModal{{ $encuesta->id }}">
                                    <i class="fa-solid fa-circle-info me-1"></i> Detalles
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="techInfoModal{{ $encuesta->id }}" tabindex="-1" aria-labelledby="techInfoModalLabel{{ $encuesta->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="techInfoModalLabel{{ $encuesta->id }}">Información Técnica (ID: {{ $encuesta->id }})</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                <ul class="list-group list-group-flush">
                                                    @if($encuesta->user_agent)
                                                        <li class="list-group-item"><strong>Navegador/User Agent:</strong> <br> <small class="text-muted">{{ $encuesta->user_agent }}</small></li>
                                                    @endif
                                                    @if($encuesta->resolucion)
                                                        <li class="list-group-item"><strong>Resolución de pantalla:</strong> {{ $encuesta->resolucion }}</li>
                                                    @endif
                                                    @if($encuesta->lenguaje)
                                                        <li class="list-group-item"><strong>Lenguaje:</strong> {{ $encuesta->lenguaje }}</li>
                                                    @endif
                                                    @if($encuesta->zona_horaria)
                                                        <li class="list-group-item"><strong>Zona horaria:</strong> {{ $encuesta->zona_horaria }}</li>
                                                    @endif
                                                    @if($encuesta->ip)
                                                        <li class="list-group-item"><strong>IP:</strong> {{ $encuesta->ip }}</li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $encuesta->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No hay evaluaciones registradas aún.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
