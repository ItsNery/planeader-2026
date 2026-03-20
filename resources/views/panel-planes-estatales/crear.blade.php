<x-app-layout>
    @section('title', 'Planes Estatales de Desarrollo: Subir')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subir Planes Estatales') }}
        </h2>
    </x-slot>
    <div class="container bg-white">
        <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Subir plan</h2>
            </div>
            <div class="alert alert-info" role="alert">
                <i class="fa-solid fa-circle-info"></i>
                <strong>Nota:</strong> Los anexos para este plan se podrán gestionar una vez que el documento principal
                haya sido guardado exitosamente.
            </div>
            <form action="{{ route('panel-planes-estatales.store') }}" method="POST" enctype="multipart/form-data"
                novalidate>
                @csrf

                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="custom-section-title"><i class="fa-solid fa-file-signature"></i>
                                Nombre del plan: *
                            </div>
                            <input name="nombre" type="text" id="fname" placeholder="Nombre del Archivo"
                                class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}"
                                @error('nombre') autofocus @enderror autofocus required>
                            @error('nombre')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <div class="custom-section-title"><i class="fa-solid fa-calendar-week"></i>
                                Periodo: *
                            </div>
                            <input type="text" id="periodo" name="periodo" placeholder="YYYY-YYYY o YYYY"
                                pattern="\d{4}(-\d{4})?" title="Formato válido: YYYY o YYYY-YYYY"
                                class="form-control @error('periodo') is-invalid @enderror" value="{{ old('periodo') }}"
                                @error('periodo') autofocus @enderror autofocus required>
                            @error('periodo')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-person-chalkboard"></i>
                        Nombre del gobernador: *
                    </div>
                    <input name="gobernador" type="text" id="fname" placeholder="Jane Doe"
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-700 form-control @error('nombre') is-invalid @enderror"
                        value="{{ old('gobernador') }}" @error('gobernador') autofocus @enderror autofocus required>
                    @error('gobernador')
                        <small class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-file-pdf"></i>
                        Cargue el archivo: *
                    </div>
                    <div class="input-group">
                        <input accept=".pdf" type="file" id="ruta_documento" name="ruta_documento"
                            class="form-control @error('ruta_documento') is-invalid @enderror"
                            @error('ruta_documento') autofocus @enderror required>
                        <label class="input-group-text" for="ruta_documento">Seleccionar PDF</label>
                        @error('ruta_documento')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-book"></i>
                        Cargue la portada: *
                    </div>
                    <div class="input-group">
                        <input accept=".jpg,.png,.svg,.jpeg" name="portada" id="portada" type='file'
                            class="form-control @error('portada') is-invalid @enderror"
                            @error('portada') autofocus @enderror required />
                        <label class="input-group-text" for="ruta_documento">Seleccionar imagen</label>
                        @error('portada')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <img id="imagenSeleccionada" style="max-height: 300px;">
                    </div>
                </div>
                @if (auth()->user()->validador == 1)
                    <div class="mb-3">
                        <div class="custom-section-title"><i class="fa-solid fa-check-circle"></i>
                            ¿Publicado? *
                        </div>
                        <select class="form-control @error('publicado') is-invalid @enderror" id="publicado"
                            name="publicado" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        @error('publicado')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @endif
                <div class="mb-3">
                    <div class="col-md-12 d-flex justify-content-evenly">
                        <a href="{{ route('panel-planes-estatales.index') }}" class="btn btn-secondary w-100">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-success w-100"
                            onclick="return VerifyUploadSizeIsOK()">Subir</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function(e) {
        $('#portada').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagenSeleccionada').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>
<script type="text/javascript">
    function VerifyUploadSizeIsOK() {
        var UploadFieldID = "ruta_documento";
        var MaxSizeInBytes = 500000000;
        var fld = document.getElementById(UploadFieldID);
        if (fld.files && fld.files.length == 1 && fld.files[0].size > MaxSizeInBytes) {
            alert("El archivo no deber ser mayor a " + parseInt(MaxSizeInBytes / 1024 / 1024) + "MB");
            return false;
        }
        return true;
    } // function VerifyUploadSizeIsOK()
</script>
