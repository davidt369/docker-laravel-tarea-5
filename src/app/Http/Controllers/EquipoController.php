<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipoController extends Controller
{
    /**
     * Mostrar la página principal de gestión de equipos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('equipos.index');
    }
}
