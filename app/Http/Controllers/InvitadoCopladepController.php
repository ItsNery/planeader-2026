<?php

namespace App\Http\Controllers;

use App\Models\CatDependenciaCopladep;
use App\Models\CatMunicipio;
use App\Models\InvitadoCopladep;
use App\Models\SesionCopladep;
use App\Services\ImportacionInvitadosCopladep;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InvitadoCopladepController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-invitado-copladep|crear-invitado-copladep|editar-invitado-copladep|borrar-invitado-copladep', ['only' => ['index', 'monitor', 'exportarCsv', 'exportarAsistenciaExcel', 'exportarAsistenciaPdf']]);
        $this->middleware('permission:crear-invitado-copladep', ['only' => ['store', 'importarForm', 'plantilla', 'importar']]);
        $this->middleware('permission:editar-invitado-copladep', ['only' => ['update', 'toggleCheckInExpress', 'revocarIngreso']]);
        $this->middleware('permission:borrar-invitado-copladep', ['only' => ['destroy']]);
    }

    public function index(SesionCopladep $sesion)
    {
        $invitados = $sesion->invitados()->with(['municipio', 'dependenciaCopladep', 'ingresosQr' => fn ($query) => $query->where('sesion_copladep_id', $sesion->id)])->orderBy('nombre_completo')->get();
        $municipios = CatMunicipio::orderBy('nombre_municipio')->get();
        $dependencias = CatDependenciaCopladep::where('activo', true)->orderBy('nombre')->get();

        return view('panel-copladep.sesiones.invitados.index', compact('sesion', 'invitados', 'municipios', 'dependencias'));
    }

    public function store(Request $request, SesionCopladep $sesion)
    {
        $datos = $this->validated($request);
        $datos['sesion_copladep_id'] = $sesion->id;
        $datos['sesion'] = $sesion->numero === 2 ? 'segunda' : 'primera';
        InvitadoCopladep::create($datos);

        return redirect()->route('panel-copladep-sesiones.invitados.index', $sesion)->with('success', 'Invitado registrado exitosamente.');
    }

    public function exportarCsv(SesionCopladep $sesion)
    {
        return response()->streamDownload(function () use ($sesion) {
            $output = fopen('php://output', 'wb');
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['ID', 'Nombre completo', 'Sexo', 'Cargo', 'Dependencia', 'Municipio', 'Modalidad', 'Estatus de asistencia'], ';', '"', '');

            $invitados = $sesion->invitados()->with(['municipio', 'dependenciaCopladep', 'ingresosQr' => fn ($query) => $query->where('sesion_copladep_id', $sesion->id)])->orderBy('nombre_completo')->get();
            foreach ($invitados as $invitado) {
                $estatus = $invitado->estadoAsistencia($sesion->fecha_evento);
                $campos = [$invitado->id, $invitado->nombre_completo, $invitado->sexo, $invitado->cargo,
                    $invitado->dependenciaCopladep?->nombre ?? $invitado->dependencia ?? '',
                    $invitado->municipio?->nombre_municipio ?? '', $invitado->modalidad ?? 'Por definir', $estatus];
                $campos = array_map(static function ($valor) {
                    $texto = (string) $valor;
                    return preg_match('/^[\x00-\x20]*[=+\-@]/u', $texto) ? "'" . $texto : $texto;
                }, $campos);
                fputcsv($output, $campos, ';', '"', '');
            }
            fclose($output);
        }, 'invitados-' . Str::slug($sesion->clave) . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Cache-Control' => 'no-store',
        ]);
    }

    public function importarForm(SesionCopladep $sesion)
    {
        return view('panel-copladep.sesiones.invitados.importar', compact('sesion'));
    }

    public function plantilla(SesionCopladep $sesion, ImportacionInvitadosCopladep $importacion)
    {
        $book = $importacion->plantilla();

        return response()->streamDownload(function () use ($book) {
            try {
                (new Xlsx($book))->save('php://output');
            } finally {
                $book->disconnectWorksheets();
            }
        }, 'plantilla-invitados-copladep.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'no-store',
        ]);
    }

    public function importar(Request $request, SesionCopladep $sesion, ImportacionInvitadosCopladep $importacion)
    {
        $request->validate(['archivo' => 'required|file|mimes:xlsx|max:5120'], [
            'archivo.required' => 'Selecciona un archivo XLSX para importar.',
            'archivo.mimes' => 'Selecciona un archivo XLSX generado con la plantilla.',
            'archivo.max' => 'El archivo no debe superar los 5 MB.',
        ]);

        $count = $importacion->importar($request->file('archivo')->getRealPath(), $sesion);

        return redirect()->route('panel-copladep-sesiones.invitados.index', $sesion)
            ->with('success', "Se importaron {$count} invitados correctamente.");
    }

    public function update(Request $request, SesionCopladep $sesion, InvitadoCopladep $invitado)
    {
        abort_unless($invitado->sesion_copladep_id === $sesion->id, 404);
        $invitado->update($this->validated($request));

        return redirect()->route('panel-copladep-sesiones.invitados.index', $sesion)->with('success', 'Datos del invitado actualizados correctamente.');
    }

    public function destroy(Request $request, SesionCopladep $sesion, InvitadoCopladep $invitado)
    {
        abort_unless($invitado->sesion_copladep_id === $sesion->id, 404);
        try {
            $invitado->delete();

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Invitado eliminado correctamente.']);
            }

            return redirect()->route('panel-copladep-sesiones.invitados.index', $sesion)->with('success', 'Invitado eliminado.');
        } catch (\Exception) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'No se puede eliminar a este invitado porque ya tiene un registro de asistencia vinculado.'], 422);
            }

            return redirect()->route('panel-copladep-sesiones.invitados.index', $sesion)->withErrors(['error' => 'No se puede eliminar a este invitado porque ya tiene un registro de asistencia vinculado.']);
        }
    }

    public function monitor(SesionCopladep $sesion)
    {
        $invitados = $sesion->invitados()->where(function ($query) use ($sesion) {
            $query->whereHas('registros', fn ($registros) => $registros->where('sesion_copladep_id', $sesion->id))->orWhere('check_in_express', true);
        })->with(['municipio', 'ingresosQr' => fn ($query) => $query->where('sesion_copladep_id', $sesion->id)])
            ->orderBy('nombre_completo')->get();
        $total = $invitados->count();
        $asistencias = $invitados->filter(fn ($invitado) => $invitado->presente())->count();
        $faltantes = $total - $asistencias;

        return view('panel-copladep.sesiones.invitados.monitor', compact('sesion', 'invitados', 'total', 'asistencias', 'faltantes'));
    }

    public function toggleCheckInExpress(SesionCopladep $sesion, InvitadoCopladep $invitado)
    {
        abort_unless($invitado->sesion_copladep_id === $sesion->id, 404);
        $invitado->check_in_express = ! $invitado->check_in_express;
        $invitado->save();
        $invitado->load(['ingresosQr' => fn ($query) => $query->where('sesion_copladep_id', $sesion->id)]);
        $estado = $invitado->estadoAsistencia($sesion->fecha_evento);

        return response()->json([
            'success' => true,
            'estado_actual' => $invitado->check_in_express,
            'estado_texto' => $estado,
            'estado_clase' => $estado === 'Falta' ? 'bg-secondary' : ($estado === 'Asistencia con retardo' ? 'bg-warning text-dark' : 'bg-success'),
            'message' => $invitado->check_in_express ? 'Asistencia manual registrada.' : ($invitado->presente() ? 'Asistencia manual retirada; el ingreso por QR permanece registrado.' : 'Asistencia manual retirada.'),
        ]);
    }

    public function revocarIngreso(SesionCopladep $sesion, int $registro)
    {
        $ingreso = $sesion->registros()->whereKey($registro)->whereNotNull('check_in_at')->firstOrFail();
        $ingreso->update(['check_in_at' => null]);

        return redirect()->route('panel-copladep-sesiones.invitados.monitor', $sesion)
            ->with('ingreso_revocado', 'Se retiró el ingreso. El registro de la persona se conserva.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'sexo' => 'required|in:Hombre,Mujer,Otro',
            'cargo' => 'required|string|max:255',
            'dependencia_id' => 'nullable|integer|exists:cat_dependencias_copladep,id',
            'municipio_id' => 'nullable|integer|exists:cat_municipios,id',
            'modalidad' => 'nullable|in:presencial,virtual',
        ]);
    }

    public function exportarAsistenciaPdf(SesionCopladep $sesion)
    {
        $asistentes = $this->asistenciasParaReporte($sesion);
        $totalAsistentes = $asistentes->count();
        $membretePath = public_path('sesiones-copladep/Membrete.png');
        $membreteBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($membretePath));

        $pdf = Pdf::loadView('pdf.copladep-asistencia-reporte', compact('sesion', 'asistentes', 'totalAsistentes', 'membreteBase64'))
            ->setPaper('letter', 'portrait');

        return $pdf->stream('asistencia-final-' . Str::slug($sesion->clave) . '.pdf');
    }

    public function exportarAsistenciaExcel(SesionCopladep $sesion)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Asistencia Efectiva');

        $sheet->setCellValue('A1', 'COMITÉ DE PLANEACIÓN PARA EL DESARROLLO DEL ESTADO DE PUEBLA (COPLADEP)');
        $sheet->setCellValue('A2', $sesion->nombre);
        $sheet->setCellValue('A3', 'LISTA DE ASISTENCIA EFECTIVA (CHECK-IN)');
        $sheet->setCellValue('A4', 'Fecha de emisión: ' . now()->format('d/m/Y H:i') . ' hrs');

        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');
        $sheet->mergeCells('A4:I4');

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => '691B31'], 'size' => 12],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:A3')->applyFromArray($headerStyle);
        $sheet->getStyle('A4')->getFont()->setItalic(true)->setSize(9);

        $headers = ['No.', 'Tipo Asistencia', 'Titular Oficial Convocado', 'Asistente / Representante', 'Cargo', 'Dependencia / Organismo', 'Municipio', 'Modalidad', 'Hora Check-in'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '6', $header);
            $col++;
        }

        $tableHeaderStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 10],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '691B31']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ];
        $sheet->getStyle('A6:I6')->applyFromArray($tableHeaderStyle);
        $sheet->getRowDimension(6)->setRowHeight(24);

        $asistentes = $this->asistenciasParaReporte($sesion);
        $row = 7;
        foreach ($asistentes as $index => $asistente) {
            $sheet->setCellValue('A' . $row, $index + 1);
            foreach (['tipo', 'titular', 'nombre', 'cargo', 'dependencia', 'municipio', 'modalidad', 'hora'] as $i => $campo) {
                $sheet->setCellValueExplicit(chr(ord('B') + $i) . $row, (string) $asistente[$campo], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            }

            if ($row % 2 === 0) {
                $sheet->getStyle('A' . $row . ':I' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8F9FA');
            }
            $row++;
        }

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D9D9D9'],
                ],
            ],
        ];
        $sheet->getStyle('A6:I' . max(6, $row - 1))->applyFromArray($styleArray);

        foreach (range('A', 'I') as $colLetter) {
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            try {
                (new Xlsx($spreadsheet))->save('php://output');
            } finally {
                $spreadsheet->disconnectWorksheets();
            }
        }, 'asistencia-efectiva-' . Str::slug($sesion->clave) . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'no-store',
        ]);
    }
    /** Cada ingreso QR es una persona; el pase manual no identifica a un representante. */
    private function asistenciasParaReporte(SesionCopladep $sesion)
    {
        $invitados = $sesion->invitados()
            ->where(fn ($q) => $q->where('check_in_express', true)
                ->orWhereHas('registros', fn ($r) => $r->where('sesion_copladep_id', $sesion->id)->whereNotNull('check_in_at')))
            ->with(['municipio', 'dependenciaCopladep', 'ingresosQr' => fn ($q) => $q->where('sesion_copladep_id', $sesion->id)->with('catMunicipio')->orderBy('check_in_at')->orderBy('id')])
            ->orderBy('nombre_completo')->get();

        return $invitados->flatMap(function ($invitado) {
            $ingresos = $invitado->ingresosQr;
            $filas = $ingresos->map(fn ($registro) => [
                'tipo' => ucfirst($registro->tipo_asistente),
                'titular' => $invitado->nombre_completo,
                'nombre' => $registro->nombre_completo,
                'cargo' => $registro->cargo ?? '-',
                'dependencia' => $invitado->dependenciaCopladep?->nombre ?? $invitado->dependencia ?? '-',
                'municipio' => $registro->catMunicipio?->nombre_municipio ?? 'N/A',
                'modalidad' => ucfirst($registro->modalidad ?? 'N/A'),
                'hora' => $registro->check_in_at->format('d/m/Y H:i'),
            ]);
            // Un pase manual sobre el mismo invitado no identifica a otra persona;
            // no se agrega una fila duplicada cuando existe un ingreso QR.
            if ($invitado->check_in_express && $ingresos->isEmpty()) {
                $filas->push([
                    'tipo' => 'Manual', 'titular' => $invitado->nombre_completo,
                    'nombre' => $invitado->nombre_completo, 'cargo' => $invitado->cargo ?? '-',
                    'dependencia' => $invitado->dependenciaCopladep?->nombre ?? $invitado->dependencia ?? '-',
                    'municipio' => $invitado->municipio?->nombre_municipio ?? 'N/A',
                    'modalidad' => ucfirst($invitado->modalidad ?? 'N/A'), 'hora' => 'Manual (hora no registrada)',
                ]);
            }
            return $filas;
        })->values();
    }

}
