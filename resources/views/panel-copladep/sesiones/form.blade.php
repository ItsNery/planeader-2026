<x-app-layout>
    @section('title', $sesion->exists ? 'Editar sesión COPLADEP' : 'Nueva sesión COPLADEP')

    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3 px-3">
            <h1 class="h2 mb-1">{{ $sesion->exists ? 'Editar sesión' : 'Nueva sesión' }}</h1>
            <p class="text-white mb-0">Los datos configurados aquí determinan el registro público, el PDF y el check-in.
            </p>
        </div>
        <form method="POST"
            action="{{ $sesion->exists ? route('panel-copladep-sesiones.update', $sesion) : route('panel-copladep-sesiones.store') }}"
            class="p-3">
            @csrf
            @if ($sesion->exists)
                @method('PUT')
            @endif
            <div class="row g-3">
                <div class="col-md-8"><label class="form-label">Nombre</label><input class="form-control" name="nombre"
                        value="{{ old('nombre', $sesion->nombre) }}" required></div>
                <div class="col-md-2"><label class="form-label">Año</label><input class="form-control" type="number"
                        name="anio" value="{{ old('anio', $sesion->anio ?: now()->year) }}" required></div>
                <div class="col-md-2"><label class="form-label">Número</label><input class="form-control" type="number"
                        min="1" name="numero" value="{{ old('numero', $sesion->numero) }}"></div>
                <div class="col-md-4"><label class="form-label">Tipo</label><select class="form-select" name="tipo">
                        <option value="ordinaria" @selected(old('tipo', $sesion->tipo ?: 'ordinaria') === 'ordinaria')>Ordinaria</option>
                        <option value="extraordinaria" @selected(old('tipo', $sesion->tipo) === 'extraordinaria')>Extraordinaria</option>
                    </select></div>
                <div class="col-md-4"><label class="form-label">Estado</label><select class="form-select"
                        name="estado">
                        <option value="preparacion" @selected(old('estado', $sesion->estado ?: 'preparacion') === 'preparacion')>En preparación</option>
                        <option value="abierta" @selected(old('estado', $sesion->estado) === 'abierta')>Abierta</option>
                        <option value="cerrada" @selected(old('estado', $sesion->estado) === 'cerrada')>Cerrada</option>
                        <option value="concluida" @selected(old('estado', $sesion->estado) === 'concluida')>Concluida</option>
                    </select></div>
                <div class="col-md-4"><label class="form-label">Fecha y hora del evento</label><input
                        class="form-control" type="datetime-local" name="fecha_evento"
                        value="{{ old('fecha_evento', optional($sesion->fecha_evento)->format('Y-m-d\TH:i')) }}"></div>
                <div class="col-md-6"><label class="form-label">Inicio de registro</label><input class="form-control"
                        type="datetime-local" name="registro_inicio"
                        value="{{ old('registro_inicio', optional($sesion->registro_inicio)->format('Y-m-d\TH:i')) }}">
                </div>
                <div class="col-md-6"><label class="form-label">Fin de registro</label><input class="form-control"
                        type="datetime-local" name="registro_fin"
                        value="{{ old('registro_fin', optional($sesion->registro_fin)->format('Y-m-d\TH:i')) }}"></div>
                <div class="col-md-6"><label class="form-label">Lugar</label><input class="form-control" name="lugar"
                        value="{{ old('lugar', $sesion->lugar) }}"></div>
                <div class="col-md-6"><label class="form-label">Enlace virtual</label><input class="form-control"
                        type="url" name="enlace_virtual"
                        value="{{ old('enlace_virtual', $sesion->enlace_virtual) }}"></div>
                <div class="col-md-6"><label class="form-label">Ruta pública existente</label><input
                        class="form-control" name="ruta_publica"
                        value="{{ old('ruta_publica', $sesion->ruta_publica) }}"></div>
                <div class="col-md-6"><label class="form-label">Descripción</label><input class="form-control"
                        name="descripcion" value="{{ old('descripcion', $sesion->descripcion) }}"></div>
                <div class="col-12"><label class="form-label">Orden del día</label>
                    <textarea class="form-control" name="agenda_texto" rows="5" placeholder="Un punto por línea">{{ old('agenda_texto', implode("\n", $sesion->agenda ?: [])) }}</textarea>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger mt-3">Revise los campos capturados.</div>
            @endif
            <div class="mt-4 d-flex gap-2"><a href="{{ route('panel-copladep-sesiones.index') }}"
                    class="btn btn-outline-secondary">Cancelar</a><button class="btn btn-custom-primary">Guardar
                    sesión</button></div>
        </form>
    </div>
</x-app-layout>
