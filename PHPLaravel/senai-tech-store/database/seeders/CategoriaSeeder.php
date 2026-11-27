<?php
declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use Illuminate\Support\Str;

final class CategoriaSeeder extends Seeder {
    public function run(): void {
        $categorias = [
            'Processadores', 'Placas de Vídeo', 'Memórias RAM',
            'Armazenamento SSD', 'Periféricos', 'Monitores'
        ];

        foreach ($categorias as $cat) {
            Categoria::firstOrCreate(['nome' => $cat], [
                'slug'      => Str::slug($cat),
                'descricao' => "Produtos e componentes de informática da linha {$cat}.",
                'ativo'     => true
            ]);
        }
    }
}
