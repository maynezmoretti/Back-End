<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Movimentacao;
use App\Models\Produto;

final class HomeController extends Controller {

    // Método da página index
    public function index(): void {
        $totalInsumos = Produto::totalInsumos();
        $totalEstoque = Produto::totalEstoque();
        $ultimasMovimentacoes = Movimentacao::listarHistorico(5);

        // Renderizar a tela
        $this->renderizar('home/index', [
            "título"        => "Painel de controle de almoxarifado",
            "totalInsumos"  => $totalInsumos,
            "totalEstoque"  => $totalEstoque,
            "ultimasMovimentacoes"  => $ultimasMovimentacoes
        ]);
    }
}