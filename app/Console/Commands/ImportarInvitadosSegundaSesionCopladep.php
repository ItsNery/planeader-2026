<?php

namespace App\Console\Commands;

use App\Models\CatMunicipio;
use App\Models\InvitadoCopladep;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportarInvitadosSegundaSesionCopladep extends Command
{
    protected $signature = 'copladep:importar-segunda-sesion
                            {--archivo= : Ruta absoluta o relativa al archivo XLSX}';

    protected $description = 'Importa o actualiza los invitados de la Segunda Sesión Ordinaria COPLADEP 2026.';

    public function handle(): int
    {
        $ruta = $this->option('archivo') ?: 'public/img/fondos-seccion/segunda-cop-2026/Lista de invitados COPLADEP.xlsx';
        $ruta = is_file($ruta) ? $ruta : base_path($ruta);

        if (!is_file($ruta)) {
            $this->error("No se encontró el archivo: {$ruta}");

            return self::FAILURE;
        }

        $filas = IOFactory::load($ruta)->getActiveSheet()->toArray('', true, true, false);
        $encabezados = $this->encontrarEncabezados($filas);

        if ($encabezados === null) {
            $this->error('No se localizaron las columnas Nombre, Cargo y Dependencia en el archivo.');

            return self::FAILURE;
        }

        $municipioPredeterminado = CatMunicipio::find(114)
            ?? CatMunicipio::where('nombre_municipio', 'Puebla')->orderBy('id')->first();

        if (!$municipioPredeterminado) {
            $this->error('No se encontró el municipio Puebla para los invitados sin municipio específico.');

            return self::FAILURE;
        }

        $municipios = CatMunicipio::all()->keyBy(fn (CatMunicipio $municipio) => $this->normalizar($municipio->nombre_municipio));
        $existentes = InvitadoCopladep::where('sesion', 'segunda')
            ->get()
            ->keyBy(fn (InvitadoCopladep $invitado) => $this->clave($invitado->nombre_completo, $invitado->cargo));
        $vistos = [];
        $creados = 0;
        $actualizados = 0;
        $omitidos = 0;

        DB::transaction(function () use ($filas, $encabezados, $municipios, $municipioPredeterminado, $existentes, &$vistos, &$creados, &$actualizados, &$omitidos) {
            foreach (array_slice($filas, $encabezados['fila'] + 1) as $fila) {
                $nombre = trim((string) ($fila[$encabezados['nombre']] ?? ''));
                $cargo = trim((string) ($fila[$encabezados['cargo']] ?? ''));

                if ($nombre === '' && $cargo === '') {
                    continue;
                }

                $clave = $this->clave($nombre, $cargo);
                if ($nombre === '' || $cargo === '' || isset($vistos[$clave])) {
                    $omitidos++;
                    continue;
                }
                $vistos[$clave] = true;

                $dependencia = trim((string) ($fila[$encabezados['dependencia']] ?? ''));
                $nombreMunicipio = trim((string) ($fila[$encabezados['municipio'] ?? -1] ?? ''));
                $municipio = $municipios->get($this->normalizar($nombreMunicipio)) ?? $municipioPredeterminado;

                if (isset($existentes[$clave])) {
                    if ($existentes[$clave]->dependencia !== ($dependencia ?: null)) {
                        $existentes[$clave]->update(['dependencia' => $dependencia ?: null]);
                        $actualizados++;
                    } else {
                        $omitidos++;
                    }
                    continue;
                }

                InvitadoCopladep::create([
                    'nombre_completo' => Str::limit($nombre, 50, ''),
                    'cargo' => Str::limit($cargo, 191, ''),
                    'dependencia' => $dependencia ?: null,
                    'sexo' => 'Otro',
                    'municipio_id' => $municipio->id,
                    'sesion' => 'segunda',
                ]);
                $creados++;
            }
        });

        $this->info("Importación completada. Creados: {$creados}. Actualizados: {$actualizados}. Omitidos: {$omitidos}.");

        return self::SUCCESS;
    }

    private function encontrarEncabezados(array $filas): ?array
    {
        foreach ($filas as $indice => $fila) {
            $columnas = [];
            foreach ($fila as $columna => $encabezado) {
                $campo = $this->normalizar((string) $encabezado);
                if (in_array($campo, ['nombre', 'nombre_completo'], true)) {
                    $columnas['nombre'] = $columna;
                }
                if ($campo === 'cargo') {
                    $columnas['cargo'] = $columna;
                }
                if ($campo === 'dependencia') {
                    $columnas['dependencia'] = $columna;
                }
                if (in_array($campo, ['municipio', 'municipio_microrregion'], true)) {
                    $columnas['municipio'] = $columna;
                }
            }

            if (isset($columnas['nombre'], $columnas['cargo'], $columnas['dependencia'])) {
                return $columnas + ['fila' => $indice];
            }
        }

        return null;
    }

    private function clave(string $nombre, string $cargo): string
    {
        return $this->normalizar($nombre) . '|' . $this->normalizar($cargo);
    }

    private function normalizar(string $valor): string
    {
        return Str::of($valor)->ascii()->lower()->replaceMatches('/[^a-z0-9]+/', '_')->trim('_')->toString();
    }
}
