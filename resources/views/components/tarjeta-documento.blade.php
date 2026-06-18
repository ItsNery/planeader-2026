@props([
    'titulo', 
    'imagen' => null, 
    'archivo', 
    'rutaBase' => 'documentos/herramientas',
    'rutaImagenBase' => 'imagen/herramientas',
    'esDescarga' => false,
    'icono' => 'fa-file-pdf pdf',
    'textoBoton' => 'Ver documento'
])

<div class="contenedor-tarjetadocs mb-3">
    @if ($imagen)
        <img src="{{ asset($rutaImagenBase . '/' . $imagen) }}"
            alt="Portada de {{ $titulo }}" class="width-100 mb-3"
            title="{{ $titulo }}" style="object-fit: cover; border-radius: 8px;">
    @else
        <div class="text-center p-4 mb-3 d-flex flex-column align-items-center justify-content-center bg-light" style="min-height: 200px; border-radius: 10px;">
            <i class="fas fa-file-alt fa-3x text-secondary mb-3"></i>
            <h6 class="mb-0 text-secondary font-weight-bold">{{ $titulo }}</h6>
        </div>
    @endif
    <div class="text-center mt-3">
        @if($esDescarga)
            <a class="boton-descargar-compacta btn btn-block text-center w-100" 
                href="{{ asset($rutaBase . '/' . $archivo) }}"
                download="{{ $titulo }}" rel="noopener" title="{{ $titulo }}"
                style="border-radius: 8px;">
                {{ $textoBoton }} <i class="fas {{ $icono }}"></i>
            </a>
        @else
            <a class="boton-descargar-compacta btn btn-block text-center w-100" href="javascript:void(0);"
                onclick="openModal('{{ asset($rutaBase . '/' . $archivo) }}', '{{ $titulo }}')"
                title="{{ $titulo }}"
                style="border-radius: 8px;">
                <i class="fas {{ $icono }}"></i> {{ $textoBoton }}
            </a>
        @endif
    </div>
</div>
