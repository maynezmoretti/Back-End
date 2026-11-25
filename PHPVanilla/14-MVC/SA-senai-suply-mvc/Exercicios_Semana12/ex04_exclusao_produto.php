<?php
declare(strict_types=1);

namespace App\Exercicios;

use App\Core\Roteador;
use App\Controllers\ProdutoController;

class Ex04ExclusaoProduto
{
    public static function registrar(Roteador $roteador): void
    {
        $controlador = new ProdutoController();

        $roteador->post(
            '/produtos/excluir',
            [$controlador, 'excluir']
        );
    }
}
