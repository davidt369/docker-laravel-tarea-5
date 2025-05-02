<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jugador>
 */
class JugadorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nombre' => $this->faker->name,
            'puesto' => $this->faker->randomElement([
                'Portero',
                'Defensa central',
                'Lateral izquierdo',
                'Lateral derecho',
                'Carrilero izquierdo',
                'Carrilero derecho',
                'Mediocentro defensivo',
                'Mediocentro ofensivo',
                'Interior izquierdo',
                'Interior derecho',
                'Extremo izquierdo',
                'Extremo derecho',
                'Delantero centro',
                'Segundo delantero',
                'Media punta'
            ]),
            'pierna' => $this->faker->randomElement(['Izquierda', 'Derecha', 'Ambas']),
        ];
    }
}
