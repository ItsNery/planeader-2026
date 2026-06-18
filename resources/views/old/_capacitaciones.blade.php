@extends('layouts.plantilla')
@section('title', 'Capacitaciones del COPLADEMUN')
@section('meta-description',
    'Página donde se encontrarán los documentos de las capacitaciones del Comité de Planeación
    Municipal del Sistema Estatal de Planeación Democrática del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'COPLADEMUN:Capacitaciones - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Bienvenido a la página donde se encontrarán los documentos de las capacitaciones del Comité
    de Planeación Municipal del Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'COPLADEMUN:Capacitaciones - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
    'Bienvenido a la página donde se encontrarán los documentos de las capacitaciones del
    Comité de Planeación Municipal del Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('css')

@endsection

@section('content')
    <main id="#" class="">
        <section class="planes_mun">
            <div class="container-fluid bg-breadcrumb-capacitaciones">
                <div class="container text-center py-5" style="max-width: 900px;">
                    <h3 class="text-black display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Capacitación Municipal</h1>
                        <ol class="breadcrumb justify-content-center text-white mb-0 wow fadeInDown" data-wow-delay="0.3s">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-black">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="#" class="text-black">Capacitación Municipal</a></li>
                        </ol>
                </div>
            </div>
            <div class="container py-5">
                {{-- <div class="col">
                    <div class="text-center mb-3 pb-3">
                        <p class="text-white pt-3"> Herramientas de apoyo técnico y metodológico para la integración de documentos municipales en materia de evaluación y planeación.</p>
                    </div>
                </div> --}}
                <div class="accordion" id="mainAccordion">
                    <!-- Programa de Capacitación Municipal 2024 1er Semestre -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2024">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse2024" aria-expanded="true" aria-controls="collapse2024">
                                Programa de Capacitación Municipal 2024 1er Semestre
                            </button>
                        </h2>
                        <div id="collapse2024" class="accordion-collapse collapse show" aria-labelledby="heading2024"
                            data-bs-parent="#mainAccordion">
                            <div class="accordion-body">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('imagen/capacitacion-municipal/Programa de Capacitación Primer Semestre 2024.jpg') }}"
                                        alt="Programa de Capacitación Municipal 2024 1er Semestre" class="img-fluid">
                                </div>
                                <div class="accordion" id="nestedAccordion2024">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="nestedHeading2024">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#nestedCollapse2024"
                                                aria-expanded="false" aria-controls="nestedCollapse2024">
                                                Documentos
                                            </button>
                                        </h2>
                                        <div id="nestedCollapse2024" class="accordion-collapse collapse"
                                            aria-labelledby="nestedHeading2024" data-bs-parent="#nestedAccordion2024">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <!-- Tarjetas de Documentos para 2024 1er Semestre -->
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Elaboración del Programa Anual de Evaluación
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Jueves 11 de abril/1. Elaboración del Programa Anual de Evaluación.pdf') }}', 'Elaboración del Programa Anual de Evaluación')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Jueves 11 de abril/1. Elaboración del Programa Anual de Evaluación.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Operación de las Instancias de Planeación
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Jueves 11 de abril/2. Operación de las Instancias de Planeación.pdf') }}', 'Elaboración del Programa Anual de Evaluación')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Jueves 11 de abril/2. Operación de las Instancias de Planeación.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                SRFT Y MIDS
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Jueves 11 de abril/3. SRFT Y MIDS.pdf') }}', 'SRFT Y MIDS')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Jueves 11 de abril/3. SRFT Y MIDS.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Cumplimiento de obligaciones para la presentación de las
                                                                declaraciones patrimoniales
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Jueves 11 de abril/4. Cumplimiento de obligaciones para la presentación de las declaraciones patrimoniales.pdf') }}', 'Cumplimiento de obligaciones para la presentación de las declaraciones patrimoniales')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Jueves 11 de abril/4. Cumplimiento de obligaciones para la presentación de las declaraciones patrimoniales.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Consideraciones del Enfoque de Auditoría de Desempeño para
                                                                la Fiscalización Superior
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Jueves 11 de abril/5. Consideraciones del Enfoque de Auditoría de Desempeño para la Fiscalización Superior.pdf') }}', 'Consideraciones del Enfoque de Auditoría de Desempeño para la Fiscalización Superior')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Jueves 11 de abril/5. Consideraciones del Enfoque de Auditoría de Desempeño para la Fiscalización Superior.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Obligaciones Fiscales Municipales 2024
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Viernes 12 de abril/1. Obligaciones Fiscales Municipales_2024.pdf') }}', 'Obligaciones Fiscales Municipales_2024')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Viernes 12 de abril/1. Obligaciones Fiscales Municipales_2024.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Conceptos Básicos de Mejora Regulatoria
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Viernes 12 de abril/2. Conceptos Básicos de Mejora Regulatoria.pdf') }}', 'Conceptos Básicos de Mejora Regulatoria')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Viernes 12 de abril/2. Conceptos Básicos de Mejora Regulatoria.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Alerta por Violencia de Género
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Viernes 12 de abril/3. Alerta por Violencia de Género.pdf') }}', 'Alerta por Violencia de Género')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Viernes 12 de abril/3. Alerta por Violencia de Género.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Violencia Politica
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Viernes 12 de abril/4. Violencia Politica.pdf') }}', 'Violencia Politica')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Viernes 12 de abril/4. Violencia Politica.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Escudo Web
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Viernes 12 de abril/5. Escudo Web.pdf') }}', 'Escudo Web')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Viernes 12 de abril/5. Escudo Web.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Policía Cibernética
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Viernes 12 de abril/6. Policía Cibernética.pdf') }}', 'Policía Cibernética')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2024/Material. Viernes 12 de abril/6. Policía Cibernética.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Agrega más acordeones anidados aquí si es necesario -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Programa de Capacitación Municipal 2023 2do Semestre -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2023Second">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse2023Second" aria-expanded="false"
                                aria-controls="collapse2023Second">
                                Programa de Capacitación Municipal 2023 2do Semestre
                            </button>
                        </h2>
                        <div id="collapse2023Second" class="accordion-collapse collapse"
                            aria-labelledby="heading2023Second" data-bs-parent="#mainAccordion">
                            <div class="accordion-body">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('imagen/capacitacion-municipal/Programa de Capacitación Segundo Semestre 2023.jpg') }}"
                                        alt="Programa de Capacitación Municipal 2023 2do Semestre" class="img-fluid">
                                </div>
                                <div class="accordion" id="nestedAccordion2023Second">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="nestedHeading2023Second">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#nestedCollapse2023Second"
                                                aria-expanded="false" aria-controls="nestedCollapse2023Second">
                                                Documentos
                                            </button>
                                        </h2>
                                        <div id="nestedCollapse2023Second" class="accordion-collapse collapse"
                                            aria-labelledby="nestedHeading2023Second"
                                            data-bs-parent="#nestedAccordion2023Second">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <!-- Tarjetas de Documentos para 2023 2do Semestre -->
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Alineación de los Planes Municipales de Desarrollo 2021-2024
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/2doSemestre2023/1-Alineación PMD al PED 26_09 (1).pdf') }}', 'Alineación de los Planes Municipales de Desarrollo 2021-2024')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/2doSemestre2023/1-Alineación PMD al PED 26_09 (1).pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Proyecto Estratégico de Impulso al Agave Mezcalero Poblano
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/2doSemestre2023/1-PROY ESTRATEG_IMPULSO_AGAVE_POBLANO.pdf') }}', 'PROYECTO ESTRATÉGICO DE IMPULSO AL AGAVE MEZCALERO POBLANO')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/2doSemestre2023/1-PROY ESTRATEG_IMPULSO_AGAVE_POBLANO.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Validación de Expedientes
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/2doSemestre2023/1-Validación de Expedientes2023 (1).pdf') }}', 'Validación de Expedientes2023 (1)')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/2doSemestre2023/1-Validación de Expedientes2023 (1).pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Programas DGEP 2023
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/2doSemestre2023/2,3 y 4-Programas DGEP 2023, Secretaria de trabajo.pdf') }}', 'Programas DGEP 2023')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/2doSemestre2023/2,3 y 4-Programas DGEP 2023, Secretaria de trabajo.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Cultura del agua
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/2doSemestre2023/2-Cultura del agua Secretaria de Medio Ambiente.pdf') }}', 'Cultura del agua')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/2doSemestre2023/2-Cultura del agua Secretaria de Medio Ambiente.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Presentación del Portal de Información Municipal y Regional
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/2doSemestre2023/2-Presentación_Portal_Inf_Municipal_V2 ESTADISTICA.pdf') }}', 'Presentación del Portal de Información Municipal')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/2doSemestre2023/2-Presentación_Portal_Inf_Municipal_V2 ESTADISTICA.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Prevención Social del Delito y Cultura de la Legalidad
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/2doSemestre2023/3-PREVENCIÓN SOCIAL DEL DELITO Y CULTURA DE LA LEGALIDAD.pdf') }}', 'Prevención Social del Delito y Cultura de la Legalidad')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/2doSemestre2023/3-PREVENCIÓN SOCIAL DEL DELITO Y CULTURA DE LA LEGALIDAD.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Escuelas de Campo
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/2doSemestre2023/4- Escuelas de Campo-Secretaría de Desarrollo Rural.pdf') }}', 'Escuelas de Campo')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/2doSemestre2023/4- Escuelas de Campo-Secretaría de Desarrollo Rural.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Transversalidad de la Perspectiva de Género
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/2doSemestre2023/4-TRANSVERSALIDAD DE LA PERSPECTIVA DE GÉNERO.pdf') }}', 'Transversalidad de la Perspectiva de Género')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/2doSemestre2023/4-TRANSVERSALIDAD DE LA PERSPECTIVA DE GÉNERO.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                ABC de la cultura turística
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/2doSemestre2023/5-ABC de la cultura turística28 sep.pdf') }}', 'ABC de la cultura turística')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/2doSemestre2023/5-ABC de la cultura turística28 sep.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Prevención y Movilidad Segura
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/2doSemestre2023/5-Prevención y Movilidad Segura SMT.pdf') }}', 'Prevención y Movilidad Segura')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/2doSemestre2023/5-Prevención y Movilidad Segura SMT.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Agrega más tarjetas aquí -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Agrega más acordeones anidados aquí si es necesario -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Programa de Capacitación Municipal 2023 1er Semestre -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2023First">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse2023First" aria-expanded="false"
                                aria-controls="collapse2023First">
                                Programa de Capacitación Municipal 2023 1er Semestre
                            </button>
                        </h2>
                        <div id="collapse2023First" class="accordion-collapse collapse"
                            aria-labelledby="heading2023First" data-bs-parent="#mainAccordion">
                            <div class="accordion-body">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('imagen/capacitacion-municipal/Programa de Capacitación Primer Semestre 2023.jpg') }}"
                                        alt="Programa de Capacitación Municipal 2023 1er Semestre" class="img-fluid">
                                </div>
                                <div class="accordion" id="nestedAccordion2023First">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="nestedHeading2023First">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#nestedCollapse2023First"
                                                aria-expanded="false" aria-controls="nestedCollapse2023First">
                                                Documentos
                                            </button>
                                        </h2>
                                        <div id="nestedCollapse2023First" class="accordion-collapse collapse"
                                            aria-labelledby="nestedHeading2023First"
                                            data-bs-parent="#nestedAccordion2023First">
                                            <div class="accordion-body">
                                                <div class="container row">
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Lenguaje incluyente en documentos oficiales
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2023/1.Lenguaje incluyente en documentos oficiales.pdf') }}', 'Lenguaje Incluyente en Documentos Oficiales')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2023/1.Lenguaje incluyente en documentos oficiales.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Declaración Patrimonial
                                                                <br>
                                                                <br>
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2023/2. Declaración Patrimonial.pdf') }}', 'Declaración Patromonial')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2023/2. Declaración Patrimonial.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Integración de Proyectos de Inversión
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2023/3. Integración de Proyectos de Inversión.pdf') }}', 'Integración de Proyectos de Inversión')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2023/3. Integración de Proyectos de Inversión.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Puebla, Ahorro y Uso Eficiente de Energía
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2023/4. Puebla, Ahorro y Uso Eficiente de Energía.pdf') }}', 'Puebla, Ahorro y Uso Eficiente de Energía')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2023/4. Puebla, Ahorro y Uso Eficiente de Energía.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Construcción indicadores
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2023/5. Construcción indicadores.pdf') }}', 'Construcción indicadores')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2023/5. Construcción indicadores.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Juventudes y desarrollo
                                                                <br>
                                                                <br>
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2023/6. Juventudes y desarrollo.pdf') }}', 'Juventudes y desarrollo')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2023/6. Juventudes y desarrollo.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Museos Comunitarios
                                                                <br>
                                                                <br>
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2023/7. Museos Comunitarios.pdf') }}', '7. Museos Comunitarios')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2023/7. Museos Comunitarios.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Servicios, verificaciones, programas, capacitaciones y
                                                                apoyos
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2023/8. Servicios, verificaciones, programas, capacitaciones y apoyos.pdf') }}', 'Servicios, verificaciones, programas, capacitaciones y apoyos')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2023/8. Servicios, verificaciones, programas, capacitaciones y apoyos.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Análisis de cobertura de agua para proyectos de inversión
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2023/9.  Análisis de cobertura de agua para proyectos de inversión.pdf') }}', 'Análisis de cobertura de agua para proyectos de inversión')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2023/9.  Análisis de cobertura de agua para proyectos de inversión.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                Escalas de movilidad
                                                                <br>
                                                                <br>
                                                                <br>
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2023/10. Escalas de movilidad.pdf') }}', 'Escalas de movilidad')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2023/10. Escalas de movilidad.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="tarjeta-capacitaciones">
                                                            <div class="custom-icon">
                                                                📄
                                                            </div>
                                                            <div class="custom-title">
                                                                ODS 16
                                                                <br>
                                                                <br>
                                                                <br>
                                                            </div>
                                                            <div class="custom-actions">
                                                                <button class="custom-view-btn"
                                                                    onclick="openModal('{{ asset('documentos/capacitacion-municipal/1erSemestre2023/11. ODS 16.pdf') }}', 'ODS 16')">Ver</button>
                                                                <a class="custom-download-btn"
                                                                    href="{{ asset('documentos/capacitacion-municipal/1erSemestre2023/11. ODS 16.pdf') }}"
                                                                    download="" rel="noopener">Descargar <img
                                                                        class="justify-items-center" src="/imagen/pdf.png"
                                                                        alt="imagen de PDF" width="10%"
                                                                        title="Icono de PDF"></a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Agrega más acordeones anidados aquí si es necesario -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </section>
    </main>
@endsection

@section('scripts')
@endsection
