<?php

namespace App\Services;

use App\Models\RegistroCopladep;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function imagen(RegistroCopladep $registro): string
    {
        $qr = new QrCode(data: $this->payload($registro), encoding: new Encoding('UTF-8'), errorCorrectionLevel: ErrorCorrectionLevel::High, size: 500, margin: 20);
        return (new PngWriter())->write($qr)->getString();
    }

    public function respaldar(RegistroCopladep $registro, ?string $imagen = null): bool
    {
        try {
            $disk = Storage::disk('local');
            if ($registro->qr_path && $disk->exists($registro->qr_path)) {
                return true;
            }

            $sesion = Str::slug($registro->sesionCopladep?->clave ?: $registro->sesion);
            $path = 'qr-copladep/' . $sesion . '/' . $registro->token_qr . '.png';
            if (! $disk->put($path, $imagen ?? $this->imagen($registro))) {
                throw new \RuntimeException('No se pudo escribir el archivo QR.');
            }

            $registro->forceFill(['qr_path' => $path])->saveQuietly();
            return true;
        } catch (\Throwable $exception) {
            Log::warning('No se pudo respaldar el QR del registro COPLADEP.', [
                'registro_id' => $registro->id,
                'error' => $exception->getMessage(),
            ]);
            return false;
        }
    }
}
