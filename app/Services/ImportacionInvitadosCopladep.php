<?php

namespace App\Services;

use App\Models\CatDependenciaCopladep;
use App\Models\CatMunicipio;
use App\Models\SesionCopladep;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ImportacionInvitadosCopladep
{
    private const HEADERS = ['Nombre completo', 'Sexo', 'Cargo', 'ID dependencia', 'ID municipio', 'Modalidad'];
    private const MAX_ROWS = 1000;

    public function plantilla(): Spreadsheet
    {
        $book = new Spreadsheet();
        $sheet = $book->getActiveSheet()->setTitle('Invitados');
        $sheet->fromArray(self::HEADERS, null, 'A1');
        $sheet->getStyle('A1:F1')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF246257');
        $sheet->freezePane('A2');
        $sheet->setAutoFilter('A1:F1');
        foreach (['A' => 38, 'B' => 16, 'C' => 38, 'D' => 18, 'E' => 18, 'F' => 18] as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }
        foreach (['B' => 'Hombre,Mujer,Otro', 'F' => 'presencial,virtual'] as $column => $options) {
            $validation = new DataValidation();
            $validation->setType(DataValidation::TYPE_LIST)->setErrorStyle(DataValidation::STYLE_STOP)
                ->setAllowBlank($column === 'F')->setShowErrorMessage(true)->setShowDropDown(true)
                ->setErrorTitle('Valor no válido')->setError('Selecciona un valor de la lista.')
                ->setFormula1('"' . $options . '"');
            $sheet->setDataValidation("{$column}2:{$column}" . (self::MAX_ROWS + 1), $validation);
        }

        $instructions = $book->createSheet()->setTitle('Instrucciones');
        $instructions->fromArray([
            ['Carga masiva de invitados'],
            ['1. Llena una fila por persona en la hoja Invitados, sin modificar los encabezados.'],
            ['2. Nombre completo, sexo, cargo e ID de municipio son obligatorios.'],
            ['3. Copia los ID de las hojas de catálogo. La dependencia es opcional.'],
            ['4. Modalidad es opcional: presencial o virtual. Si aún no se define, deja la celda vacía.'],
            ['5. Se aceptan hasta 1000 invitados. No incluyas fórmulas.'],
            ['6. Si hay errores o invitados duplicados, no se guardará ninguna fila. Corrige el archivo y vuelve a cargarlo.'],
            ['7. El nombre admite hasta 50 caracteres y el cargo hasta 191.'],
        ], null, 'A1');
        $instructions->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $instructions->getColumnDimension('A')->setWidth(105);
        $instructions->getStyle('A1:A8')->getAlignment()->setWrapText(true);

        $this->catalogo($book, 'Dependencias', CatDependenciaCopladep::where('activo', true)->orderBy('nombre')->get(['id', 'nombre']), 'nombre');
        $this->catalogo($book, 'Municipios', CatMunicipio::orderBy('nombre_municipio')->orderBy('id')->get(['id', 'nombre_municipio']), 'nombre_municipio');
        $book->setActiveSheetIndex(0);

        return $book;
    }

    private function catalogo(Spreadsheet $book, string $title, $items, string $field): void
    {
        $sheet = $book->createSheet()->setTitle($title);
        $sheet->fromArray(['ID', 'Nombre'], null, 'A1');
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(65);
        $sheet->freezePane('A2');
        foreach ($items as $index => $item) {
            $row = $index + 2;
            $sheet->setCellValue("A{$row}", $item->id);
            $sheet->setCellValueExplicit("B{$row}", $item->{$field}, DataType::TYPE_STRING);
        }
    }

    public function importar(string $path, SesionCopladep $sesion): int
    {
        try {
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $book = $reader->load($path);
        } catch (\Throwable $exception) {
            throw ValidationException::withMessages(['archivo' => 'No se pudo leer el archivo. Utiliza la plantilla XLSX descargada del sistema.']);
        }

        try {
            $sheet = $book->getSheetByName('Invitados');
            if (! $sheet || $sheet->rangeToArray('A1:F1', null, false, false)[0] !== self::HEADERS) {
                throw ValidationException::withMessages(['archivo' => 'No se encontró la hoja Invitados con sus encabezados originales. Descarga la plantilla nuevamente.']);
            }
            if ($sheet->getHighestDataRow() > self::MAX_ROWS + 1 || $sheet->getHighestDataColumn() !== 'F') {
                throw ValidationException::withMessages(['archivo' => 'El archivo debe contener solo las seis columnas de la plantilla y hasta 1000 invitados.']);
            }

            $dependencias = CatDependenciaCopladep::where('activo', true)->pluck('id')->map(fn ($id) => (string) $id)->all();
            $municipios = CatMunicipio::pluck('id')->map(fn ($id) => (string) $id)->all();
            $existing = $sesion->invitados()->get(['nombre_completo', 'cargo'])->mapWithKeys(fn ($item) => [$this->clave($item->nombre_completo, $item->cargo) => true])->all();
            $seen = [];
            $rows = [];
            $errors = [];
            for ($row = 2; $row <= $sheet->getHighestDataRow(); $row++) {
                $values = [];
                foreach (range('A', 'F') as $column) {
                    $cell = $sheet->getCell("{$column}{$row}");
                    if ($cell->getDataType() === DataType::TYPE_FORMULA) {
                        $errors[] = "Fila {$row}: no se permiten fórmulas.";
                    }
                    $values[] = trim((string) $cell->getValue());
                }
                if (count(array_filter($values, fn ($value) => $value !== '')) === 0) continue;
                [$nombre, $sexo, $cargo, $dependencia, $municipio, $modalidad] = $values;
                if ($nombre === '' || mb_strlen($nombre) > 50) $errors[] = "Fila {$row}: el nombre es obligatorio y admite hasta 50 caracteres.";
                if ($cargo === '' || mb_strlen($cargo) > 191) $errors[] = "Fila {$row}: el cargo es obligatorio y admite hasta 191 caracteres.";
                if (! in_array($sexo, ['Hombre', 'Mujer', 'Otro'], true)) $errors[] = "Fila {$row}: selecciona Hombre, Mujer u Otro en sexo.";
                if ($dependencia !== '' && ! in_array($dependencia, $dependencias, true)) $errors[] = "Fila {$row}: el ID de dependencia no corresponde a una dependencia activa.";
                if ($municipio === '' || ! in_array($municipio, $municipios, true)) $errors[] = "Fila {$row}: selecciona un ID de municipio del catálogo.";
                if ($modalidad !== '' && ! in_array($modalidad, ['presencial', 'virtual'], true)) $errors[] = "Fila {$row}: la modalidad debe ser presencial, virtual o quedar vacía.";
                if ($nombre !== '' && $cargo !== '') {
                    $key = $this->clave($nombre, $cargo);
                    if (isset($existing[$key]) || isset($seen[$key])) $errors[] = "Fila {$row}: ya existe una persona con el mismo nombre y cargo en esta sesión o en el archivo.";
                    $seen[$key] = true;
                }
                $rows[] = ['nombre_completo' => $nombre, 'sexo' => $sexo, 'cargo' => $cargo,
                    'dependencia_id' => $dependencia !== '' ? (int) $dependencia : null,
                    'municipio_id' => $municipio !== '' ? (int) $municipio : null,
                    'modalidad' => $modalidad !== '' ? $modalidad : null,
                    'sesion' => $sesion->numero === 2 ? 'segunda' : 'primera'];
                if (count($errors) >= 100) {
                    $errors[] = 'Se muestran los primeros errores. Corrige el archivo y vuelve a intentarlo.';
                    break;
                }
            }
            if (! $rows && ! $errors) $errors[] = 'La hoja Invitados no contiene filas para importar.';
            if ($errors) throw ValidationException::withMessages(['archivo' => $errors]);

            DB::transaction(function () use ($sesion, $rows) {
                foreach ($rows as $row) $sesion->invitados()->create($row);
            });

            return count($rows);
        } finally {
            $book->disconnectWorksheets();
        }
    }

    private function clave(string $nombre, string $cargo): string
    {
        return Str::of($nombre . '|' . $cargo)->ascii()->lower()->replaceMatches('/\s+/', ' ')->trim()->toString();
    }
}
