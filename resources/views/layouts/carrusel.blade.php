@php
    $banners = App\Models\Banner::where('estado', 'Activo')->get();
@endphp
<div class="carrusel">
    <div class="container-fluid p-0">
        <div id="header-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <!-- Verificar si hay banners dinámicos -->
                @if ($banners && count($banners) > 0)
                    <!-- Banners dinámicos -->
                    @foreach ($banners as $banner)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <a href="{{ $banner->enlace }}" target="_blank">
                                <img class="w-100" src="/baners/{{ $banner->imagen }}" alt="{{ $banner->nombre }}" />
                            </a>
                        </div>
                    @endforeach
                @else
                    <!-- Banner estático si no hay banners dinámicos -->
                    <div class="carousel-item active">
                        <a href="#">
                            <img class="w-100" src="/baners/20240411231551.png" alt="Image" />
                        </a>
                    </div>
                @endif
            </div>
            <a title="Boton de previo" class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                <div class="btn btn-dark previo_next">
                    <span class="carousel-control-prev-icon mb-n2"></span>
                </div>
            </a>
            <a title="Siguiente slider" class="carousel-control-next" href="#header-carousel" data-slide="next">
                <div class="btn btn-dark previo_next">
                    <span class="carousel-control-next-icon mb-n2"></span>
                </div>
            </a>
        </div>
    </div>
</div>

