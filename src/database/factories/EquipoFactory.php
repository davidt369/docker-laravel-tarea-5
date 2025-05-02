<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipo>
 */
class EquipoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->randomElement([
                'Real Madrid',
                'FC Barcelona',
                'Atlético de Madrid',
                'Sevilla FC',
                'Real Sociedad',
                'Manchester City',
                'Liverpool',
                'Chelsea',
                'Manchester United',
                'Arsenal',
                'Tottenham Hotspur',
                'Juventus',
                'Inter de Milán',
                'AC Milan',
                'Napoli',
                'AS Roma',
                'Lazio',
                'Bayern Múnich',
                'Borussia Dortmund',
                'RB Leipzig',
                'Bayer Leverkusen',
                'Wolfsburg',
                'Paris Saint-Germain',
                'Olympique de Marsella',
                'Lyon',
                'Monaco',
                'Lille',
                'Boca Juniors',
                'River Plate',
                'Palmeiras',
                'Flamengo',
                'Atlético Mineiro',
                'Gremio',
                'São Paulo',
                'Corinthians',
                'Colo-Colo',
                'Atlético Nacional',
                'Independiente del Valle',
            ]),
            'colores' => $this->faker->safeColorName() . ' y ' . $this->faker->safeColorName(),
        ];
    }
}
