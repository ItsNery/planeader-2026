@extends('layouts.plantilla')
@section('title', 'Plan Estatal de Desarrollo 2024-2030')
@section('meta-description',
    'Visión general del Plan Estatal de Desarrollo 2024-2030 del Gobierno
    del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'Plan Estatal de Desarrollo - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Bienvenido a la página de visión general del Plan Estatal de
    Desarrollo del Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('og:image', 'https://planeader.puebla.gob.mx/img/ped2/PED23.png')
@section('og:url', url()->current())
@section('twitter-title', 'Plan Estatal de Desarrollo - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
    'Bienvenido a la página de visión general del Plan
    Estatal de Desarrollo del Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('jss')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('myModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalIframe = document.getElementById('modalIframe');
            const openModalLinks = document.querySelectorAll('.tarjetahistoricoplanes-link, .abrir-en-modal');
            const closeModalButton = document.querySelector('#myModal .close-btn');

            // --- Lógica para ABRIR el modal ---
            openModalLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const docUrl = this.dataset.src;
                    const docTitle = this.dataset.title;

                    modalTitle.textContent = docTitle;
                    modalIframe.src = docUrl;
                    const copyButton = document.getElementById('botoncopiar');
                    if (copyButton) {
                        copyButton.dataset.url = docUrl;
                    }
                    modal.style.display = 'block';
                });
            });

            // --- Función para CERRAR el modal ---
            function closeModal() {
                modal.style.display = 'none';
                modalIframe.src = ''; // Buena práctica para detener contenido
            }

            // --- Lógica para CERRAR el modal ---

            // 1. Clic en el botón (X)
            if (closeModalButton) {
                closeModalButton.addEventListener('click', closeModal);
            }

            // 2. Clic en el fondo (overlay)
            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    closeModal();
                }
            });

            // 3. Presionar la tecla "Escape"
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && modal.style.display === 'block') {
                    closeModal();
                }
            });

            // --- Lógica para COPIAR al portapapeles ---
            const copyButton = document.getElementById('botoncopiar');
            if (copyButton) {
                copyButton.addEventListener('click', function() {
                    const url = this.dataset.url;
                    if (url) {
                        navigator.clipboard.writeText(url).then(() => {
                            const icon = this.querySelector('.boton-copiar__icono');
                            if (icon) {
                                icon.classList.remove('fa-copy');
                                icon.classList.add('fa-check');
                                setTimeout(() => {
                                    icon.classList.remove('fa-check');
                                    icon.classList.add('fa-copy');
                                }, 2000);
                            }
                        }).catch(err => {
                            console.error('Error al copiar: ', err);
                        });
                    }
                });
            }
        });
    </script>
