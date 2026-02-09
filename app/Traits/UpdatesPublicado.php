<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait UpdatesPublicado
{
    public function updatePublicado(Request $request, $id)
    {
        $request->validate([
            'publicado' => 'required|boolean',
        ]);

        $documento = $this->getModel()::findOrFail($id);
        $documento->publicado = $request->input('publicado');
        $documento->save();

        return redirect()->back()->with('success', 'Estado de publicación actualizado');
    }

    abstract protected function getModel();
}
