@extends('publico.plantilla')
@php
$banners = App\Models\Banner::where('estado', 'Activo')->get();
@endphp
<div class="carrusel">
    <div class="container-fluid p-0">
        <div id="header-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" id="#carouselExampleAutoplaying">
                    <a href="#">
                        <img class="w-100" src="https://dummyimage.com/1300x320/fff/aaa" alt="Imagen de placeholder" title="Banner por defecto de la pagina" />
                    </a>
                </div>
                @foreach($banners as $banner)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <a href="{{ $banner->enlace }}">
                            <img class="w-100" src="/baners/{{ $banner->imagen }}" alt="{{ $banner->nombre }}" title="{{ $banner->nombre }}"/>
                        </a>
                    </div>
                @endforeach
            </div>
            <a title="Boton de previo" class="carousel-control-prev" href="#header-carousel" data-slide="prev" rel="noopener">
                <div class="btn btn-dark previo_next">
                    <span class="carousel-control-prev-icon mb-n2"></span>
                </div>
            </a>
            <a title="Siguiente slider" class="carousel-control-next" href="#header-carousel" data-slide="next" rel="noopener">
                <div class="btn btn-dark previo_next">
                    <span class="carousel-control-next-icon mb-n2"></span>
                </div>
            </a>
        </div>
    </div>
</div>
   
