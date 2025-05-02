<?php

namespace App\Http\Controllers;

use App\Models\Partido;
use App\Models\Equipo;
use Illuminate\Http\Request;

class PartidoController extends Controller
{
    /**
     * Mostrar la página principal de gestión de partidos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('partidos.index');
    }
}
