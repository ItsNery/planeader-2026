<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estilos-registro-capacitacion.css') }}">
    <title>Registro confirmado</title>
</head>

<body>
    <main class="container">
        <div class="registration-form-container copladep-confirmacion mx-auto">
            <div class="logo-container">
                <img src="{{ asset('img/Logos-SPFA_.png') }}" alt="Gobierno del Estado de Puebla y Secretaría de Planeación, Finanzas y Administración" class="logo-img">
                <img src="{{ asset('img/Copladep_Logo_v1.png') }}" alt="COPLADEP" class="logo-img">
            </div>
            <div class="copladep-confirmacion__contenido">
                <h1 class="form-title copladep-confirmacion__titulo">Registro confirmado</h1>
                <p>Tu registro de asistencia al COPLADEP se realizó correctamente.</p>
                <p class="copladep-confirmacion__modalidad">Modalidad de asistencia: <strong>{{ ucfirst($registro->modalidad) }}</strong></p>
                <p>Descarga tu documento de asistencia para consultar los detalles del evento.</p>
                <a class="btn btn-primary boton-registro-bg copladep-confirmacion__boton"
                    href="{{ route('copladep-registro.pdf', $registro->token_qr ?: $registro->id) }}">Descargar documento PDF</a>
                <p class="copladep-confirmacion__ayuda">El documento incluye tu acceso, la ficha del evento y el orden del día.</p>
                <a class="copladep-confirmacion__volver" href="{{ url($registro->sesionCopladep?->ruta_publica ?: '/copladep') }}">
                    {{ $registro->sesionCopladep?->ruta_publica ? 'Volver a la página de la sesión' : 'Volver a COPLADEP' }}
                </a>
            </div>
        </div>
    </main>
    <iframe src="{{ route('copladep-registro.pdf', $registro->token_qr ?: $registro->id) }}" title="Descarga automática del documento de asistencia" hidden></iframe>
</body>

</html>
