<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('razao_social', 120);
            $table->string('cnpj', 18)->unique();
            $table->string('email', 100);
            $table->string('telefone', 20);
            $table->string('cidade', 60);
            $table->char('estado', 2);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('fornecedores');
    }
};
