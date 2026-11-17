<?php

namespace App\Http\Controllers;

use App\Models\SesionCopladep;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SesionCopladepController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-listado-registro-copladep');
    }

    public function index()
    {
        $sesiones = SesionCopladep::withCount(['invitados', 'registros'])->orderByDesc('anio')->orderByDesc('numero')->get();

        return view('panel-copladep.sesiones.index', compact('sesiones'));
    }

    public function create()
    {
        return view('panel-copladep.sesiones.form', ['sesion' => new SesionCopladep()]);
    }

    public function store(Request $request)
    {
        $sesion = SesionCopladep::create($this->validated($request));

        return redirect()->route('panel-copladep-sesiones.show', $sesion)->with('success', 'Sesión creada correctamente.');
    }

    public function show(SesionCopladep $sesion)
    {
        $sesion->loadCount(['invitados', 'registros']);
        $metricas = [
            'presenciales' => $sesion->registros()->where('modalidad', 'presencial')->count(),
            'virtuales' => $sesion->registros()->where('modalidad', 'virtual')->count(),
            'checkins' => $sesion->registros()->whereNotNull('check_in_at')->count(),
            'sin_modalidad' => $sesion->registros()->whereNull('modalidad')->count(),
        ];

        return view('panel-copladep.sesiones.show', compact('sesion', 'metricas'));
    }

    public function edit(SesionCopladep $sesion)
    {
        $agendaTexto = self::agendaToText($sesion->agenda ?: []);

        return view('panel-copladep.sesiones.form', compact('sesion', 'agendaTexto'));
    }

    public function update(Request $request, SesionCopladep $sesion)
    {
        $sesion->update($this->validated($request, $sesion));

        return redirect()->route('panel-copladep-sesiones.show', $sesion)->with('success', 'Sesión actualizada correctamente.');
    }

    private function validated(Request $request, ?SesionCopladep $sesion = null): array
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:ordinaria,extraordinaria',
            'numero' => 'nullable|integer|min:1|max:99',
            'anio' => 'required|integer|min:2020|max:2100',
            'descripcion' => 'nullable|string|max:1000',
            'estado' => 'required|in:preparacion,abierta,cerrada,concluida',
            'registro_inicio' => 'nullable|date',
            'registro_fin' => 'nullable|date|after:registro_inicio',
            'fecha_evento' => 'nullable|date',
            'lugar' => 'nullable|string|max:255',
            'enlace_virtual' => 'nullable|url|max:255',
            'ruta_publica' => 'nullable|string|max:255',
            'agenda_texto' => 'nullable|string|max:5000',
        ]);

        if (! $sesion) {
            $base = Str::of($data['anio'] . '-' . ($data['numero'] ? $data['numero'] . '-' : '') . $data['tipo'] . '-' . $data['nombre'])->slug('-')->toString();
            $clave = $base;
            $sufijo = 2;
            while (SesionCopladep::where('clave', $clave)->exists()) {
                $clave = $base . '-' . $sufijo++;
            }
            $data['clave'] = $clave;
        }
        $data['agenda'] = $this->parseAgenda($data['agenda_texto'] ?? '');
        unset($data['agenda_texto']);

        return $data;
    }

    /**
     * Parsea el texto de agenda con indentación a una estructura jerárquica.
     * Las líneas indentadas (con espacios o tabs) se convierten en subpuntos.
     */
    private function parseAgenda(string $texto): array
    {
        $lineas = preg_split('/\r\n|\r|\n/', $texto);
        $resultado = [];

        foreach ($lineas as $linea) {
            $trimmed = trim($linea);
            if ($trimmed === '') {
                continue;
            }

            // Detectar si la línea está indentada (empieza con espacios o tab) o empieza con formato de subpunto (ej: a., a), (a))
            $esSubpunto = preg_match('/^[\t ]{2,}/', $linea)
                || preg_match('/^\t/', $linea)
                || preg_match('/^([a-z]\)|\([a-z]\)|[a-z]\.)\s+/i', $trimmed);

            if ($esSubpunto && count($resultado) > 0) {
                // Agregar como hijo del último punto principal
                $ultimoIndex = count($resultado) - 1;

                // Si el último elemento es un string simple, convertirlo a estructura con hijos
                if (is_string($resultado[$ultimoIndex])) {
                    $resultado[$ultimoIndex] = [
                        'texto' => $resultado[$ultimoIndex],
                        'hijos' => [],
                    ];
                }

                $resultado[$ultimoIndex]['hijos'][] = $trimmed;
            } else {
                $resultado[] = $trimmed;
            }
        }

        return $resultado;
    }

    /**
     * Convierte la estructura jerárquica de agenda de vuelta a texto con indentación.
     */
    public static function agendaToText(array $agenda): string
    {
        $lineas = [];

        foreach ($agenda as $item) {
            if (is_string($item)) {
                $lineas[] = $item;
            } elseif (is_array($item)) {
                $lineas[] = $item['texto'] ?? '';
                foreach ($item['hijos'] ?? [] as $hijo) {
                    $lineas[] = '  ' . $hijo;
                }
            }
        }

        return implode("\n", $lineas);
    }
}
