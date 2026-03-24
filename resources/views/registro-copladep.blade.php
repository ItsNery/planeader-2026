<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Primera Sesión Ordinaria 2026 del COPLADEP</title>
    <link rel="shortcut icon" href="https://puebla.gob.mx/templates/dst_puebla_2024/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estilos-registro-capacitacion.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <style>
        .signature-wrapper {
            position: relative;
            width: 100%;
            height: 200px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            background-color: #fafafa;
        }

        .signature-pad {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            touch-action: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="registration-form-container mx-auto">
            <div class="logo-container">
                <img src="{{ asset('img/logo-gobierno.png') }}" alt="Logos Dependencia" class="logo-img">
                <img src="{{ asset('img/Logo-Copladep.png') }}" alt="Logos Dependencia" class="logo-img">
            </div>

            <h2 class="text-center form-title">
                Registro de asistencia de la Primera Sesión Ordinaria 2026 de la Asamblea Plenaria del COPLADEP
            </h2>

            <form method="POST" action="{{ route('copladep-registro.store') }}" novalidate id="miFormulario"> @csrf
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        Revise los campos en rojo o la firma.
                    </div>
                @endif

                <div class="mb-3">
                    <label for="nombre_completo" class="form-label">Nombre completo</label>
                    <input type="text" class="form-control @error('nombre_completo') is-invalid @enderror"
                        id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo') }}" required maxlength="50">
                    @error('nombre_completo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="sexo" class="form-label">Sexo</label>
                        <select class="form-select @error('sexo') is-invalid @enderror" id="sexo" name="sexo" required>
                            <option value="" selected disabled>Seleccionar...</option>
                            <option value="Hombre" {{ old('sexo') == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                            <option value="Mujer" {{ old('sexo') == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                        </select>
                        @error('sexo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="cargo" class="form-label">Cargo</label>
                        <input type="text" class="form-control @error('cargo') is-invalid @enderror" id="cargo"
                            name="cargo" value="{{ old('cargo') }}" required maxlength="100">
                        @error('cargo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="municipio_id" class="form-label">Municipio</label>
                    <select class="form-select @error('municipio_id') is-invalid @enderror" id="municipio_id"
                        name="municipio_id" required autocomplete="off">
                        <option value="">Seleccionar...</option>
                        @foreach ($municipios as $municipio)
                            <option value="{{ $municipio->id }}" {{ old('municipio_id') == $municipio->id ? 'selected' : '' }}>
                                {{ $municipio->nombre_municipio }}
                            </option>
                        @endforeach
                    </select>
                    @error('municipio_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="correo_electronico" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control @error('correo_electronico') is-invalid @enderror"
                        id="correo_electronico" name="correo_electronico" value="{{ old('correo_electronico') }}"
                        required placeholder="ejemplo@dominio.com" maxlength="50">
                    @error('correo_electronico')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telefono_oficina" class="form-label">Teléfono de oficina</label>
                        <input type="tel" class="form-control @error('telefono_oficina') is-invalid @enderror"
                            id="telefono_oficina" name="telefono_oficina" value="{{ old('telefono_oficina') }}"
                            placeholder="Ej: 222 123 4567" maxlength="20">
                        @error('telefono_oficina')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="telefono_celular" class="form-label">Teléfono celular</label>
                        <input type="tel" class="form-control @error('telefono_celular') is-invalid @enderror"
                            id="telefono_celular" name="telefono_celular" value="{{ old('telefono_celular') }}"
                            placeholder="Ej: 221 123 4567" maxlength="20">
                        @error('telefono_celular')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <div class="mb-4 mt-4">
                            <label class="form-label fw-bold">Firma o rúbrica</label>
                            <p class="text-muted small mb-1">Por favor, firme o rubrique en el recuadro inferior usando su ratón o
                                dedo.</p>

                            <div class="signature-wrapper">
                                <canvas id="signature-pad" class="signature-pad"></canvas>
                            </div>

                            <button type="button" id="clear-signature"
                                class="btn btn-sm btn-outline-secondary mt-2">Limpiar Firma</button>

                            <input type="hidden" name="firma" id="firma" required>

                            @error('firma')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div id="mensajeEstado" class="text-center mb-2 fw-bold"></div>
                <div class="d-grid gap-2">
                    <button type="submit" id="botonRegistro"
                        class="btn btn-primary btn-lg boton-registro-bg">Registrarse</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new TomSelect("#municipio_id", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            maxOptions: null,
            placeholder: 'Busque o seleccione su municipio...'
        });

        const canvas = document.getElementById('signature-pad');
        const hiddenFirmaInput = document.getElementById('firma');
        const clearButton = document.getElementById('clear-signature');
        const boton = document.getElementById('botonRegistro');
        const mensajeEstado = document.getElementById('mensajeEstado');
        const formulario = document.getElementById('miFormulario');
        function actualizarEstadoBoton() {
            if (!mensajeEstado) return;

            const ahora = new Date();

            // Recuerda: el mes empieza en 0. Abril es 3.
            const inicioRegistro = new Date(2026, 2, 24, 8, 30, 0); // 10-Abr-2026 08:30:00
            const finRegistro = new Date(2026, 2, 24, 15, 0, 0);    // 10-Abr-2026 15:00:00

            if (ahora >= inicioRegistro && ahora <= finRegistro) {
                // Abierto
                boton.textContent = 'Registrarse';
                boton.disabled = false;
                boton.classList.remove('btn-secondary');
                boton.classList.add('btn-primary');
                mensajeEstado.textContent = '¡El registro está abierto!';
                mensajeEstado.className = 'text-center mb-2 fw-bold text-success';
            } else {
                // Cerrado
                boton.textContent = 'Registro Cerrado';
                boton.disabled = true;
                boton.classList.remove('btn-primary');
                boton.classList.add('btn-secondary');
                mensajeEstado.className = 'text-center mb-2 fw-bold text-danger';

                if (ahora < inicioRegistro) {
                    mensajeEstado.textContent = 'El registro abrirá el 10 de abril a las 8:30 AM.';
                } else if (ahora > finRegistro) {
                    mensajeEstado.textContent = 'El periodo de registro ha finalizado.';
                }
            }
        }

        // Prevenir el envío si por alguna razón manipulan el DOM
        if (formulario) {
            formulario.addEventListener('submit', function (event) {
                if (boton.disabled) {
                    event.preventDefault();
                }
            });
        }

        // Ejecutar al cargar la página
        actualizarEstadoBoton();

        // Actualizar cada minuto
        setInterval(actualizarEstadoBoton, 60000);

        // Inicializar Signature Pad
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'rgb(0, 0, 0)'
        });

        // Ajustar el tamaño del canvas para que no se vea borroso y funcione bien en móviles
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear();
        }
        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        // Botón para limpiar
        clearButton.addEventListener('click', function (event) {
            signaturePad.clear();
        });

        // Al enviar el formulario, capturar la firma
        formulario.addEventListener('submit', function (event) {
            if (signaturePad.isEmpty()) {
                event.preventDefault(); // Detener envío
                alert("Por favor, proporcione su firma antes de enviar el registro.");
            } else {
                // Convertir el dibujo a Base64 y guardarlo en el input hidden
                const dataURL = signaturePad.toDataURL('image/png');
                hiddenFirmaInput.value = dataURL;
            }
        });
    });
</script>
</body>

</html>