@endsection
@section('css')
@endsection
@section('content')
    <section class="inicio-ped">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="titulo">
                        ¿Qué es el Plan Estatal de Desarrollo?
                    </div>
                    <div class="texto-container">
                        <p class="texto">
                            El Plan Estatal de Desarrollo es el documento rector en materia de planeación y para su
                            elaboración
                            se estableció un esquema de trabajo articulado, cuya finalidad fue integrar una ruta a seguir de
                            carácter estratégico, que permitió marcar las directrices de actuación y, al mismo tiempo,
                            sentar
                            las bases para la elaboración de los programas que se van a derivar del mismo.
                        </p>
                        <p class="texto">
                            El Plan Estatal de Desarrollo, incorpora indicadores estratégicos, mediante los cuales se le da
                            seguimiento y permite evaluar el avance de los objetivos, estrategias y líneas de acción, estos
                            indicadores fueron seleccionados bajo el criterio de ser monitoreables, adecuados y oficiales a
                            fin
                            de propiciar la transparencia y asegurar darles continuidad en los instrumentos de planeación
                            derivados del Plan Estatal de Desarrollo. En este sentido, y con el fin de contribuir a un
                            desarrollo equitativo en todo el estado, se buscaron indicadores que brindaran elementos
                            suficientes
                            que permitan dar seguimiento e implementar estrategias enfocadas a las particularidades de cada
                            municipio y generar esquemas de regionalización.
                        </p>
                        <p class="texto">
                            Además, se incorporan indicadores que permitan dar seguimiento a la Igualdad de Género y la
                            atención
                            a los Pueblos Indígenas, con el propósito de hacer visible la situación en la que se encuentra
                            el
                            estado y así poder transversalizar estos enfoques en todo el actuar gubernamental.
                        </p>
                    </div>
                    <div class="contenedor-boton">
                        <a href="#" data-src="{{ asset('planesest/' . $plan_reciente->ruta_documento) }}"
                            data-title="{{ $plan_reciente->nombre }}" class="btn-descargar abrir-en-modal"
                            title="{{ $plan_reciente->nombre }}">
                            <span class="btn-descargar__texto">Consultar<br>documento</span>

                            <span class="btn-descargar__icono">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12 15.586l-4.293-4.293a1 1 0 0 1 1.414-1.414L11 11.586V4a1 1 0 0 1 2 0v7.586l1.879-1.879a1 1 0 0 1 1.414 1.414L12 15.586z" />
                                    <path
                                        d="M18 21H6a3 3 0 0 1-3-3V11a1 1 0 0 1 2 0v7a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-7a1 1 0 0 1 2 0v7a3 3 0 0 1-3 3z" />
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="panel-derecho">
                        <div class="contenedor-logo-ped">
                            <img src="{{ asset('img/logo-ped.png') }}" alt="Imagotipo del Plan Estatal de Desarrollo"
                                title="Imagotipo del PED" class="imagen1">
                        </div>
                        <div class="contenedor-libro-ped">
                            <img src="{{ asset('img/libro-ped.png') }}"
                                alt="Imagen de un libro abierto con algunas páginas sin cerrar" title="Libro PED"
                                class="w-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ejes-ped">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="lado-izquierdo">
                        <div class="contenedor">
                            <img src="{{ asset('img/logo-ped.png') }}" alt="Imagotipo del Plan Estatal de Desarrollo"
                                class="w-100" title="Imagotipo del PED">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="lado-derecho">
                        <div class="eje-item">
                            <img src="{{ asset('img/ped/ejes/1_bw.png') }}" alt="Icono en blanco y negro del Eje 1 del PED"
                                title="Icono b/n del Eje 1 del PED" class="imagen-bw">
                            <a href="#eje1">
                                <img src="{{ asset('img/ped/ejes/1.png') }}" alt="Descripción del Eje 1 del PED"
                                    title="Descripción del Eje 1 del PED" class="imagen-descripcion">
                            </a>
                        </div>
                        <div class="eje-item">
                            <img src="{{ asset('img/ped/ejes/2_bw.png') }}" alt="Icono en blanco y negro del Eje 2 del PED"
                                title="Icono b/n del Eje 2 del PED" class="imagen-bw">
                            <a href="#eje2">
                                <img src="{{ asset('img/ped/ejes/2.png') }}" alt="Descripción del Eje 2 del PED"
                                    title="Descripción del Eje 2 del PED" class="imagen-descripcion">
                            </a>
                        </div>
                        <div class="eje-item">
                            <img src="{{ asset('img/ped/ejes/3_bw.png') }}" alt="Icono en blanco y negro del Eje 3 del PED"
                                title="Icono b/n del Eje 3 del PED" class="imagen-bw">
                            <a href="#eje3">
                                <img src="{{ asset('img/ped/ejes/3.png') }}" alt="Descripción del Eje 3 del PED"
                                    title="Descripción del Eje 3 del PED" class="imagen-descripcion">
                            </a>
                        </div>
                        <div class="eje-item">
                            <img src="{{ asset('img/ped/ejes/4_bw.png') }}" alt="Icono en blanco y negro del Eje 4 del PED"
                                title="Icono b/n del Eje 4 del PED" class="imagen-bw">
                            <a href="#eje4">
                                <img src="{{ asset('img/ped/ejes/4.png') }}" alt="Descripción del Eje 4 del PED"
                                    title="Descripción del Eje 4 del PED" class="imagen-descripcion">
                            </a>
                        </div>
                        <div class="eje-item">
                            <img src="{{ asset('img/ped/ejes/5_bw.png') }}" alt="Icono en blanco y negro del Eje 5 del PED"
                                title="Icono b/n del Eje 5 del PED" class="imagen-bw">
                            <a href="#eje5">
                                <img src="{{ asset('img/ped/ejes/5.png') }}" alt="Descripción del Eje 5 del PED"
                                    title="Descripción del Eje 5 del PED" class="imagen-descripcion">
                            </a>
                        </div>
                        <div class="eje-item">
                            <img src="{{ asset('img/ped/ejes/5_bw.png') }}" alt="Icono en blanco y negro del Eje 6 del PED"
                                title="Icono b/n del Eje 6 del PED" class="imagen-bw">
                            <a href="#eje6">
                                <img src="{{ asset('img/ped/ejes/6.png') }}" alt="Descripción del Eje 6 del PED"
                                    title="Descripción del Eje 6 del PED" class="imagen-descripcion">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="eje1-ped" id="eje1">
        <div class="container">
            <a href="#" class="abrir-en-modal" data-src="https://ped2024-2030.puebla.gob.mx/documentos/1_Eje.pdf"
                data-title="Eje 1 del PED" rel="noopener noreferrer" title="Eje 1 del PED">
                <div class="row">
                    <div class="col-12 col-md-6 flex-container-centro px-3">
                        <img src="{{ asset('img/ped/ejes/eje1-wide.png') }}"
                            alt="Imagotipo en color verde del Eje 1 con nombre Humanismo con Bienestar"
                            class="sm-w-100 w-100" title="Eje 1: Humanismo con Bienestar">
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="titulo-tematica">
                            Temáticas
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/bienestar.png') }}"
                                    alt="Imagotipo en verde con texto Bienestar y la silueta de una persona con los brazos abiertos"
                                    title="Temática: Bienestar" class="sm-w-100 radio-16-fit">
                            </div>
                            <div class="col-12 col-md-6 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/salud.png') }}"
                                    alt="Imagotipo en verde con texto Salud y una figura de corazón con líneas"
                                    class="sm-w-100 radio-16-fit" title="Temática: Salud">
                            </div>
                            <div class="col-12 col-md-6 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/educacion.png') }}"
                                    alt="Imagotipo en verde con texto Educación con un la figura de un birrete"
                                    class="sm-w-100 radio-16-fit" title="Temática: Educación">
                            </div>
                            <div class="col-12 col-md-6 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/arte-y-cultura.png') }}"
                                    alt="Imagotipo en verde con texto Arte y Cultura con figuras de máscaras teatrales, un arpa y una pluma"
                                    class="sm-w-100 radio-16-fit" title="Temática: Arte y Cultura">
                            </div>
                            <div class="col-12 col-md-6 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/deporte-y-juventud.png') }}"
                                    alt="Imagotipo en verde con texto Deporte y Juventud con figura de una persona en posición de iniciar una carrera"
                                    class="sm-w-100 radio-16-fit" title="Temática: Deporte y Juventud">
                            </div>
                            <div class="col-12 col-md-6 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/grupos-vulnerables.png') }}"
                                    alt="Imagotipo en verde con texto Grupos Vulnerables con figura de dos manos conteniendo una persona"
                                    class="sm-w-100 radio-16-fit" title="Temática: Grupos Vulnerables">
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        </div>
    </section>
    <section class="eje2-ped" id="eje2">
        <div class="container">
            <a href="#" class="abrir-en-modal" data-src="https://ped2024-2030.puebla.gob.mx/documentos/2_Eje.pdf"
                data-title="Eje 2 del PED" rel="noopener noreferrer" title="Eje 2 del PED">
                <div class="row">
                    <div class="col-12 col-md-6 flex-container-centro">
                        <img src="{{ asset('img/ped/ejes/eje2-wide.png') }}"
                            alt="Imagotipo en color dorado del Eje 2 con nombre Prosperidad y Estabilidad Económica"
                            class="sm-w-100 w-100" title="Eje 2: Prosperidad y Estabilidad Económica">
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="titulo-tematica">
                            Temáticas
                        </div>
                        <div class="row">
                            <div class="col-12 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/agropecuario-y-rural.png') }}"
                                    class="sm-w-100 radio-16-fit"
                                    alt="Imagotipo en dorado con texto Agropecuario y Rural con figura de dos manos conteniendo una planta"
                                    title="Temática: Agropecuario y Rural">
                            </div>
                            <div class="col-12 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/economia.png') }}" class="sm-w-100 radio-16-fit"
                                    alt="Imagotipo en dorado con texto Economía con figura de una bolsa de dinero"
                                    title="Temática: Economía">
                            </div>
                            <div class="col-12 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/turismo.png') }}" class="sm-w-100 radio-16-fit"
                                    alt="Imagotipo en dorado con texto Turismo con figura de una persona haciendo senderismo"
                                    title="Temática: Turismo">
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        </div>
    </section>
    <section class="eje3-ped" id="eje3">
        <div class="container">
            <a href="#" class="abrir-en-modal" data-src="https://ped2024-2030.puebla.gob.mx/documentos/3_Eje.pdf"
                data-title="Eje 3 del PED" rel="noopener noreferrer" title="Eje 3 del PED">
                <div class="row">
                    <div class="col-12 col-md-6 flex-container-centro">
                        <img src="{{ asset('img/ped/ejes/eje3-wide.png') }}"
                            alt="Imagotipo en color dorado del Eje 3 con nombre Estado de Derecho, Seguridad y Justicia"
                            class="sm-w-100 w-100" title="Eje 3: Estado de Derecho, Seguridad y Justicia">
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="titulo-tematica">
                            Temáticas
                        </div>
                        <div class="row">
                            <div class="col-12 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/gobernanza.png') }}"
                                    alt="Imagotipo en guinda con texto Gobernanza con figura de la cúpula de un edificio"
                                    title="Temática: Gobernanza" class="sm-w-100 radio-16-fit">
                            </div>
                            <div class="col-12 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/imparticion-de-justicia.png') }}"
                                    alt="Imagotipo en guinda con texto Impartición de Justicia con figura de un mazo de juez"
                                    title="Temática: Impartición de Justicia " class="sm-w-100 radio-16-fit">
                            </div>
                            <div class="col-12 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/seguridad-publica.png') }}"
                                    alt="Imagotipo en guinda con texto Seguridad Pública con figura de un gorro de policía"
                                    title="Temática: Seguridad Pública" class="sm-w-100 radio-16-fit">
                            </div>
                            <div class="col-12 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/derechos-humanos.png') }}"
                                    alt="Imagotipo en guinda con texto Derechos Humanos con figura de una mano sosteniendo una balanza"
                                    title="Temática:  Derechos Humanos" class="sm-w-100 radio-16-fit">
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </section>
    <section class="eje4-ped" id="eje4">
        <div class="container">
            <a href="#" class="abrir-en-modal" data-src="https://ped2024-2030.puebla.gob.mx/documentos/4_Eje.pdf"
                data-title="Eje 4 del PED" rel="noopener noreferrer" title="Eje 4 del PED">
                <div class="row">
                    <div class="col-12 col-md-6 flex-container-centro">
                        <img src="{{ asset('img/ped/ejes/eje4-wide.png') }}"
                            alt="Imagotipo en verde del Eje 4 con nombre Desarrollo Urbano y Crecimiento Sostenible"
                            class="sm-w-100 w-100" title="Eje 4: Desarrollo Urbano y Crecimiento Sostenible">
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="titulo-tematica">
                            Temáticas
                        </div>
                        <div class="row">
                            <div class="col-12 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/medio-ambiente.png') }}"
                                    alt="Imagotipo en verde con texto Medio ambiente y Desarrollo Urbano con figura un edificio junto con una casa y dos hojas sobre ella"
                                    title="Temática:  Medio ambiente y Desarrollo Urbano" class="sm-w-100 radio-16-fit">
                            </div>
                            <div class="col-12 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/infraestructura.png') }}"
                                    alt="Imagotipo en verde con texto Infraestructura con figura de una ciudad sobre un engrane partido a la mitad"
                                    title="Temática:  Infraestructura" class="sm-w-100 radio-16-fit">
                            </div>
                            <div class="col-12 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/movilidad-y-transporte.png') }}"
                                    alt="Imagotipo en verde con texto Movilidad y Transporte con figura de autobus"
                                    title="Temática:  Movilidad y Transporte" class="sm-w-100 radio-16-fit">
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </section>
    <section class="eje5-ped" id="eje5">
        <div class="container">
            <a href="#" class="abrir-en-modal" data-src="https://ped2024-2030.puebla.gob.mx/documentos/5_Eje.pdf"
                data-title="Eje 5 del PED" rel="noopener noreferrer" title="Eje 5 del PED">
                <div class="row">
                    <div class="col-12 col-md-6 flex-container-centro">
                        <img src="{{ asset('img/ped/ejes/eje5-wide.png') }}" alt="" class="sm-w-100">
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="titulo-tematica">
                            Temáticas
                        </div>
                        <div class="row">
                            <div class="col-12 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/gobierno-de-resultados.png') }}" alt=""
                                    class="sm-w-100 radio-16-fit">
                            </div>
                            <div class="col-12 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/anticorrupcion.png') }}" alt=""
                                    class="sm-w-100 radio-16-fit">
                            </div>
                            <div class="col-12 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/comunicacion.png') }}" alt=""
                                    class="sm-w-100 radio-16-fit">
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </section>
    <section class="eje6-ped" id="eje6">
        <div class="container">
            <a href="#" class="abrir-en-modal"
                data-src="https://ped2024-2030.puebla.gob.mx/documentos/6_Transversal.pdf"
                data-title="Eje Transversal del PED" rel="noopener noreferrer" title="Eje 6 del PED">
                <div class="row">
                    <div class="col-12 col-md-6 flex-container-centro">
                        <img src="{{ asset('img/ped/ejes/eje6-wide.png') }}" alt="" class="sm-w-100">
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="titulo-tematica">
                            Temáticas
                        </div>
                        <div class="row">
                            <div class="col-12 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/mujeres.png') }}" alt=""
                                    class="sm-w-100 radio-16-fit">
                            </div>
                            <div class="col-12 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/tecnologia.png') }}" alt=""
                                    class="sm-w-100 radio-16-fit">
                            </div>
                            <div class="col-12 flex-container-centro">
                                <img src="{{ asset('img/ped/ejes/poblacion-indigena.png') }}" alt=""
                                    class="sm-w-100 radio-16-fit">
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        </div>
    </section>
    <section class="seguimiento">
        <div class="container">
            <div class="row flex-container-centro">
                <div class="col-4 contenedor-sped">
                    <a href="https://sped.puebla.gob.mx/" target="_blank" rel="noopener"
                        title="Sistema de Información para el Seguimiento a la Planeación y Evaluación del Desarrollo del Estado de Puebla (SPED)">
                        <img src="{{ asset('img/logo_sped.png') }}" alt="Imagotipo del SPED" title="Imagotipo del SPED">
                    </a>
                </div>
            </div>
        </div>

    </section>
    <section class="anexos" id="anexos">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="titulo-tematica">
                        Anexos
                    </div>
                </div>
                <div class="row container-anexos">
                    @foreach ($plan_reciente->anexos->where('publicado', 1)->sortBy('orden') as $anexo)
                        <div class="col-12 col-md-4 mb-4">
                            <a href="#" class="abrir-en-modal"
                                data-src="{{ $anexo->es_enlace ? $anexo->ruta_documento : asset('documentos/planesest/anexos/' . $anexo->ruta_documento) . '?v=' . $anexo->updated_at->timestamp }}"
                                data-title="{{ $anexo->titulo }}" rel="noopener noreferrer"
                                title="{{ $anexo->titulo }}">
                                <img src="{{ asset('img/ped/anexos/' . $anexo->imagen) . '?v=' . $anexo->updated_at->timestamp }}"
                                    alt="{{ $anexo->titulo }}" class="w-100">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="titulo-tematica">
                        Metodología para la elaboración del Plan Estatal de Desarollo
                    </div>
                </div>
                <div class="row container-anexos d-flex justify-content-center">
                    <div class="col-12 col-md-4">
                        <a href="#" class="abrir-en-modal"
                            data-src="https://ped2024-2030.puebla.gob.mx/documentos/Guia_para_la_formulacion_del_PED_2024-2030.pdf"
                            data-title="Metodología para la elaboración del Plan Estatal de Desarollo"
                            rel="noopener noreferrer"
                            title="Metodología para la elaboración del Plan Estatal de Desarollo">
                            <img src="{{ asset('img/ped/anexos/Guia_para_la_formulacion_del_PED_2024-2030_001.png') }}"
                                alt="" class="w-100">
                        </a>
                        {{-- <a href="https://ped2024-2030.puebla.gob.mx/documentos/Anexo_1.pdf" target="_blank"
                            rel="noopener noreferrer" title="Anexo 1 del PED">
                            <img src="{{ asset('img/ped/anexos/anexo1.png') }}" alt="" class="w-100">
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="historicos-planes-estatales" id="historico">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="subtitulo-tematica">
                        Archivo Histórico de los
                    </div>
                    <div class="titulo-tematica">
                        Planes Estatales de Desarrollo
                    </div>
                </div>
            </div>
            @if ($planes_estatales->isEmpty())
                <div class="container d-flex justify-content-center align-items-center flex-column">
                    <img class="w-40p" src="{{ asset('imagen/no-file.png') }}" alt="Imagen de Not Found"
                        title="Imagen de Not Found">
                    <p class="text-black text-center pb-5">Upps, no se encontraron registros.</p>
                </div>
            @else
                <div class="carousel-container">
                    <div class="owl-carousel owl-theme" id="carrusel-historico">
                        @foreach ($planes_estatales as $plan_estatal)
                            <div class="item">
                                <li class="tarjetahistoricoplanes">
                                    <a rel="noopener" class="tarjetahistoricoplanes-link" href="#historico"
                                        title="{{ $plan_estatal->nombre }}"
                                        data-src="{{ asset('planesest/' . $plan_estatal->ruta_documento) }}"
                                        data-title="{{ $plan_estatal->nombre }}">
                                        <div class="tarjetahistoricoplanes-image"
                                            style="background-image: url({{ asset('portadaplanesest/' . $plan_estatal->portada) }});"
                                            data-image-full="{{ asset('portadaplanesest/' . $plan_estatal->portada) }}">
                                            <img src="{{ asset('portadaplanesest/' . $plan_estatal->portada) }}"
                                                alt="Portada del {{ $plan_estatal->nombre }}"
                                                title="{{ $plan_estatal->nombre }}">
                                        </div>
                                        <div class="tarjetahistoricoplanes-description">
                                            <h2>{{ $plan_estatal->periodo }}</h2>
                                            <p>{{ $plan_estatal->gobernador }}</p>
                                            <img class="justify-items-center w-10p" src="{{ asset('imagen/pdf.png') }}"
                                                title="Imagen de PDF" alt="imagen de excel">
                                        </div>
                                    </a>
                                </li>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="container">
                <!-- Suponiendo que $documentos es una colección de documentos de COPLADEP obtenidos de tu base de datos -->
                @if ($planes_estatales->isNotEmpty())
                    <!-- Itera sobre los documentos y obtén la fecha de actualización más reciente -->
                    @php
                        $ultimaActualizacion = $planes_estatales->max('updated_at');
                    @endphp
                    <!-- Muestra la leyenda con la fecha de la última actualización -->
                    <p class="text-dark" style="font-size: 10px">Última actualización:
                        {{ $ultimaActualizacion->format('d/m/Y H:i:s') }}</p>
                @else
                    <p class="text-dark" style="font-size: 10px">Última actualización:
                        No hay información disponible.</p>
                    <p>
                @endif
            </div>
        </div>
        <div id="myModal" class="modal-planeader" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <div class="modal-content">
                <button class="close-btn" aria-label="Cerrar">&times;</button>
                <div class="d-flex flex-row justify-content-evenly">
                    <h3 id="modalTitle"></h3>
                    <div class="boton-copiar" id="botoncopiar">
                        <i class="fa-solid fa-copy boton-copiar__icono"></i>
                    </div>
                </div>
                <iframe id="modalIframe" class="w-100 h-100" src="" title="Contenido del documento"
                    frameborder="0"></iframe>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
