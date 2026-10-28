<?php

namespace App\Http\Controllers;

use App\Models\CatMunicipio;
use App\Models\InvitadoCopladep;
use App\Models\RegistroCopladep;
use App\Models\SesionCopladep;
use App\Services\CopladepQrService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;

class RegistroCopladepController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-listado-registro-copladep', ['only' => ['index', 'scanner', 'checkin']]);
    }

    public function index(SesionCopladep $sesion)
    {
        $registros = $sesion->registros()->with('catMunicipio', 'invitado.dependenciaCopladep')->orderByDesc('created_at')->get();

        return view('panel-copladep.registros.index', compact('registros', 'sesion'));
    }

    public function create(SesionCopladep $sesion)
    {
        $municipios = CatMunicipio::select('nombre_municipio')->selectRaw('MIN(id) as id')->whereIn('id', [3, 4, 10, 15, 19, 45, 47, 53, 39, 71, 74, 85, 94, 114, 132, 140, 154, 156, 164, 169, 174, 186, 197, 207])->groupBy('nombre_municipio')->orderBy('nombre_municipio')->get();
        $invitados = $sesion->invitados()->with(['municipio', 'dependenciaCopladep'])->orderBy('nombre_completo')->get();

        return view('panel-copladep.registros.form', compact('municipios', 'invitados', 'sesion'));
    }

    public function store(Request $request, SesionCopladep $sesion)
    {
        $now = Carbon::now(config('app.timezone'));
        if (! $sesion->registro_inicio || ! $sesion->registro_fin || ! $now->between($sesion->registro_inicio, $sesion->registro_fin)) {
            return redirect()->route('copladep-sesiones.registro.create', $sesion)
                ->withErrors(['error' => 'El registro no está disponible para esta sesión.'])
                ->withInput();
        }

        $validator = Validator::make($request->all(), [
            'tipo_asistente' => 'required|string|in:titular,representante',
            'invitado_id' => ['required', 'integer', Rule::exists('invitado_copladeps', 'id')->where('sesion_copladep_id', $sesion->id)],
            'nombre_completo' => 'required|string|max:50',
            'sexo' => 'required|string|in:Hombre,Mujer,Otro',
            'cargo' => 'required|string|max:191',
            'municipio_id' => 'required|integer|exists:cat_municipios,id',
            'correo_electronico' => 'required|string|email|max:50',
            'telefono_oficina' => 'nullable|string|max:20|regex:/^[0-9\s\-\+\(\)]*$/',
            'telefono_celular' => 'required|string|max:20|regex:/^[0-9\s\-\+\(\)]*$/',
            'firma' => 'nullable|string',
        ], [
            'required' => 'Completa el campo :attribute.',
            'in' => 'Selecciona una opción válida para :attribute.',
            'exists' => 'Selecciona una opción válida para :attribute.',
            'email' => 'Escribe un correo electrónico válido, por ejemplo nombre@dominio.com.',
            'max' => 'El campo :attribute no debe exceder :max caracteres.',
            'telefono_oficina.regex' => 'El teléfono de oficina solo puede contener números, espacios, paréntesis, guiones y el signo +.',
            'telefono_celular.regex' => 'El teléfono celular solo puede contener números, espacios, paréntesis, guiones y el signo +.',
        ], [
            'tipo_asistente' => 'tipo de asistente',
            'invitado_id' => 'persona invitada',
            'nombre_completo' => 'nombre del asistente',
            'sexo' => 'sexo',
            'cargo' => 'cargo',
            'municipio_id' => 'municipio',
            'correo_electronico' => 'correo electrónico',
            'telefono_oficina' => 'teléfono de oficina',
            'telefono_celular' => 'teléfono celular',
        ]);

        $validator->after(function ($validator) use ($sesion) {
            $data = $validator->getData();
            foreach (['nombre_completo', 'correo_electronico'] as $campo) {
                if (! empty($data[$campo]) && $sesion->registros()->where($campo, $data[$campo])->exists()) {
                    $validator->errors()->add($campo, $campo === 'correo_electronico' ? 'Este correo electrónico ya ha sido registrado en esta sesión.' : 'Este nombre ya ha sido registrado en esta sesión.');
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->route('copladep-sesiones.registro.create', $sesion)->withErrors($validator)->withInput();
        }

        try {
            $datos = $validator->validated();
            $invitado = $sesion->invitados()->findOrFail($datos['invitado_id']);
            $datos['sesion'] = $sesion->numero === 2 ? 'segunda' : 'primera';
            $datos['sesion_copladep_id'] = $sesion->id;
            $datos['modalidad'] = $invitado->modalidad;
            if ($datos['modalidad'] === 'presencial') {
                $datos['token_qr'] = app(CopladepQrService::class)->token();
            }
            $registro = RegistroCopladep::create($datos);

            if (! $registro->modalidad) {
                return redirect()->route('copladep-sesiones.registro.create', $sesion)
                    ->with('success', '¡Te has registrado exitosamente a la sesión del COPLADEP!')
                    ->with('warning', 'No se generó el PDF porque aún falta definir tu modalidad de asistencia.');
            }

            if ($registro->modalidad === 'presencial') {
                app(CopladepQrService::class)->ensureStored($registro);
            }

            return redirect()->route('copladep-registro.confirmacion', $registro->token_qr ?: $registro->id)
                ->with('success', '¡Tu registro y documento de asistencia están listos!');
        } catch (\Exception $e) {
            Log::error('Error al guardar el registro COPLADEP: ' . $e->getMessage());

            return redirect()->route('copladep-sesiones.registro.create', $sesion)
                ->withErrors(['db_error' => 'Ocurrió un error inesperado al procesar tu registro.'])
                ->withInput();
        }
    }

    public function confirmacion(string $identificador)
    {
        $registro = RegistroCopladep::with('sesionCopladep')->where('token_qr', $identificador)->orWhere('id', $identificador)->firstOrFail();
        abort_unless($registro->modalidad, 404);

        return view('copladep-registro-confirmacion', compact('registro'));
    }

    public function descargarPdf(string $identificador)
    {
        $registro = RegistroCopladep::with('sesionCopladep')->where('token_qr', $identificador)->orWhere('id', $identificador)->firstOrFail();
        abort_unless($registro->modalidad && $registro->sesionCopladep, 404);
        $evento = $this->evento($registro->sesionCopladep, $registro->modalidad);
        $qrDataUri = null;
        if ($registro->modalidad === 'presencial') {
            $path = app(CopladepQrService::class)->ensureStored($registro);
            $qrDataUri = 'data:image/png;base64,' . base64_encode(Storage::disk('local')->get($path));
        }
        if ($registro->sesionCopladep->clave === '2026-segunda-ordinaria') {
            return response($this->convocatoriaSegundaSesion($registro, $path ?? null), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="COPLADEP-' . $registro->id . '.pdf"',
            ]);
        }
        $ticket = Pdf::loadView('pdf.copladep-ticket', compact('registro', 'evento', 'qrDataUri'))->setPaper([0, 0, 226.77, 425.2])->output();
        $informacion = Pdf::loadView('pdf.copladep-informacion', compact('registro', 'evento'))->setPaper('letter')->output();
        $merged = new Fpdi();
        foreach ([$ticket, $informacion] as $documento) {
            $pages = $merged->setSourceFile(StreamReader::createByString($documento));
            for ($page = 1; $page <= $pages; $page++) {
                $template = $merged->importPage($page);
                $size = $merged->getTemplateSize($template);
                $merged->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $merged->useTemplate($template);
            }
        }

        return response($merged->Output('S'), 200, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'attachment; filename="COPLADEP-' . $registro->id . '.pdf"']);
    }

    public function scanner(SesionCopladep $sesion)
    {
        return view('panel-copladep.check-in.scanner', compact('sesion'));
    }

    public function checkin(Request $request, SesionCopladep $sesion)
    {
        $data = $request->validate(['token' => 'required|string']);
        $token = preg_replace('/^COPLADEP\d{2}:[^:]+:/', '', trim($data['token']));
        $registro = $sesion->registros()->where('token_qr', $token)->first();
        if (! $registro) return response()->json(['message' => 'Código QR no válido.'], 404);
        if ($registro->modalidad !== 'presencial') return response()->json(['message' => 'Este registro no corresponde a asistencia presencial.'], 422);
        if ($registro->check_in_at) return response()->json(['message' => 'El ingreso ya fue registrado a las ' . $registro->check_in_at->format('H:i') . '.'], 422);
        $registro->update(['check_in_at' => now()]);

        return response()->json(['message' => 'Check-in registrado para ' . $registro->nombre_completo . '.']);
    }

    public function legacyCreate(string $clave)
    {
        return $this->create(SesionCopladep::where('clave', $clave)->firstOrFail());
    }

    public function legacyStore(Request $request, string $clave)
    {
        return $this->store($request, SesionCopladep::where('clave', $clave)->firstOrFail());
    }

    public function legacyIndex(string $clave)
    {
        return $this->index(SesionCopladep::where('clave', $clave)->firstOrFail());
    }

    public function legacyScanner(string $sesion)
    {
        return $this->scanner(SesionCopladep::where('clave', '2026-' . $sesion . '-ordinaria')->firstOrFail());
    }

    private function evento(SesionCopladep $sesion, ?string $modalidad = null): array
    {
        return [
            'nombre' => $sesion->nombre . ' de la Asamblea Plenaria del COPLADEP',
            'fecha' => optional($sesion->fecha_evento)->format('d/m/Y'),
            'hora' => optional($sesion->fecha_evento)->format('H:i') . ' horas',
            'lugar' => $modalidad === 'virtual' ? 'Sesión Virtual | Transmisión por Google Meet' : $sesion->lugar,
            'enlace_virtual' => $sesion->enlace_virtual,
            'agenda' => $sesion->agenda ?: [],
        ];
    }

    private function convocatoriaSegundaSesion(RegistroCopladep $registro, ?string $qrPath): string
    {
        $esPresencial = $registro->modalidad === 'presencial';
        $plantilla = public_path('sesiones-copladep/segunda-2026/' . ($esPresencial ? 'CONVOC_2.PDF' : 'CONVOC_1.PDF'));
        abort_unless(is_file($plantilla), 500, 'No se encontró la plantilla de convocatoria.');

        $pdf = new Fpdi();
        $paginas = $pdf->setSourceFile($plantilla);

        for ($pagina = 1; $pagina <= $paginas; $pagina++) {
            $template = $pdf->importPage($pagina);
            $tamano = $pdf->getTemplateSize($template);
            $pdf->AddPage($tamano['orientation'], [$tamano['width'], $tamano['height']]);
            $pdf->useTemplate($template);

            if ($pagina !== 1) {
                continue;
            }

            if ($esPresencial && $qrPath) {
                $ladoQr = min(72, $tamano['width'] * 0.27);
                $pdf->Image(Storage::disk('local')->path($qrPath), ($tamano['width'] - $ladoQr) / 2, $tamano['height'] * 0.385, $ladoQr, $ladoQr, 'PNG');
                continue;
            }

            $liga = $registro->sesionCopladep->enlace_virtual;
            $texto = $liga ?: 'La liga de transmisión se compartirá próximamente.';
            $x = $tamano['width'] * 0.16;
            $y = $tamano['height'] * 0.385;
            $ancho = $tamano['width'] * 0.68;
            $pdf->SetXY($x, $y);
            $pdf->SetFont('Helvetica', $liga ? 'U' : '', 12);
            $pdf->SetTextColor(22, 91, 82);
            $pdf->MultiCell($ancho, 7, $this->pdfText($texto), 0, 'C');
            if ($liga) {
                $pdf->Link($x, $y, $ancho, 28, $liga);
            }
        }

        return $pdf->Output('S');
    }

    private function pdfText(string $texto): string
    {
        return iconv('UTF-8', 'Windows-1252//TRANSLIT', $texto) ?: $texto;
    }
}
