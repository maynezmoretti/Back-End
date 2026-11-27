<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Fornecedor;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ProdutoFactory extends Factory {
    protected $model = Produto::class;

    public function definition(): array {
        $prefixos = [
            'Processador Ryzen', 'Placa de Vídeo RTX', 'SSD NVMe M.2',
            'Memória RAM DDR5', 'Monitor Gamer', 'Teclado Mecânico'
        ];
        $complementos = [
            '5 7600X 4.7GHz', '4060 Ti 8GB GDDR6', '1TB PCIe 4.0',
            '16GB 5600MHz', '27" 144Hz IPS', 'RGB Switch Red'
        ];

        $nome = fake()->randomElement($prefixos) . ' ' . fake()->randomElement($complementos);

        return [
            'categoria_id'   => Categoria::inRandomOrder()->first()?->id ?? Categoria::factory(),
            'fornecedor_id'  => Fornecedor::inRandomOrder()->first()?->id ?? Fornecedor::factory(),
            'sku'            => 'TEC-' . fake()->unique()->numerify('#####'),
            'nome'           => $nome,
            'descricao'      => fake()->paragraph(2),
            'preco'          => fake()->randomFloat(2, 89, 6500),
            'estoque'        => fake()->numberBetween(0, 150),
            'unidade_medida' => fake()->randomElement(['UN', 'KIT', 'CX']),
            'ativo'          => true
        ];
    }
}
