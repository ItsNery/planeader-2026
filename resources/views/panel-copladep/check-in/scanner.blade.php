<x-app-layout>
    @section('title', 'Check-in QR COPLADEP')
    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3 px-3"><h2>Check-in con QR</h2><p class="text-white mb-0">Escanea el código de acceso de {{ $sesion->nombre }}.</p></div>
        <div class="checkin-scanner">
            @can('ver-listado-registro-copladep')
                <a href="{{ route('panel-copladep-sesiones.show', $sesion) }}" class="btn btn-outline-secondary mb-4">Volver a la sesión</a>
            @endcan
            <div class="checkin-scanner__layout">
                <section class="checkin-scanner__camera" aria-labelledby="scanner-heading">
                    <h3 id="scanner-heading" class="checkin-scanner__heading">Escanear código QR</h3>
                    <p class="checkin-scanner__description">Activa la cámara y coloca el código dentro del encuadre. También puedes seleccionar una imagen del código.</p>
                    <div class="checkin-scanner__viewer">
                        <div id="reader" class="checkin-scanner__reader"></div>
                        <p id="camera-placeholder" class="checkin-scanner__placeholder">La vista de la cámara aparecerá aquí.</p>
                    </div>
                    <p id="camera-status" class="checkin-scanner__status" role="status" aria-live="polite">Cámara desactivada.</p>
                    <div class="checkin-scanner__actions">
                        <button type="button" id="camera-start" class="btn btn-custom-primary">Activar cámara</button>
                        <button type="button" id="camera-stop" class="btn btn-outline-secondary" hidden>Detener cámara</button>
                        <input type="file" id="qr-image" class="checkin-scanner__file" accept="image/*">
                        <label for="qr-image" class="btn btn-outline-secondary checkin-scanner__file-label">Seleccionar imagen</label>
                    </div>
                </section>
                <section class="checkin-scanner__manual" aria-labelledby="manual-heading">
                    <h3 id="manual-heading" class="checkin-scanner__heading">Registro manual</h3>
                    <p class="checkin-scanner__description">Si no puedes escanear el QR, escribe o pega el código de acceso.</p>
                    <form id="manual">
                        <label class="form-label" for="token">Código de acceso</label>
                        <input id="token" class="form-control" autocomplete="off" required>
                        <button id="manual-submit" class="btn btn-custom-primary checkin-scanner__submit" type="submit">Registrar asistencia</button>
                    </form>
                    <div id="resultado" class="alert d-none checkin-scanner__result" role="status" aria-live="polite"></div>
                </section>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://unpkg.com/html5-qrcode" defer></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const output = document.getElementById('resultado');
                const cameraStatus = document.getElementById('camera-status');
                const placeholder = document.getElementById('camera-placeholder');
                const startButton = document.getElementById('camera-start');
                const stopButton = document.getElementById('camera-stop');
                const imageInput = document.getElementById('qr-image');
                const submitButton = document.getElementById('manual-submit');
                let scanner;
                let cameraActive = false;
                let busy = false;
                let lastToken = '';
                let lastScan = 0;

                function showResult(message, type) {
                    output.className = 'alert checkin-scanner__result alert-' + type;
                    output.textContent = message;
                }

                async function notifyResult(message, success) {
                    if (window.Swal) {
                        await Swal.fire({
                            icon: success ? 'success' : 'warning',
                            title: success ? 'Asistencia registrada' : 'Atención',
                            text: message,
                            confirmButtonText: 'Continuar',
                            confirmButtonColor: 'var(--color6)',
                            allowOutsideClick: false
                        });
                    } else {
                        window.alert(message);
                    }
                }

                async function send(token, fromCamera = false) {
                    token = token.trim();
                    if (!token || busy || (fromCamera && token === lastToken && Date.now() - lastScan < 5000)) return;
                    busy = true;
                    lastToken = token;
                    lastScan = Date.now();
                    submitButton.disabled = true;
                    showResult('Registrando asistencia…', 'secondary');
                    try {
                        const response = await fetch('{{ route('panel-copladep-sesiones.checkin', $sesion) }}', {
                            method: 'POST',
                            headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                            body: JSON.stringify({token})
                        });
                        const data = await response.json();
                        const message = data.message || 'No se pudo registrar la asistencia. Inténtalo de nuevo.';
                        showResult(message, response.ok ? 'success' : 'danger');
                        if (response.ok && !fromCamera) document.getElementById('token').value = '';
                        await notifyResult(message, response.ok);
                    } catch (error) {
                        const message = 'No fue posible conectar con el servidor. Comprueba tu conexión e inténtalo de nuevo.';
                        showResult(message, 'danger');
                        await notifyResult(message, false);
                    } finally {
                        lastScan = Date.now();
                        busy = false;
                        submitButton.disabled = false;
                    }
                }

                document.getElementById('manual').addEventListener('submit', event => {
                    event.preventDefault();
                    send(document.getElementById('token').value);
                });

                window.addEventListener('load', () => {
                    if (!window.Html5Qrcode) {
                        cameraStatus.textContent = 'No se pudo cargar el lector. Usa el código manual o recarga la página.';
                        startButton.disabled = true;
                        imageInput.disabled = true;
                        return;
                    }
                    scanner = new Html5Qrcode('reader');
                    startButton.addEventListener('click', async () => {
                        startButton.disabled = true;
                        cameraStatus.textContent = 'Solicitando acceso a la cámara…';
                        try {
                            await scanner.start({ facingMode: 'environment' }, { fps: 10, qrbox: { width: 220, height: 220 } }, token => send(token, true), () => {});
                            cameraActive = true;
                            placeholder.hidden = true;
                            startButton.hidden = true;
                            stopButton.hidden = false;
                            cameraStatus.textContent = 'Cámara activa. Acerca el código al encuadre.';
                        } catch (error) {
                            cameraStatus.textContent = 'No se pudo iniciar la cámara. Comprueba que esté conectada y que el navegador tenga permiso, o utiliza el código manual.';
                        } finally {
                            startButton.disabled = false;
                        }
                    });
                    stopButton.addEventListener('click', async () => {
                        stopButton.disabled = true;
                        try {
                            await scanner.stop();
                            cameraActive = false;
                            scanner.clear();
                            placeholder.hidden = false;
                            startButton.hidden = false;
                            stopButton.hidden = true;
                            cameraStatus.textContent = 'Cámara desactivada.';
                        } catch (error) {
                            cameraStatus.textContent = 'No se pudo detener la cámara. Recarga la página para intentarlo de nuevo.';
                        } finally {
                            stopButton.disabled = false;
                        }
                    });
                    imageInput.addEventListener('change', async () => {
                        const file = imageInput.files[0];
                        if (!file) return;
                        if (cameraActive) {
                            cameraStatus.textContent = 'Detén la cámara antes de seleccionar una imagen.';
                            imageInput.value = '';
                            return;
                        }
                        cameraStatus.textContent = 'Buscando el código en la imagen…';
                        try {
                            const token = await scanner.scanFile(file, false);
                            scanner.clear();
                            cameraStatus.textContent = 'Código encontrado en la imagen.';
                            await send(token);
                        } catch (error) {
                            cameraStatus.textContent = 'No se encontró un código QR en la imagen. Prueba con otra imagen o usa el código manual.';
                        } finally {
                            imageInput.value = '';
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
