<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partido;
use Illuminate\Http\Request;

class PartidoController extends Controller
{
    public function index()
    {
        $items = Partido::with(['equipoLocal', 'equipoVisitante'])->get();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $items = Partido::create($request->all());
        // Recargamos el modelo con las relaciones
        $items = Partido::with(['equipoLocal', 'equipoVisitante'])->find($items->id_partido);
        return response()->json($items, 201);
    }

    public function show(string $id)
    {
        $items = Partido::with(['equipoLocal', 'equipoVisitante'])->find($id);
        if (!$items) {
            return response()->json(['message' => ' Partido no encontrado'], 404);
        }
        return response()->json($items);
    }

    public function update(Request $request, string $id)
    {
        $items = Partido::find($id);
        if (!$items) {
            return response()->json(['message' => 'Partido no encontrado'], 404);
        }
        $items->update($request->all());

        // Recargamos el modelo con las relaciones
        $items = Partido::with(['equipoLocal', 'equipoVisitante'])->find($id);
        return response()->json($items, 200);
    }

    public function destroy(string $id)
    {
        $items = Partido::find($id);
        if (!$items) {
            return response()->json(['message' => 'Partido no encontrado'], 404);
        }
        $items->delete();
        return response()->json(['message' => 'Partido eliminado'], 200);
    }
}
