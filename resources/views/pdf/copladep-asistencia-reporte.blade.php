<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Lista Final de Asistencia - {{ $sesion->nombre }}</title>
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
        .summary-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-left: 4px solid #691b31;
            padding: 8px 12px;
            margin-bottom: 14px;
            font-size: 8pt;
        }
        .summary-box table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }
        .summary-box td {
            padding: 2px 4px;
            border: none;
        }
        .stat-value {
            font-weight: bold;
            color: #691b31;
        }
        table.asistencia-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7pt;
        }
        table.asistencia-table thead {
            display: table-header-group;
        }
        table.asistencia-table tr {
            page-break-inside: avoid;
        }
        table.asistencia-table th {
            background-color: #691b31;
            color: #ffffff;
            font-weight: bold;
            padding: 5px 4px;
            border: 1px solid #691b31;
            text-align: left;
        }
        table.asistencia-table td {
            padding: 4px;
            border: 1px solid #d9d9d9;
            vertical-align: top;
        }
        table.asistencia-table tr:nth-child(even) td {
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
        .badge-manual { background-color: #e2e3e5; color: #41464b; }
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
        <div class="header-subtitle">Lista de Asistencia Efectiva</div>

        <div class="summary-box">
            <table>
                <tr>
                    <td style="width: 60%;"><strong>Fecha y hora del evento:</strong> {{ optional($sesion->fecha_evento)->format('d/m/Y H:i') ?? 'Por definir' }} hrs</td>
                    <td style="width: 40%;"><strong>Asistencias registradas:</strong> <span class="stat-value">{{ $totalAsistentes }}</span></td>
                </tr>
                <tr>
                    <td><strong>Sede:</strong> {{ $sesion->lugar ?? 'Sesión Virtual' }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td><strong>Emisión del reporte:</strong> {{ now()->format('d/m/Y H:i') }} hrs</td>
                    <td></td>
                </tr>
            </table>
        </div>

        <table class="asistencia-table">
            <thead>
                <tr>
                    <th style="width: 22px; text-align: center;">No.</th>
                    <th style="width: 65px; text-align: center;">Tipo</th>
                    <th>Titular Oficial Convocado</th>
                    <th>Asistente / Representante</th>
                    <th>Dependencia / Organismo</th>
                    <th style="width: 75px;">Municipio</th>
                    <th style="width: 48px; text-align: center;">Check-in</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($asistentes as $index => $asistente)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td style="text-align: center;"><span class="badge {{ $asistente['tipo'] === 'Representante' ? 'badge-rep' : ($asistente['tipo'] === 'Manual' ? 'badge-manual' : 'badge-titular') }}">{{ $asistente['tipo'] }}</span></td>
                        <td><strong>{{ $asistente['titular'] }}</strong></td>
                        <td>{{ $asistente['nombre'] }}</td>
                        <td>{{ $asistente['dependencia'] }}</td>
                        <td>{{ $asistente['municipio'] }}</td>
                        <td style="text-align: center; font-weight: bold; color: #198754;">{{ $asistente['hora'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 15px; color: #888;">
                            No se registran asistencias efectivas (check-in) al momento.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <p style="text-align: justify; font-size: 7pt; color: #666; margin-top: 20px;">
            Lista de asistencia para apoyo en la integración del expediente y la verificación del quórum conforme a las reglas aplicables.
        </p>
    </div>
</body>
</html>
