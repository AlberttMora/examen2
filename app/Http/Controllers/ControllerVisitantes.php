<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lista;

class ControllerVisitantes extends Controller
{
    public function show($token)
    {
        // Carga dueño (relación user() de Lista) e ítems de una vez.
        // firstOrFail() => 404 si el token no existe (manejo de tokens incorrectos).
        $lista = Lista::with(['user', 'items'])
            ->where('token', $token)
            ->firstOrFail();

        return view('visitantes.show', compact('lista'));
    }

    // POST /{token}/items/{id}: marcar/desmarcar un ítem (lo llama fetch en publica.js)
    public function update(Request $request, $token, $id)
    {
        $lista = Lista::where('token', $token)->firstOrFail();

        // Busca el ítem A TRAVÉS de la lista: si es de otra lista, da 404
        $item = $lista->items()->where('id_item', $id)->firstOrFail();

        // boolean() convierte true/false/1/0 del JSON de forma segura
        $item->completado = $request->boolean('completado') ? 1 : 0;
        $item->save();

        // Totales DESPUÉS de guardar, para que reflejen el cambio
        $total = $lista->items()->count();
        $completados = $lista->items()->where('completado', 1)->count();
        $porcentaje = $total > 0 ? (int) round(($completados / $total) * 100) : 0;

        return response()->json([
            'completados' => $completados,
            'total' => $total,
            'porcentaje' => $porcentaje,
        ]);
    }
}
