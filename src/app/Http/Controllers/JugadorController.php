<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JugadorController extends Controller
{
    /**
     * Mostrar la página principal de gestión de jugadores
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jugadores.index');
    }
}
