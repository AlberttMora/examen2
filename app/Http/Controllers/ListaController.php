<?php

namespace App\Http\Controllers;

use App\Models\Lista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ListaController extends Controller
{
    // Solo las listas del usuario logueado
    public function index()
    {
        $listas = Auth::user()->listas()->get();
        return view('listas.index', compact('listas'));
    }

    public function create()
    {
        return view('listas.create');
    }

    // Maestro-detalle en UNA transacción
    public function store(Request $request)
    {
        $request->validate([
            'titulo'  => 'required|string|max:255',
            'items'   => 'required|array|min:1',
            'items.*' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $lista = Lista::create([
                'id_usuario' => Auth::id(),
                'titulo'     => $request->titulo,
                'token'      => $this->generarToken(),
            ]);

            // Usa el id_lista recién creado
            foreach ($request->items as $descripcion) {
                $lista->items()->create(['descripcion' => $descripcion]);
            }
        });

        return redirect()->route('listas.index');
    }

    public function edit($id)
    {
        // 404 si la lista no es del usuario
        $lista = Auth::user()->listas()->with('items')->findOrFail($id);
        return view('listas.edit', compact('lista'));
    }

    public function update(Request $request, $id)
    {
        $lista = Auth::user()->listas()->findOrFail($id);

        $request->validate([
            'titulo'    => 'required|string|max:255',
            'items'     => 'nullable|array',
            'items.*'   => 'required|string|max:255',
            'nuevos'    => 'nullable|array',
            'nuevos.*'  => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $lista) {
            $lista->update(['titulo' => $request->titulo]);

            $existentes = $request->input('items', []); // [id_item => descripcion]

            // Borra los ítems que ya no vienen en el formulario
            $lista->items()->whereNotIn('id_item', array_keys($existentes))->delete();

            // Actualiza los existentes (sin tocar "completado")
            foreach ($existentes as $idItem => $descripcion) {
                $lista->items()->where('id_item', $idItem)
                    ->update(['descripcion' => $descripcion]);
            }

            // Crea los nuevos
            foreach ($request->input('nuevos', []) as $descripcion) {
                $lista->items()->create(['descripcion' => $descripcion]);
            }
        });

        return redirect()->route('listas.index');
    }

    public function destroy($id)
    {
        $lista = Auth::user()->listas()->findOrFail($id);
        $lista->delete(); // los ítems se borran por ON DELETE CASCADE

        return redirect()->route('listas.index');
    }

    // Token alfanumérico de 20 caracteres, único
    private function generarToken(): string
    {
        do {
            $token = Str::random(20);
        } while (Lista::where('token', $token)->exists());

        return $token;
    }
}
