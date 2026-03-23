<x-app-layout>
    @section('title', 'Programas Estatales: Subir')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subir Programas Estatales') }}
        </h2>
    </x-slot>
    <div class="container bg-white">
        <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Subir programa</h2>
            </div>
            <form action="{{ route('panel-programasEstatales.store') }}" method="POST" enctype="multipart/form-data"
                novalidate>
                @csrf
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="custom-section-title"><i class="fa-solid fa-file-signature"></i>
                            Nombre del documento: *
                        </div>
                        <input name="nombre" type="text" id="fname" placeholder="Programa de ..."
                            class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}"
                            @error('nombre') autofocus @enderror autofocus required>
                        @error('nombre')
                            <small class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-file-circle-plus"></i>
                        Cargue el documento: *
                    </div>
                    <div class="input-group">
                        <input accept=".pdf" type="file" id="ruta_documento" name="ruta_documento"
                            class="form-control @error('ruta_documento') is-invalid @enderror"
                            @error('ruta_documento') autofocus @enderror required>
                        <label class="input-group-text" for="ruta_documento">Seleccionar PDF</label>
                        @error('ruta_documento')
                            <small class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-image"></i>
                        Subir portada: *
                    </div>
                    <div class="input-group">
                        <input accept=".jpg,.png,.svg,.jpeg" name="portada" id="portada" type='file'
                            class="form-control @error('portada') is-invalid @enderror"
                            @error('portada') autofocus @enderror required />
                        <label class="input-group-text" for="ruta_documento">Seleccionar Imagen</label>
                        @error('portada')
                            <small class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center my-3">
                        <img id="imagenSeleccionada" style="max-height: 300px;">
                    </div>
                </div>
                <div class="col-12">
                    <div class="custom-section-title"><i class="fa-solid fa-book"></i>
                        Seleccione el Plan Estatal de Desarrollo: *
                    </div>
                    <select id="planestatal_id" name="planestatal_id"
                        class="form-control @error('municipio_id') is-invalid @enderror"
                        @error('planestatal_id') autofocus @enderror required>
                        <option value="" disabled selected>Seleccione</option>
                        @foreach ($planes_estatales as $planes)
                            <option value="{{ $planes->id }}">{{ $planes->nombre }}</option>
                        @endforeach
                    </select>
                    @error('planestatal_id')
                        <small class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>

                @if (auth()->user()->validador == 1)
                    <div class="col-12 mb-3">
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
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('panel-programasEstatales.index') }}"
                                class="btn btn-secondary w-100 my-1">
                                Cancelar
                            </a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success w-100 my-1"
                                onclick="return VerifyUploadSizeIsOK()">Subir</button>
                        </div>
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
        var MaxSizeInBytes = 400000000;
        var fld = document.getElementById(UploadFieldID);
        if (fld.files && fld.files.length == 1 && fld.files[0].size > MaxSizeInBytes) {
            alert("El archivo no deber ser mayor a " + parseInt(MaxSizeInBytes / 1024 / 1024) + "MB");
            return false;
        }
        return true;
    } // function VerifyUploadSizeIsOK()
</script>
