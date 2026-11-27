<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

final class CategoriaFactory extends Factory {
    protected $model = Categoria::class;

    public function definition(): array {
        $nome = fake()->unique()->randomElement([
            'Processadores (CPU)', 'Placas de Vídeo (GPU)', 'Memórias RAM',
            'Armazenamento SSD/NVMe', 'Placas-Mãe', 'Periféricos Gamer',
            'Monitores e Telas', 'Fontes e Gabinetes', 'Redes e Conectividade'
        ]);

        return [
            'nome'      => $nome,
            'slug'      => Str::slug($nome),
            'descricao' => fake()->sentence(8),
            'ativo'     => true
        ];
    }
}
