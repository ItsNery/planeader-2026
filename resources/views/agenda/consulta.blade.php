@extends('layouts.plantilla')

@section('title', 'Consultar solicitud de agenda')
@section('content')
    <section class="container py-5">
        <div class="text-center mb-4"><h1 class="titulo-tematica">Consultar solicitud</h1><p>Ingresa el folio y el correo utilizados al solicitar la fecha.</p></div>
        <form method="GET" action="{{ route('agenda-eventos.consulta') }}" class="row g-3 justify-content-center mb-5">
            <div class="col-md-4"><label class="form-label">Folio</label><input name="folio" class="form-control" value="{{ request('folio') }}" required placeholder="AG-20260812-ABC123"></div>
            <div class="col-md-4"><label class="form-label">Correo</label><input type="email" name="solicitante_email" class="form-control" value="{{ request('solicitante_email') }}" required></div>
            <div class="col-md-2 d-flex align-items-end"><button class="btn btn-outline-color-1 w-100">Consultar</button></div>
        </form>
        @if(request()->filled('folio'))
            @if($evento)
                <div class="card shadow-sm"><div class="card-body"><h2 class="h4">{{ $evento->tituloPublico() }}</h2><p><strong>Folio:</strong> {{ $evento->folio }}</p><p><strong>Estado:</strong> {{ ucfirst($evento->estado) }}</p><p><strong>Institución:</strong> {{ $evento->institucion_organizadora }}</p><p class="text-muted">La fecha, horario, ubicación y liga de videoconferencia se comunicarán por el medio institucional correspondiente.</p></div></div>
            @else
                <div class="alert alert-warning text-center">No encontramos una solicitud con esos datos.</div>
            @endif
        @endif
    </section>
@endsection
