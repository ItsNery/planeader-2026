<?php

namespace App\Services;

use App\Models\RegistroCopladep;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;

class CopladepQrService
{
    public function token(): string { return bin2hex(random_bytes(32)); }

    public function payload(RegistroCopladep $registro): string
    {
        $sesion = $registro->sesionCopladep;
        $anio = $sesion?->anio ?? 2026;
        $clave = $sesion?->clave ?? $registro->sesion;

        return "COPLADEP" . substr((string) $anio, -2) . ":{$clave}:{$registro->token_qr}";
    }

    public function ensureStored(RegistroCopladep $registro): string
    {
        if ($registro->qr_path && Storage::disk('local')->exists($registro->qr_path)) return $registro->qr_path;

        $sesion = $registro->sesionCopladep;
        $path = 'qr-copladep/' . ($sesion?->clave ?? $registro->sesion) . "/{$registro->token_qr}.png";
        $qr = new QrCode(data: $this->payload($registro), encoding: new Encoding('UTF-8'), errorCorrectionLevel: ErrorCorrectionLevel::High, size: 500, margin: 20);
        Storage::disk('local')->put($path, (new PngWriter())->write($qr)->getString());
        $registro->forceFill(['qr_path' => $path])->saveQuietly();
        return $path;
    }
}
