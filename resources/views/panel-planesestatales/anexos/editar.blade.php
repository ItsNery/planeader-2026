<x-app-layout>
    @section('title', 'Editar Anexo de ' . $planEstatal->nombre)
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Anexo de ') . $planEstatal->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('panel-planesestatales-anexos.update', [$planEstatal->id, $anexo->id]) }}"
                    method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                            <input type="text" name="titulo" id="titulo"
                                value="{{ old('titulo', $anexo->titulo) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                            @error('titulo')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="orden" class="block text-sm font-medium text-gray-700">Orden</label>
                            <select name="orden" id="orden"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @foreach ($ordenesDisponibles as $o)
                                    <option value="{{ $o }}" {{ $anexo->orden == $o ? 'selected' : '' }}>
                                        {{ $o }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="es_enlace" class="block text-sm font-medium text-gray-700">Tipo de Anexo</label>
                            <div class="mt-2 flex items-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="es_enlace" value="0"
                                        class="form-radio h-4 w-4 text-indigo-600"
                                        {{ !$anexo->es_enlace ? 'checked' : '' }} onchange="toggleAnexoType(0)">
                                    <span class="ml-2">Archivo (PDF)</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="es_enlace" value="1"
                                        class="form-radio h-4 w-4 text-indigo-600"
                                        {{ $anexo->es_enlace ? 'checked' : '' }} onchange="toggleAnexoType(1)">
                                    <span class="ml-2">Enlace (URL)</span>
                                </label>
                            </div>
                        </div>

                        <div id="container-archivo" style="{{ $anexo->es_enlace ? 'display: none;' : '' }}">
                            <label for="ruta_documento_archivo"
                                class="block text-sm font-medium text-gray-700">Documento (PDF - Dejar en blanco para
                                mantener actual)</label>
                            <input type="file" name="ruta_documento_archivo" id="ruta_documento_archivo"
                                accept="application/pdf"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @if (!$anexo->es_enlace)
                                <p class="text-xs text-gray-500 mt-1">Actual: {{ $anexo->ruta_documento }}</p>
                            @endif
                            @error('ruta_documento_archivo')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div id="container-enlace" style="{{ !$anexo->es_enlace ? 'display: none;' : '' }}">
                            <label for="ruta_documento_enlace" class="block text-sm font-medium text-gray-700">Enlace
                                (URL)</label>
                            <input type="url" name="ruta_documento_enlace" id="ruta_documento_enlace"
                                value="{{ old('ruta_documento_enlace', $anexo->es_enlace ? $anexo->ruta_documento : '') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="https://ejemplo.com/documento.pdf">
                            @error('ruta_documento_enlace')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen (Portada -
                                Dejar en blanco para mantener actual)</label>
                            <input type="file" name="imagen" id="imagen" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="text-xs text-gray-500 mt-1">Actual: {{ $anexo->imagen }}</p>
                            @error('imagen')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="publicado" id="publicado" value="1"
                                {{ $anexo->publicado ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="publicado" class="ml-2 block text-sm text-gray-900">¿Publicado?</label>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('panel-planesestatales-anexos.index', $planEstatal->id) }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Actualizar Anexo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function toggleAnexoType(type) {
            const containerArchivo = document.getElementById('container-archivo');
            const containerEnlace = document.getElementById('container-enlace');
            const inputArchivo = document.getElementById('ruta_documento_archivo');
            const inputEnlace = document.getElementById('ruta_documento_enlace');

            if (type === 1) { // Enlace
                containerArchivo.style.display = 'none';
                containerEnlace.style.display = 'block';
                inputArchivo.required = false;
                // Enlace is not strictly required on edit if we want to allow keeping it empty? 
                // No, if they switch to link, they MUST provide one.
                inputEnlace.required = true;
            } else { // Archivo
                containerArchivo.style.display = 'block';
                containerEnlace.style.display = 'none';
                inputArchivo.required = false; // Not required on edit
                inputEnlace.required = false;
            }
        }

        // Initialize state based on value
        document.addEventListener('DOMContentLoaded', function() {
            const esEnlace = document.querySelector('input[name="es_enlace"]:checked').value;
            toggleAnexoType(parseInt(esEnlace));
        });
    </script>
</x-app-layout>
