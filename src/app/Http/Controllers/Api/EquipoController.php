<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    {
        $items = Equipo::all();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $items = Equipo::create($request->all());
        return response()->json($items, 201);
    }

    public function show(string $id)
    {
        $items = Equipo::find($id);
        if (!$items) {
            return response()->json(['message' => 'Equipo no encontrado', 404]);
        }
        return response()->json($items);
    }

    public function update(Request $request, string $id)
    {
        $items = Equipo::find($id);
        if (!$items) {
            return response()->json(['message' => 'Equipo no encontrado '], 404);
        }
        $items->update($request->all());
        return response()->json($items, 200);
    }

    public function destroy(string $id)
    {
        $items = Equipo::find($id);
        if (!$items) {
            return response()->json(['message' => 'Equipo no encontrado'], 404);
        }
        $items->delete();
        return response()->json(['message' => 'Equipo eliminado'], 200);
    }
}
