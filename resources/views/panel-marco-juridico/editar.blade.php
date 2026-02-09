<x-app-layout>
    @section('title', 'Marco Jurídico: Editar')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar documentos del Marco Jurídico') }}
        </h2>
    </x-slot>
    <div class="container bg-white">
        <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Editar documento</h2>
            </div>
            <form id="form-update-comite" action="{{ route('panel-marco-juridico.update', $documentosMarcoJuridico->id) }}"
                method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-file-signature"></i>
                        Nombre del documento: *
                    </div>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                        id="nombre" placeholder="Ingresa el nombre del material o plataforma de consulta"
                        value="{{ old('nombre', $documentosMarcoJuridico->nombre) }}"
                        @error('nombre') autofocus @enderror required>
                    @error('nombre')
                        <small class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-file"></i> Documento
                        actual:
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="ruta_documento" name="ruta_documento"
                                value="{{ $documentosMarcoJuridico->ruta_documento }}" disabled>
                        </div>
                        <div class="col-md-4">
                            <a target="_blank" class="btn btn-info w-100" title="{{ $documentosMarcoJuridico->nombre }}"
                                href="/marco-juridico/{{ $documentosMarcoJuridico->ruta_documento }}">Ver</a>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-file"></i> Cargue el nuevo
                        documento:
                    </div>
                    <input type="file" class="form-control @error('ruta_documento') is-invalid @enderror"
                        id="file" name="ruta_documento" accept=".pdf">
                    @error('ruta_documento')
                        <small class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="custom-section-title"><i class="fa-solid fa-image"></i>
                                Actual portada:
                            </div>
                            <div class="d-flex justify-content-center">
                                <img src="/portadas-marcojuridico/{{ $documentosMarcoJuridico->portada }}"
                                    width="200px" id="imagenSeleccionada" class="img-thumbnail">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-section-title"><i class="fa-solid fa-image"></i>
                                Subir portada nueva:
                            </div>
                            <div class="input-group d-flex justify-content-center align-items-center">
                                <input accept=".jpg,.png,.svg,.jpeg" type="file" class="form-control" id="portada"
                                    name="portada">
                                @error('portada')
                                    <small class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-sort"></i>
                        Orden: *
                    </div>
                    <select class="form-control @error('orden') is-invalid @enderror" id="orden" name="orden"
                        required>
                        <option value="" disabled>Seleccione</option>
                        @foreach ($ordenesDisponibles as $orden)
                            <option value="{{ $orden }}"
                                {{ $orden == $documentosMarcoJuridico->orden ? 'selected' : '' }}
                                {{ in_array($orden, $ordenesExistentes) && $orden != $documentosMarcoJuridico->orden ? 'disabled' : '' }}>
                                {{ $orden }}
                            </option>
                        @endforeach
                    </select>
                    @error('orden')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    @if (Auth::user()->validador)
                        <div class="col-md-12">
                            <div class="custom-section-title"><i class="fa-solid fa-circle-check"></i>
                                ¿El documento puede ser
                                publicado?
                            </div>
                            <select class="form-control @error('publicado') is-invalid @enderror" id="publicado"
                                name="publicado" required>
                                <option value="0"
                                    {{ $documentosMarcoJuridico->publicado == 0 ? 'selected' : '' }}>No
                                </option>
                                <option value="1"
                                    {{ $documentosMarcoJuridico->publicado == 1 ? 'selected' : '' }}>Sí
                                </option>
                            </select>
                            @error('publicado')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <div class="col-md-12 d-flex justify-content-evenly">
                        <a href="{{ route('panel-marco-juridico.index') }}" class="btn btn-secondary w-100">Cancelar</a>
                        <button type="submit" class="btn btn-primary w-100">Subir</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="max-w-lg lg:ms-auto mx-auto text-center ">
                    <div class="py-16 px-7 rounded-md bg-white">
                        <form id="form-update-comite"
                            action="{{ route('panel-marco-juridico.update', $documentosMarcoJuridico->id) }}"
                            method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            @method('PATCH')
                            <div class="row g-3">




                            </div>
                        </form>

                    </div>
                </div>
            </div>
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
