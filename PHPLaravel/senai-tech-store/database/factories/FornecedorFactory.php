<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Fornecedor;
use Illuminate\Database\Eloquent\Factories\Factory;

final class FornecedorFactory extends Factory {
    protected $model = Fornecedor::class;

    public function definition(): array {
        return [
            'razao_social' => fake()->company() . ' ' . fake()->companySuffix(),
            'cnpj'         => fake()->unique()->numerify('##.###.###/0001-##'),
            'email'        => fake()->companyEmail(),
            'telefone'     => fake()->phoneNumber(),
            'cidade'       => fake()->city(),
            'estado'       => fake()->stateAbbr()
        ];
    }
}
