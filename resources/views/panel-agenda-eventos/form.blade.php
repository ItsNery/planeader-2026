<x-app-layout>
    @section('title', $evento->exists ? 'Editar solicitud de agenda' : 'Crear evento de agenda')

    <div class="container py-3">
        <div class="tarjeta-admin agenda-admin-card p-4 rounded-3 bg-white">
            <div class="form-header py-3 mb-4">
                <h2 class="fw-bold m-0">
                    {{ $evento->exists ? 'Editar solicitud de agenda' : 'Crear evento de agenda' }}
                </h2>
                <p class="text-white mb-0 small opacity-75">
                    {{ $evento->exists ? 'Actualiza la información y valida los cambios del evento.' : 'Registra una sesión, mesa técnica o sesión del COPLADEP en la agenda institucional.' }}
                </p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger agenda-admin-alert" role="alert">
                    <strong><i class="fa-solid fa-circle-exclamation me-1"></i>Revisa la información capturada.</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $fechaInicial = old('fecha_evento', optional($evento->fecha_evento)->format('Y-m-d'));
                $horariosIniciales = $fechaInicial
                    ? ($horariosDisponiblesPorFecha[$fechaInicial] ?? \App\Models\AgendaEvento::HORARIOS_PREDETERMINADOS)
                    : \App\Models\AgendaEvento::HORARIOS_PREDETERMINADOS;
                $horaInicioSeleccionada = old('hora_inicio', $evento->hora_inicio ? substr((string) $evento->hora_inicio, 0, 5) : $horariosIniciales[0]);
            @endphp

            <form action="{{ $evento->exists ? route('panel-agenda-eventos.update', $evento) : route('panel-agenda-eventos.store') }}"
                method="POST" novalidate>
                @csrf
                @if ($evento->exists)
                    @method('PUT')
                @endif

                <div class="row g-4">
                    <div class="col-lg-8 border-end-lg pe-lg-4">
                        <section class="agenda-admin-section">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-calendar-check text-primary-integration"></i>
                                Información de la actividad
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="tipo_evento" class="fw-bold mb-1">Tipo de actividad: *</label>
                                    <select id="tipo_evento" name="tipo_evento" class="form-select @error('tipo_evento') is-invalid @enderror" required>
                                        <option value="sesion" @selected(old('tipo_evento', $evento->tipo_evento) === 'sesion')>Sesión de subcomité</option>
                                        <option value="mesa_tecnica" @selected(old('tipo_evento', $evento->tipo_evento) === 'mesa_tecnica')>Mesa técnica de trabajo</option>
                                        <option value="sesion_copladep_ordinaria" @selected(old('tipo_evento', $evento->tipo_evento) === 'sesion_copladep_ordinaria')>Sesión Ordinaria del COPLADEP</option>
                                        <option value="sesion_copladep_extraordinaria" @selected(old('tipo_evento', $evento->tipo_evento) === 'sesion_copladep_extraordinaria')>Sesión Extraordinaria del COPLADEP</option>
                                    </select>
                                    @error('tipo_evento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="subcomite_id" class="fw-bold mb-1">Subcomité:</label>
                                    <select id="subcomite_id" name="subcomite_id" class="form-select @error('subcomite_id') is-invalid @enderror">
                                        <option value="" disabled>Selecciona un subcomité</option>
                                        <option value="" @selected(old('subcomite_id') === '' || (is_null(old('subcomite_id')) && is_null($evento->subcomite_id)))>Programa Especial</option>
                                        @foreach ($subcomites as $subcomite)
                                            <option value="{{ $subcomite->id }}" @selected(old('subcomite_id', $evento->subcomite_id) == $subcomite->id)>{{ $subcomite->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">Selecciona "Programa Especial" para mesas técnicas o deja esta opción para sesiones del COPLADEP.</div>
                                    @error('subcomite_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label for="tematica" class="fw-bold mb-1">Temática:</label>
                                    <input id="tematica" name="tematica" type="text" class="form-control @error('tematica') is-invalid @enderror"
                                        value="{{ old('tematica', $evento->tematica) }}" placeholder="Describe brevemente el tema de la reunión.">
                                    @error('tematica')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="institucion_organizadora" class="fw-bold mb-1">Institución organizadora: *</label>
                                    <input id="institucion_organizadora" name="institucion_organizadora" type="text" class="form-control @error('institucion_organizadora') is-invalid @enderror"
                                        value="{{ old('institucion_organizadora', $evento->institucion_organizadora) }}" required>
                                    @error('institucion_organizadora')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="modalidad" class="fw-bold mb-1">Modalidad: *</label>
                                    <select id="modalidad" name="modalidad" class="form-select @error('modalidad') is-invalid @enderror" required>
                                        <option value="virtual" @selected(old('modalidad', $evento->modalidad) === 'virtual')>Virtual</option>
                                        <option value="presencial" @selected(old('modalidad', $evento->modalidad) === 'presencial')>Presencial</option>
                                    </select>
                                    @error('modalidad')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </section>

                        <section class="agenda-admin-section">
                            <div class="custom-section-title">
                                <i class="fa-regular fa-clock text-primary-integration"></i>
                                Fecha y horario
                            </div>
                            <div class="agenda-admin-note mb-3">
                                <i class="fa-solid fa-circle-info"></i>
                                <span>Por defecto la agenda permite dos actividades por día, con inicio a las 10:00 y 13:00 hrs. Las fechas con capacidad especial usan los horarios configurados.</span>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="fecha_evento" class="fw-bold mb-1">Fecha del evento: *</label>
                                    <input id="fecha_evento" name="fecha_evento" type="date" class="form-control @error('fecha_evento') is-invalid @enderror"
                                        value="{{ old('fecha_evento', optional($evento->fecha_evento)->format('Y-m-d')) }}" required>
                                    @error('fecha_evento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="hora_inicio" class="fw-bold mb-1">Horario: *</label>
                                    <select id="hora_inicio" name="hora_inicio" class="form-select @error('hora_inicio') is-invalid @enderror" required>
                                        @foreach ($horariosIniciales as $horario)
                                            <option value="{{ $horario }}" @selected($horaInicioSeleccionada === $horario)>
                                                {{ $horario }} hrs
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('hora_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </section>

                        <section class="agenda-admin-section mb-lg-0">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-user-tie text-primary-integration"></i>
                                Persona responsable
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="solicitante_nombre" class="fw-bold mb-1">Nombre completo: *</label>
                                    <input id="solicitante_nombre" name="solicitante_nombre" type="text" class="form-control @error('solicitante_nombre') is-invalid @enderror"
                                        value="{{ old('solicitante_nombre', $evento->solicitante_nombre) }}" required>
                                    @error('solicitante_nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="solicitante_cargo" class="fw-bold mb-1">Cargo:</label>
                                    <input id="solicitante_cargo" name="solicitante_cargo" type="text" class="form-control @error('solicitante_cargo') is-invalid @enderror"
                                        value="{{ old('solicitante_cargo', $evento->solicitante_cargo) }}">
                                    @error('solicitante_cargo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="solicitante_email" class="fw-bold mb-1">Correo electrónico: *</label>
                                    <input id="solicitante_email" name="solicitante_email" type="email" class="form-control @error('solicitante_email') is-invalid @enderror"
                                        value="{{ old('solicitante_email', $evento->solicitante_email) }}" required>
                                    @error('solicitante_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="solicitante_telefono" class="fw-bold mb-1">Teléfono:</label>
                                    <input id="solicitante_telefono" name="solicitante_telefono" type="text" class="form-control @error('solicitante_telefono') is-invalid @enderror"
                                        value="{{ old('solicitante_telefono', $evento->solicitante_telefono) }}">
                                    @error('solicitante_telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label for="correos_invitados" class="fw-bold mb-1">Correos de invitados:</label>
                                    <textarea id="correos_invitados" name="correos_invitados" rows="3" class="form-control @error('correos_invitados') is-invalid @enderror" placeholder="Uno por línea o separados por coma">{{ old('correos_invitados', $evento->correos_invitados) }}</textarea>
                                    <div class="form-text">Se incluyen al exportar el evento a Google Calendar.</div>
                                    @error('correos_invitados')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="col-lg-4">
                        <section class="agenda-admin-section">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-location-dot text-primary-integration"></i>
                                Datos operativos
                            </div>
                            <div class="mb-3">
                                <label for="ubicacion" class="fw-bold mb-1">Ubicación:</label>
                                <textarea id="ubicacion" name="ubicacion" rows="3" class="form-control @error('ubicacion') is-invalid @enderror" placeholder="Lugar del evento presencial.">{{ old('ubicacion', $evento->ubicacion) }}</textarea>
                                @error('ubicacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="liga_videoconferencia" class="fw-bold mb-1">Liga de videoconferencia:</label>
                                <input id="liga_videoconferencia" name="liga_videoconferencia" type="url" class="form-control @error('liga_videoconferencia') is-invalid @enderror"
                                    value="{{ old('liga_videoconferencia', $evento->liga_videoconferencia) }}" placeholder="https://">
                                <div class="form-text">Visible únicamente para el personal administrador.</div>
                                @error('liga_videoconferencia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </section>

                        <section class="agenda-admin-section">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-sliders text-primary-integration"></i>
                                Publicación y seguimiento
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="fw-bold mb-1">Estado: *</label>
                                <select id="estado" name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                                    @foreach (['pendiente', 'confirmado', 'rechazado', 'cancelado'] as $estado)
                                        <option value="{{ $estado }}" @selected(old('estado', $evento->estado ?: 'confirmado') === $estado)>{{ ucfirst($estado) }}</option>
                                    @endforeach
                                </select>
                                @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="publicado" class="fw-bold mb-1">Visible en calendario público:</label>
                                <select id="publicado" name="publicado" class="form-select @error('publicado') is-invalid @enderror">
                                    <option value="1" @selected(old('publicado', $evento->publicado ?? true))>Sí, mostrar</option>
                                    <option value="0" @selected(!old('publicado', $evento->publicado ?? true))>No, ocultar</option>
                                </select>
                                @error('publicado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="observaciones_admin" class="fw-bold mb-1">Observaciones administrativas:</label>
                                <textarea id="observaciones_admin" name="observaciones_admin" rows="4" class="form-control @error('observaciones_admin') is-invalid @enderror">{{ old('observaciones_admin', $evento->observaciones_admin) }}</textarea>
                                @error('observaciones_admin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mt-3">
                                <label for="comentarios" class="fw-bold mb-1">Comentarios del solicitante:</label>
                                <textarea id="comentarios" name="comentarios" rows="3" class="form-control @error('comentarios') is-invalid @enderror">{{ old('comentarios', $evento->comentarios) }}</textarea>
                                @error('comentarios')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </section>

                        <div class="agenda-admin-actions">
                            <button type="submit" class="btn btn-custom-primary shadow-sm">
                                <i class="fa-solid fa-save me-2"></i>{{ $evento->exists ? 'Guardar cambios' : 'Crear evento' }}
                            </button>
                            <a href="{{ route('panel-agenda-eventos.index') }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-arrow-left me-2"></i>Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const type = document.getElementById('tipo_evento');
                const subcomite = document.getElementById('subcomite_id');
                const dateInput = document.getElementById('fecha_evento');
                const startTimeSelect = document.getElementById('hora_inicio');
                const schedulesByDate = @json($horariosDisponiblesPorFecha);
                const defaultSchedules = @json(\App\Models\AgendaEvento::HORARIOS_PREDETERMINADOS);

                if (!type || !subcomite) return;

                const refreshSubcomite = () => {
                    const esSesionCopladep = [
                        'sesion_copladep_ordinaria',
                        'sesion_copladep_extraordinaria'
                    ].includes(type.value);

                    subcomite.disabled = esSesionCopladep;
                    subcomite.required = false;

                    if (esSesionCopladep) {
                        subcomite.value = '';
                    }
                };

                const formatSchedule = (start) => {
                    return `${start} hrs`;
                };

                const refreshSchedules = () => {
                    const selectedValue = startTimeSelect.value;
                    const schedules = [...new Set(schedulesByDate[dateInput.value] || defaultSchedules)];
                    startTimeSelect.replaceChildren();

                    schedules.forEach((schedule) => {
                        const option = document.createElement('option');
                        option.value = schedule;
                        option.textContent = formatSchedule(schedule);
                        startTimeSelect.append(option);
                    });

                    startTimeSelect.value = schedules.includes(selectedValue) ? selectedValue : schedules[0];
                };

                type.addEventListener('change', refreshSubcomite);
                dateInput.addEventListener('change', refreshSchedules);
                refreshSubcomite();
                refreshSchedules();
            });
        </script>
    @endpush
</x-app-layout>
