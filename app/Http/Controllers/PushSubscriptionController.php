<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use Illuminate\Http\Request;

class PushSubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-agenda-evento|editar-agenda-evento');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'endpoint' => ['required', 'url', 'max:4096'],
            'keys.p256dh' => ['required', 'string', 'max:512'],
            'keys.auth' => ['required', 'string', 'max:512'],
        ]);

        PushSubscription::updateOrCreate(
            ['endpoint_hash' => hash('sha256', $data['endpoint'])],
            [
                'user_id' => $request->user()->id,
                'endpoint' => $data['endpoint'],
                'public_key' => $data['keys']['p256dh'],
                'auth_token' => $data['keys']['auth'],
                'content_encoding' => 'aes128gcm',
            ]
        );

        return response()->json(['message' => 'Notificaciones activadas.']);
    }

    public function destroy(Request $request, PushSubscription $pushSubscription)
    {
        abort_unless($pushSubscription->user_id === $request->user()->id, 403);
        $pushSubscription->delete();

        return response()->noContent();
    }
}
