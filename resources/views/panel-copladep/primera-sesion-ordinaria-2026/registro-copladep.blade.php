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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

                <div class="mb-4 text-center">
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="tipo_asistente" id="soy_titular" value="titular" 
                            {{ old('tipo_asistente', 'titular') == 'titular' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="soy_titular">Soy el Titular / Invitado</label>

                        <input type="radio" class="btn-check" name="tipo_asistente" id="soy_representante" value="representante"
                            {{ old('tipo_asistente') == 'representante' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="soy_representante">Vengo en Representación</label>
                    </div>
                </div>

                <div class="mb-4 bg-light p-3 rounded border" id="seccion_buscador_invitado">
                    <label id="label_buscador" for="invitado_id" class="form-label fw-bold">Busque su nombre en la lista:</label>
                    <select class="form-select" id="invitado_id" name="invitado_id" required>
                        <option value="">Buscar nombre del funcionario...</option>
                        @foreach($invitados as $invitado)

                            <option value="{{ $invitado->id }}" 
                                data-nombre="{{ $invitado->nombre_completo }}"
                                data-cargo="{{ $invitado->cargo }}"
                                data-sexo="{{ $invitado->sexo }}"
                                data-municipio="{{ $invitado->municipio_id }}"
                                {{ old('invitado_id') == $invitado->id ? 'selected' : '' }}>
                                {{ $invitado->nombre_completo }} - {{ $invitado->cargo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nombre_completo" class="form-label">Nombre del Asistente <span
                                class="text-danger">*</span> </label>
                        <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo') }}" required
                            readonly>
                        <small id="ayuda_nombre" class="text-muted">Este campo se llena automáticamente al seleccionar
                            al titular.</small>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="cargo" class="form-label">Cargo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cargo" name="cargo" value="{{ old('cargo') }}" required readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="sexo" class="form-label">Sexo</label>
                        <select class="form-select" id="sexo" name="sexo" required readonly style="pointer-events: none; background-color: #e9ecef;">
                            <option value="">Seleccionar...</option>
                            <option value="Hombre" {{ old('sexo') == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                            <option value="Mujer" {{ old('sexo') == 'Mujer' ? 'selected' : '' }}>Mujer</option>

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="municipio_id" class="form-label">Municipio</label>
                        <select class="form-select" id="municipio_id" name="municipio_id" required readonly style="pointer-events: none; background-color: #e9ecef;">
                            <option value="">Seleccionar...</option>
                            @foreach ($municipios as $municipio)
                                <option value="{{ $municipio->id }}" {{ old('municipio_id') == $municipio->id ? 'selected' : '' }}>
                                    {{ $municipio->nombre_municipio }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="correo_electronico" class="form-label">Correo electrónico <span
                            class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('correo_electronico') is-invalid @enderror"
                        id="correo_electronico" name="correo_electronico" value="{{ old('correo_electronico') }}"
                        required placeholder="ejemplo@dominio.com" maxlength="50">
                    @error('correo_electronico')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telefono_oficina" class="form-label">Teléfono de oficina <span
                                class="text-danger">*</span></label>
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
                    <div class="col-12 text-muted">
                        <span class="text-danger">*</span> Indica campo obligatorio
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

 <script>
        document.addEventListener('DOMContentLoaded', function () {

            // --- ALERTA DE ÉXITO ---
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#0d6efd',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            // --- ALERTA DE ERRORES DE VALIDACIÓN ---
            @if ($errors->any())
                let errores = '';
                @foreach ($errors->all() as $error)
                    errores += '• {{ $error }}\n';
                @endforeach

                Swal.fire({
                    icon: 'error',
                    title: '¡Revisa los datos!',
                    text: errores,
                    confirmButtonColor: '#dc3545' 
                });
            @endif

            // 1. Inicializar Tom Select del Invitado
            let tomSelectInvitado = new TomSelect("#invitado_id", {
                create: false,
                sortField: { field: "text", direction: "asc" },
                maxOptions: null,
                maxItems: 1,
                plugins: ['remove_button'],
                placeholder: 'Busque nombre del funcionario...'
            });

            // 2. Elementos del DOM
            const boton = document.getElementById('botonRegistro');
            const mensajeEstado = document.getElementById('mensajeEstado');
            const formulario = document.getElementById('miFormulario');

            const radioTitular = document.getElementById('soy_titular');
            const radioRep = document.getElementById('soy_representante');
            const labelBuscador = document.getElementById('label_buscador');
            const ayudaNombre = document.getElementById('ayuda_nombre');

            const inputNombre = document.getElementById('nombre_completo');
            const inputCargo = document.getElementById('cargo');
            const selectSexo = document.getElementById('sexo');
            const selectMunicipio = document.getElementById('municipio_id');

            // 3. Lógica del candado de tiempo
            function actualizarEstadoBoton() {
                if (!mensajeEstado) return;

                const ahora = new Date();
                const inicioRegistro = new Date(2026, 2, 26, 8, 30, 0); // 26-Mar-2026 08:30:00
                const finRegistro = new Date(2026, 2, 31, 19, 0, 0);    // 31-Mar-2026 19:00:00

                if (ahora >= inicioRegistro && ahora <= finRegistro) {
                    boton.textContent = 'Registrarse';
                    boton.disabled = false;
                    boton.classList.remove('btn-secondary');
                    boton.classList.add('btn-primary');
                    mensajeEstado.textContent = '¡El registro está abierto!';
                    mensajeEstado.className = 'text-center mb-2 fw-bold text-success';
                } else {
                    boton.textContent = 'Registro Cerrado';
                    boton.disabled = true;
                    boton.classList.remove('btn-primary');
                    boton.classList.add('btn-secondary');
                    mensajeEstado.className = 'text-center mb-2 fw-bold text-danger';

                    if (ahora < inicioRegistro) {
                        mensajeEstado.textContent = 'El registro abrirá el 26 de marzo a las 8:30 AM.';
                    } else if (ahora > finRegistro) {
                        mensajeEstado.textContent = 'El periodo de registro ha finalizado.';
                    }
                }
            }

            // Evitamos que manden el form si el botón está deshabilitado por el candado de tiempo
            if (formulario) {
                formulario.addEventListener('submit', function (event) {
                    if (boton.disabled) {
                        event.preventDefault();
                    }
                    // Opcional: Aquí puedes poner el código para cambiar el texto del botón a "Enviando..."
                });
            }

            actualizarEstadoBoton();
            setInterval(actualizarEstadoBoton, 60000);

            // 4. Lógica de Titular vs Representante
            function cambiarModo(esEventoDelUsuario = true) {
                if (radioTitular.checked) {
                    labelBuscador.textContent = "Busque su nombre en la lista:";
                    ayudaNombre.textContent = "Este campo se llena automáticamente.";

                    inputNombre.readOnly = true;
                    inputCargo.readOnly = true;
                    selectSexo.style.pointerEvents = "none";
                    selectSexo.style.backgroundColor = "#e9ecef";
                    selectMunicipio.style.pointerEvents = "none";
                    selectMunicipio.style.backgroundColor = "#e9ecef";

                    llenarCamposDesdeSelect();
                } else {
                    labelBuscador.textContent = "¿A quién viene representando? Busque al titular:";
                    ayudaNombre.textContent = "Escriba SU propio nombre completo (el de usted).";

                    inputNombre.readOnly = false;
                    inputCargo.readOnly = false;
                    selectSexo.style.pointerEvents = "auto";
                    selectSexo.style.backgroundColor = "#fff";
                    selectMunicipio.style.pointerEvents = "auto";
                    selectMunicipio.style.backgroundColor = "#fff";

                    // SOLO limpiamos los campos si el usuario le dio clic manualmente.
                    if (esEventoDelUsuario) {
                        inputNombre.value = "";
                        inputCargo.value = "";
                        selectSexo.value = "";
                        selectMunicipio.value = "";
                    }
                }
            }

            function llenarCamposDesdeSelect() {
                if (!radioTitular.checked) return;

                let val = tomSelectInvitado.getValue();
                
                if (val) {
                    let selectNativo = document.getElementById('invitado_id');
                    let opcionNativa = selectNativo.querySelector(`option[value="${val}"]`);

                    if (opcionNativa) {
                        inputNombre.value = opcionNativa.dataset.nombre || "";
                        inputCargo.value = opcionNativa.dataset.cargo || "";
                        selectSexo.value = opcionNativa.dataset.sexo || "";
                        selectMunicipio.value = opcionNativa.dataset.municipio || "";
                    }
                } else {
                    inputNombre.value = "";
                    inputCargo.value = "";
                    selectSexo.value = "";
                    selectMunicipio.value = "";
                }
            }

            // Listeners: Les pasamos "true" para indicar que es un clic manual
            radioTitular.addEventListener('change', () => cambiarModo(true));
            radioRep.addEventListener('change', () => cambiarModo(true));
            
            tomSelectInvitado.on('change', function () {
                llenarCamposDesdeSelect();
            });

            // Ejecutar al inicio: Le pasamos "false" para que NO nos borre los errores ni los old() inputs
            cambiarModo(false);

        });
    </script>
</body>

</html>