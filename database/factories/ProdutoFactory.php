<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nome' => fake()->firstName(),
            'cod_barras' => fake()->unique()->numerify('####################'),
            'valor_unitario' => fake()->unique()->randomFloat(2, 1, 100),
        ];
    }
}
