<?php
declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;

final class DatabaseSeeder extends Seeder {
    /**
     * Executa a orquestracao da carga de dados da aplicacao.
     */
    public function run(): void {
        // 1. Cria as categorias da loja primeiro
        $this->call(CategoriaSeeder::class);

        // 2. Cria os fornecedores e distribuidores
        $this->call(FornecedorSeeder::class);

        // 3. Cria 100 produtos de informatica associados
        Produto::factory()->count(100)->create();
    }
}
