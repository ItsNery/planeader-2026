<x-app-layout>
    @section('title', 'Capacidad de agenda')

    @if ($message = Session::get('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '{{ $message }}'
                });
            });
        </script>
    @endif

    @php
        $horariosIniciales = old('horarios', \App\Models\AgendaEvento::HORARIOS_PREDETERMINADOS);
        $maximoInicial = (int) old('max_eventos', count($horariosIniciales));
        $capacidadesParaJavascript = $capacidades->mapWithKeys(fn ($capacidad) => [
            $capacidad->fecha_evento->format('Y-m-d') => [
                'max_eventos' => (int) $capacidad->max_eventos,
                'horarios' => $capacidad->horarios,
            ],
        ]);
    @endphp

    <div class="container py-3">
        <div class="tarjeta-admin p-4 rounded-3 bg-white">
            <div class="form-header py-3 mb-4">
                <h2 class="fw-bold m-0">Capacidad de agenda por fecha</h2>
                <p class="text-white mb-0 small opacity-75">
                    Configura cuántas solicitudes pueden reservarse en una fecha y los horarios que podrá elegir el público.
                </p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>Revisa la configuración capturada.</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="alert alert-light border mb-4">
                <i class="fa-solid fa-circle-info me-1"></i>
                Si una fecha no se configura aquí, conserva el límite de 2 eventos con los horarios de 10:00 a 11:00 y 13:00 a 14:00 hrs.
                El máximo debe coincidir con el número de horarios definidos.
            </div>

            <form action="{{ route('panel-eventos.capacidades-agenda.store') }}" method="POST" id="agenda-capacity-form"
                data-capacities='@json($capacidadesParaJavascript)'>
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="fecha_evento" class="form-label fw-bold">Fecha *</label>
                        <input type="date" id="fecha_evento" name="fecha_evento"
                            class="form-control @error('fecha_evento') is-invalid @enderror"
                            value="{{ old('fecha_evento') }}" required>
                        @error('fecha_evento')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="max_eventos" class="form-label fw-bold">Máximo de eventos *</label>
                        <input type="number" id="max_eventos" name="max_eventos" min="1" max="23"
                            class="form-control @error('max_eventos') is-invalid @enderror" value="{{ $maximoInicial }}" required>
                        @error('max_eventos')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 d-grid">
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa-solid fa-save me-1"></i> Guardar capacidad
                        </button>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="form-label fw-bold">Horarios disponibles *</label>
                    <p class="form-text mt-0">Cada horario representa un cupo y debe dejar al menos una hora libre antes del siguiente.</p>
                    <div id="agenda-capacity-slots" class="row g-3">
                        @foreach ($horariosIniciales as $indice => $horario)
                            <div class="col-sm-6 col-lg-3">
                                <label class="form-label small" for="horario-{{ $indice }}">Horario {{ $indice + 1 }}</label>
                                <input type="time" id="horario-{{ $indice }}" name="horarios[]" class="form-control"
                                    value="{{ $horario }}" required>
                            </div>
                        @endforeach
                    </div>
                    @error('horarios')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                    @error('horarios.*')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </form>
        </div>

        <div class="tarjeta-admin p-4 rounded-3 bg-white mt-4">
            <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                <div>
                    <h3 class="h4 mb-1">Fechas configuradas</h3>
                    <p class="text-muted mb-0">Eliminar una configuración restablece la capacidad predeterminada de 2 eventos.</p>
                </div>
                <a href="{{ route('panel-eventos.index') }}" class="btn btn-outline-secondary">Volver a eventos</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Máximo</th>
                            <th>Horarios disponibles</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($capacidades as $capacidad)
                            <tr>
                                <td>{{ $capacidad->fecha_evento->locale('es')->translatedFormat('d \d\e F \d\e Y') }}</td>
                                <td>{{ $capacidad->max_eventos }} eventos</td>
                                <td>{{ implode(' | ', $capacidad->horarios) }} hrs</td>
                                <td class="text-center">
                                    <form action="{{ route('panel-eventos.capacidades-agenda.destroy', $capacidad) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('¿Restablecer la capacidad predeterminada para esta fecha?')">
                                            Restablecer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No hay fechas con capacidad especial.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('agenda-capacity-form');
                const dateInput = document.getElementById('fecha_evento');
                const maxInput = document.getElementById('max_eventos');
                const slotsContainer = document.getElementById('agenda-capacity-slots');
                const capacities = JSON.parse(form.dataset.capacities || '{}');
                const defaultSchedules = @json(\App\Models\AgendaEvento::HORARIOS_PREDETERMINADOS);
                const hasValidationErrors = @json($errors->any());

                const slotValues = () => [...slotsContainer.querySelectorAll('input[name="horarios[]"]')]
                    .map((input) => input.value);

                const renderSlots = (count, values = []) => {
                    slotsContainer.replaceChildren();

                    for (let index = 0; index < count; index += 1) {
                        const column = document.createElement('div');
                        column.className = 'col-sm-6 col-lg-3';

                        const label = document.createElement('label');
                        label.className = 'form-label small';
                        label.htmlFor = `horario-${index}`;
                        label.textContent = `Horario ${index + 1}`;

                        const input = document.createElement('input');
                        input.type = 'time';
                        input.id = `horario-${index}`;
                        input.name = 'horarios[]';
                        input.className = 'form-control';
                        input.value = values[index] || defaultSchedules[index] || '';
                        input.required = true;

                        column.append(label, input);
                        slotsContainer.append(column);
                    }
                };

                const normalizeMaximum = () => Math.min(23, Math.max(1, Number(maxInput.value) || 1));

                maxInput.addEventListener('input', function() {
                    const maximum = normalizeMaximum();
                    renderSlots(maximum, slotValues());
                });

                dateInput.addEventListener('change', function() {
                    const capacity = capacities[dateInput.value];
                    const maximum = capacity ? capacity.max_eventos : 2;
                    maxInput.value = maximum;
                    renderSlots(maximum, capacity ? capacity.horarios : defaultSchedules);
                });

                if (!hasValidationErrors && dateInput.value && capacities[dateInput.value]) {
                    const capacity = capacities[dateInput.value];
                    maxInput.value = capacity.max_eventos;
                    renderSlots(capacity.max_eventos, capacity.horarios);
                }
            });
        </script>
    @endpush
</x-app-layout>
