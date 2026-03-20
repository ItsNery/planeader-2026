<x-app-layout>
    @section('title', 'Herramientas de Planeación: Editar')

    <div class="container bg-white py-12 mx-auto">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="form-container p-6 bg-white shadow-md rounded-lg">
                <form action="{{ route('panel-herramientas.update', $herramienta->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Título de la Herramienta:</label>
                        <input name="titulo" type="text"
                            class="form-control w-full @error('titulo') is-invalid @enderror"
                            value="{{ old('titulo', $herramienta->titulo) }}" required>
                        @error('titulo')
                            <small class="text-red-500">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Descripción:</label>
                        <textarea name="descripcion" class="form-control w-full">{{ old('descripcion', $herramienta->descripcion) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Documento Principal (PDF):</label>
                            <input name="archivo" type="file" accept=".pdf" class="form-control w-full">
                            <small class="text-gray-500">Actual: <a
                                    href="/documentos/herramientas/{{ $herramienta->archivo }}" target="_blank"
                                    class="underline">{{ $herramienta->archivo }}</a></small>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Portada (Imagen):</label>
                            <input name="imagen" type="file" accept="image/*" class="form-control w-full"
                                id="portadaInput">
                            <div class="mt-2">
                                @if ($herramienta->imagen)
                                    <img src="/imagen/herramientas/{{ $herramienta->imagen }}" id="portadaPreview"
                                        style="max-height: 150px;">
                                @else
                                    <img id="portadaPreview" style="max-height: 150px; display: none;">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Orden:</label>
                            <select name="orden" class="form-control w-full">
                                @foreach ($ordenesDisponibles as $o)
                                    <option value="{{ $o }}"
                                        {{ $herramienta->orden == $o ? 'selected' : '' }}>{{ $o }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center mt-4">
                            <input type="checkbox" name="publicado" id="publicado" value="1"
                                {{ $herramienta->publicado ? 'checked' : '' }} class="mr-2">
                            <label for="publicado" class="font-bold text-gray-700">Publicado</label>
                        </div>
                    </div>

                    <hr class="my-6">

                    <h3 class="text-lg font-bold mb-4 text-gray-800">Anexos Actuales</h3>
                    <div class="space-y-4 mb-6">
                        @foreach ($herramienta->anexos as $anexo)
                            <div class="flex items-center justify-between p-3 bg-gray-50 border rounded">
                                <div>
                                    <span class="font-bold">{{ $anexo->titulo }}</span>
                                    <br>
                                    <a href="/documentos/herramientas/anexos/{{ $anexo->archivo }}" target="_blank"
                                        class="text-sm text-blue-600 underline">{{ $anexo->archivo }}</a>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="confirmDeleteAnexo({{ $anexo->id }})">Eliminar</button>
                            </div>
                        @endforeach
                    </div>

                    <h3 class="text-lg font-bold mb-4 text-gray-800">Agregar Nuevos Anexos</h3>
                    <div id="anexos-container"></div>
                    <button type="button" id="add-anexo" class="btn btn-info mt-2">Agregar Anexo</button>

                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('panel-herramientas.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success" style="background-color: #28a745;">Actualizar
                            Herramienta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden form for deleting annexes -->
    <form id="delete-anexo-form" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function confirmDeleteAnexo(id) {
            Swal.fire({
                title: '¿Eliminar este anexo?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-anexo-form');
                    form.action = `/panel-herramientas-anexo/${id}`;
                    form.submit();
                }
            })
        }

        $(document).ready(function() {
            let anexoIndex = 0;
            $('#add-anexo').click(function() {
                const row = `
                    <div class="anexo-row p-3 mb-3 bg-gray-50 border rounded flex items-center space-x-3">
                        <div class="flex-1">
                            <input name="anexos[${anexoIndex}][titulo]" type="text" placeholder="Título del anexo" class="form-control w-full mb-2">
                            <input name="anexos[${anexoIndex}][archivo]" type="file" class="form-control w-full">
                        </div>
                        <button type="button" class="remove-anexo text-red-500 font-bold px-2">&times;</button>
                    </div>
                `;
                $('#anexos-container').append(row);
                anexoIndex++;
            });

            $(document).on('click', '.remove-anexo', function() {
                $(this).closest('.anexo-row').remove();
            });

            $('#portadaInput').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#portadaPreview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
</x-app-layout>
