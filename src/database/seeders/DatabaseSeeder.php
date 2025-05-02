<?php

namespace Database\Seeders;

use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\Partido;
use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear 600 equipos
        Equipo::factory(36)->create();

        // Crear 600 jugadores
        Jugador::factory(600)->create();

        // Crear 600 partidos (requiere equipos existentes)
        Partido::factory(600)->create();
    }
}
