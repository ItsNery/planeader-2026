<x-app-layout>
    @section('title', 'Importar invitados COPLADEP')

    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3 px-3">
            <h2>Importar invitados</h2>
            <p class="text-white mb-0">{{ $sesion->nombre }}</p>
        </div>
        <div class="importar-invitados">
            <a class="importar-invitados__back" href="{{ route('panel-copladep-sesiones.invitados.index', $sesion) }}">Volver al listado de invitados</a>
            <p class="importar-invitados__intro">Descarga la plantilla, llena una fila por invitado y carga el archivo terminado.</p>
            <div class="importar-invitados__layout">
                <section class="importar-invitados__template" aria-labelledby="plantilla-titulo">
                    <h3 class="importar-invitados__heading" id="plantilla-titulo">Prepara tu archivo</h3>
                    <p>La plantilla incluye instrucciones y los catálogos actuales de dependencias y municipios.</p>
                    <a class="btn btn-outline-secondary importar-invitados__download" href="{{ route('panel-copladep-sesiones.invitados.plantilla', $sesion) }}">Descargar plantilla Excel</a>
                    <div class="importar-invitados__guidance">
                        <h4 class="importar-invitados__subheading">Antes de importar</h4>
                        <ul class="importar-invitados__list">
                            <li>Incluye hasta 1,000 invitados por archivo.</li>
                            <li>Conserva los encabezados de la plantilla.</li>
                            <li>Si hay errores o duplicados, no se guardará ninguna fila.</li>
                        </ul>
                    </div>
                </section>
                <section class="importar-invitados__upload" aria-labelledby="archivo-titulo">
                    <h3 class="importar-invitados__heading" id="archivo-titulo">Carga el archivo</h3>
                    <p>Selecciona la plantilla cuando hayas terminado de llenarla.</p>
            @if ($errors->any())
                <div class="alert alert-danger importar-invitados__errors" role="alert" id="errores-importacion" tabindex="-1">
                    <p class="fw-bold mb-2">No se importaron invitados. Corrige lo siguiente:</p>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('panel-copladep-sesiones.invitados.importar', $sesion) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold" for="archivo">Archivo de invitados</label>
                    <input class="form-control importar-invitados__file @error('archivo') is-invalid @enderror" type="file" id="archivo" name="archivo" accept=".xlsx" required aria-describedby="archivo-ayuda @if ($errors->any()) errores-importacion @endif" @error('archivo') aria-invalid="true" @enderror>
                    <div id="archivo-ayuda" class="form-text">Formato XLSX · máximo 5 MB</div>
                </div>
                <button class="btn btn-custom-primary importar-invitados__submit" type="submit">Importar invitados</button>
            </form>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
