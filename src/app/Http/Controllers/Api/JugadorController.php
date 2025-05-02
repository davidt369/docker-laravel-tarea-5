<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jugador;
use Illuminate\Http\Request;

class JugadorController extends Controller
{
    public function index()
    {

        $items = Jugador::all();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $items = Jugador::create($request->all());
        return response()->json($items, 201);
    }

    public function show(string $id)
    {
        $items = Jugador::find($id);
        if (!$items) {
            return response()->json(['message' => 'Jugador no encontrado'], 404);
        }
        return response()->json($items);
    }

    public function update(Request $request, string $id)
    {
        $items = Jugador::find($id);
        if (!$items) {
            return response()->json(['message' => 'Jugador no encontrado'], 404);
        }
        $items->update($request->all());
        return response()->json($items, 200);
    }

    public function destroy(string $id)
    {
        $items = Jugador::find($id);
        if (!$items) {
            return response()->json(['message' => 'Jugador no encontrado'], 404);
        }
        $items->delete();
        return response()->json(['message' => 'Jugador eliminado'], 204);
    }
}
