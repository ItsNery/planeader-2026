<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Padrón de Registrados - {{ $sesion->nombre }}</title>
    <style>
        @font-face {
            font-family: 'Gilroy';
            src: url('{{ str_replace('\\', '/', public_path('css/fuentes/Gilroy/Gilroy-Regular.ttf')) }}') format('truetype');
            font-weight: normal;
        }
        @font-face {
            font-family: 'Gilroy';
            src: url('{{ str_replace('\\', '/', public_path('css/fuentes/Gilroy/Gilroy-Bold.ttf')) }}') format('truetype');
            font-weight: bold;
        }
        @page {
            margin: 125px 40px 150px;
            size: letter portrait;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Gilroy', 'DejaVu Sans', sans-serif;
            color: #262626;
            font-size: 7.5pt;
        }
        .background {
            position: fixed;
            top: -125px;
            left: -40px;
            width: 816px;
            height: 1056px;
            z-index: -1000;
        }
        .footer {
            position: fixed;
            bottom: -55px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7pt;
            color: #4a4a4a;
            line-height: 1.3;
        }
        .container {
            margin: 0;
        }
        .header-title {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            color: #691b31;
            margin-bottom: 4px;
            text-transform: uppercase;
        }
        .header-subtitle {
            text-align: center;
            font-size: 8.5pt;
            color: #555;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7pt;
        }
        thead {
            display: table-header-group;
        }
        tr {
            page-break-inside: avoid;
        }
        th {
            background-color: #691b31;
            color: #ffffff;
            font-weight: bold;
            padding: 5px 4px;
            border: 1px solid #691b31;
            text-align: left;
        }
        td {
            padding: 4px;
            border: 1px solid #d9d9d9;
            vertical-align: top;
        }
        tr:nth-child(even) td {
            background-color: #fbfbfb;
        }
        .badge {
            font-size: 6.5pt;
            padding: 1px 4px;
            border-radius: 2px;
            display: inline-block;
        }
        .badge-titular { background-color: #d1e7dd; color: #0f5132; }
        .badge-rep { background-color: #fff3cd; color: #664d03; }
        .badge-otro { background-color: #cff4fc; color: #055160; }
        .badge-presencial { background-color: #e2e3e5; color: #41464b; }
        .badge-virtual { background-color: #e8daef; color: #5b2c6f; }
    </style>
</head>
<body>
    <img class="background" src="{{ $membreteBase64 }}" alt="Membrete institucional">

    <div class="footer">
        Av. Cúmulo de Virgo, número 1358, Reserva Territorial Atlixcáyotl,<br>
        Código Postal 72460, Puebla, Puebla.<br>
        Tel.: (222) 1442 449 Ext.
    </div>

    <div class="container">
        <div class="header-title">{{ $sesion->nombre }}</div>
        <div class="header-subtitle">Padrón Oficial de Personas Registradas</div>

        <table>
            <thead>
                <tr>
                    <th style="width: 22px; text-align: center;">No.</th>
                    <th style="width: 45px; text-align: center;">Tipo</th>
                    <th style="width: 95px;">Invitado Oficial (Titular)</th>
                    <th style="width: 85px;">Representante</th>
                    <th>Cargo</th>
                    <th>Institución</th>
                    <th>Categoría</th>
                    <th style="width: 60px;">Municipio</th>
                    <th style="width: 45px; text-align: center;">Modalidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($registros as $index => $registro)
                    @php
                        $tipoClass = match($registro->tipo_asistente) {
                            'titular' => 'badge-titular',
                            'representante' => 'badge-rep',
                            default => 'badge-otro',
                        };
                        $titular = $registro->invitado?->nombre_completo ?? ($registro->tipo_asistente === 'otro' ? $registro->nombre_completo : 'N/A');
                        $representante = ($registro->tipo_asistente === 'representante') ? $registro->nombre_completo : '-';
                        $municipio = $registro->catMunicipio?->nombre_municipio ?? 'N/A';
                    @endphp
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td style="text-align: center;"><span class="badge {{ $tipoClass }}">{{ ucfirst($registro->tipo_asistente) }}</span></td>
                        <td><strong>{{ $titular }}</strong></td>
                        <td>{{ $representante }}</td>
                        <td>{{ $registro->cargo }}</td>
                        <td>{{ $registro->invitado?->dependenciaCopladep?->nombre ?: $registro->invitado?->dependencia }}</td>
                        <td>{{ $registro->invitado?->categoria }}</td>
                        <td>{{ $municipio }}</td>
                        <td style="text-align: center;">
                            <span class="badge {{ $registro->modalidad === 'virtual' ? 'badge-virtual' : 'badge-presencial' }}">
                                {{ ucfirst($registro->modalidad ?? 'N/A') }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
