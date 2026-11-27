<?php
declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fornecedor;

final class FornecedorSeeder extends Seeder {
    public function run(): void {
        Fornecedor::factory()->count(10)->create();
    }
}
