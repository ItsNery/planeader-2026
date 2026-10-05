<?php

namespace App\Services;

use App\Models\PushSubscription;
use Illuminate\Support\Facades\Log;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class WebPushService
{
    public function enviar(PushSubscription $suscripcion, array $mensaje): void
    {
        $configuracion = config('services.web_push');
        if (empty($configuracion['public_key']) || empty($configuracion['private_key']) || empty($configuracion['subject'])) {
            Log::warning('Web Push omitido: faltan variables VAPID.');
            return;
        }

        $webPush = new WebPush(['VAPID' => [
            'subject' => $configuracion['subject'],
            'publicKey' => $configuracion['public_key'],
            'privateKey' => $configuracion['private_key'],
        ]]);

        try {
            $reporte = $webPush->sendOneNotification(Subscription::create([
                'endpoint' => $suscripcion->endpoint,
                'publicKey' => $suscripcion->public_key,
                'authToken' => $suscripcion->auth_token,
                'contentEncoding' => $suscripcion->content_encoding,
            ]), json_encode($mensaje, JSON_UNESCAPED_UNICODE));

            if (!$reporte->isSuccess() && in_array($reporte->getResponse()?->getStatusCode(), [404, 410], true)) {
                $suscripcion->delete();
            }
        } catch (\Throwable $exception) {
            Log::warning('No fue posible enviar Web Push.', ['subscription_id' => $suscripcion->id, 'exception' => $exception->getMessage()]);
        }
    }
}
