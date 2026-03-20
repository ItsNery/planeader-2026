<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Programa de Capacitación Municipal</title>
    <link rel="shortcut icon" href="https://puebla.gob.mx/templates/dst_puebla_2024/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estilos-registro-capacitacion.css') }}">
</head>

<body>

    <div class="container">
        <div class="registration-form-container">

            <div class="logo-container">
                <img src="{{ asset('img/logo-gobierno.png') }}" alt="Logos Dependencia" class="logo-img">
                {{-- <img src="/path/to/your/logos_dependencia_16_9.png" alt="Logos Dependencia" class="logo-img"> --}}
            </div>

            <h2 class="text-center form-title">Programa de Capacitación Municipal<br>Segundo Semestre<br> Día 2</h2>

            <form method="POST" action="{{ route('registro.store') }}" novalidate id="miFormulario"> @csrf @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="nombre_completo" class="form-label">Nombre completo</label>
                    <input type="text" class="form-control @error('nombre_completo') is-invalid @enderror"
                        id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo') }}" required>
                    @error('nombre_completo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="sexo" class="form-label">Sexo</label>
                        <select class="form-select @error('sexo') is-invalid @enderror" id="sexo" name="sexo"
                            required>
                            <option value="" selected disabled>Seleccionar...</option>
                            <option value="Hombre" {{ old('sexo') == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                            <option value="Mujer" {{ old('sexo') == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                            <option value="Otro" {{ old('sexo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('sexo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="cargo" class="form-label">Cargo</label>
                        <input type="text" class="form-control @error('cargo') is-invalid @enderror" id="cargo"
                            name="cargo" value="{{ old('cargo') }}" required>
                        @error('cargo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="municipio_id" class="form-label">Municipio</label> <select
                        class="form-select @error('municipio_id') is-invalid @enderror" id="municipio_id"
                        name="municipio_id" required>
                        <option value="" selected disabled>Seleccionar...</option>
                        {{-- $municipios viene del controlador (método create) --}}
                        @foreach ($municipios as $municipio)
                            <option value="{{ $municipio->id }}"
                                {{ old('municipio_id') == $municipio->id ? 'selected' : '' }}>
                                {{ $municipio->nombre_municipio }}
                            </option>
                        @endforeach
                    </select>
                    @error('municipio_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="correo_electronico" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control @error('correo_electronico') is-invalid @enderror"
                        id="correo_electronico" name="correo_electronico" value="{{ old('correo_electronico') }}"
                        required placeholder="ejemplo@dominio.com">
                    @error('correo_electronico')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telefono_oficina" class="form-label">Teléfono de oficina</label>
                        <input type="tel" class="form-control @error('telefono_oficina') is-invalid @enderror"
                            id="telefono_oficina" name="telefono_oficina" value="{{ old('telefono_oficina') }}"
                            placeholder="Ej: 222 123 4567">
                        @error('telefono_oficina')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="telefono_celular" class="form-label">Teléfono celular</label>
                        <input type="tel" class="form-control @error('telefono_celular') is-invalid @enderror"
                            id="telefono_celular" name="telefono_celular" value="{{ old('telefono_celular') }}"
                            placeholder="Ej: 221 123 4567">
                        @error('telefono_celular')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- comentado el 15 de mayo para que se muestre el 16 de mayo --}}
                {{-- <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg boton-registro-bg">Registrarse</button>
                </div> --}}
                <div id="mensajeEstado" class="text-center mb-2 fw-bold"></div>
                <div class="d-grid gap-2">
                    <button type="submit" id="botonRegistro"
                        class="btn btn-primary btn-lg boton-registro-bg">Registrarse</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Selecciona el botón, el formulario y el div para mensajes
            const boton = document.getElementById('botonRegistro');
            const formulario = document.getElementById('miFormulario');
            // Asegúrate de tener el div <div id="mensajeEstado"></div> en tu HTML
            const mensajeEstado = document.getElementById('mensajeEstado');

            // --- INICIO: LÓGICA DE JS ACTUALIZADA ---
            function actualizarEstadoBoton() {
                // Si el div de mensajes no existe, no continuamos para evitar errores
                if (!mensajeEstado) {
                    console.error("Error: No se encontró el elemento con id 'mensajeEstado'.");
                    return;
                }

                const ahora = new Date();
                const anio = 2025; // Año específico del evento

                // --- Definición de Fechas y Horas Límite ---
                // OJO: en JavaScript, los meses van de 0 (Ene) a 11 (Dic). Noviembre es 10.

                // Periodo 1: 18 Nov, 8:30 AM - 3:00 PM
                const inicioDia1 = new Date(anio, 10, 18, 8, 30, 0); // 18-Nov-2025 08:30:00
                const finDia1 = new Date(anio, 10, 18, 15, 0, 0); // 18-Nov-2025 15:00:00

                // Periodo 2: 19 Nov, 8:30 AM - 3:00 PM
                const inicioDia2 = new Date(anio, 10, 19, 8, 30, 0); // 19-Nov-2025 08:30:00
                const finDia2 = new Date(anio, 10, 19, 15, 0, 0); // 19-Nov-2025 15:00:00

                // Comprobar si estamos en uno de los periodos
                const enPeriodo1 = (ahora >= inicioDia1 && ahora <= finDia1);
                const enPeriodo2 = (ahora >= inicioDia2 && ahora <= finDia2);

                if (enPeriodo1 || enPeriodo2) {
                    // Abierto
                    boton.textContent = 'Registrarse';
                    boton.disabled = false;
                    mensajeEstado.textContent = '¡El registro está abierto!';
                    mensajeEstado.className = 'text-center mb-2 fw-bold text-success'; // Clase verde
                    actualizarClasesBoton(false);
                } else {
                    // Cerrado
                    boton.textContent = 'Registro Cerrado';
                    boton.disabled = true;
                    mensajeEstado.className = 'text-center mb-2 fw-bold text-danger'; // Clase roja
                    actualizarClasesBoton(true);

                    // Mensaje de ayuda específico
                    if (ahora < inicioDia1) {
                        mensajeEstado.textContent = 'El registro abrirá el 18 de noviembre a las 8:30 AM.';
                    } else if (ahora > finDia2) {
                        mensajeEstado.textContent = 'El periodo de registro ha finalizado.';
                    } else if (ahora > finDia1 && ahora < inicioDia2) {
                        // Estamos en el hueco entre el día 1 y el día 2
                        mensajeEstado.textContent =
                            'El registro del día 1 ha cerrado. El registro para el día 2 abre el 19 de noviembre a las 8:30 AM.';
                    } else {
                        // Casos durante los días pero fuera de hora (ej. 7am o 5pm)
                        mensajeEstado.textContent = 'El registro está disponible de 8:30 AM a 3:00 PM.';
                    }
                }
            }
            // --- FIN: LÓGICA DE JS ACTUALIZADA ---

            function actualizarClasesBoton(deshabilitado) {
                if (deshabilitado) {
                    boton.classList.remove('boton-registro-bg');
                    boton.classList.add('btn-secondary');
                } else {
                    boton.classList.add('boton-registro-bg');
                    boton.classList.remove('btn-secondary');
                }
            }

            // Prevenir el envío del formulario si el botón está deshabilitado
            if (formulario) {
                formulario.addEventListener('submit', function(event) {
                    if (boton.disabled) {
                        event.preventDefault(); // Detiene el envío del formulario
                        console.log('Intento de envío de formulario mientras el botón está deshabilitado.');
                    }
                });
            }

            // Ejecutar la función al cargar la página
            actualizarEstadoBoton();

            // Opcional: Actualizar el estado del botón periódicamente (ej. cada minuto)
            setInterval(actualizarEstadoBoton, 60000); // 60000 ms = 1 minuto
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
