<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ativos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_patrimonio')->unique();
            $table->string('nome');
            $table->string('setor');
            $table->string('status');
            $table->decimal('tensao_operacao', 8, 2);
            $table->unsignedInteger('horas_trabalhadas')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ativos');
    }
};