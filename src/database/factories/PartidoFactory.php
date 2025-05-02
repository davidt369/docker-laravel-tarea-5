<?php

namespace Database\Factories;

use App\Models\Equipo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partido>
 */
class PartidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do {
            $local = Equipo::inRandomOrder()->first();
            $visitante = Equipo::inRandomOrder()->first();
        } while ($local && $visitante && $local->id_equipo === $visitante->id_equipo);

        return [
            //
            'id_equipo_local' => $local?->id_equipo ?? Equipo::factory(),
            'id_equipo_visitante' => $visitante?->id_equipo ?? Equipo::factory(),
            'resultado' => $this->faker->numberBetween(0, 5) . ' - ' . $this->faker->numberBetween(0, 5),
        ];
    }
}
