<?php
declare(strict_types=1);

namespace App\Exercicios;

use App\Core\Roteador;
use App\Controllers\ProdutoController;

class Ex05FiltroCatalogo
{
    public static function registrar(Roteador $roteador): void
    {
        $controlador = new ProdutoController();

        $roteador->get(
            '/produtos',
            [$controlador, 'listarPorCategoria']
        );
    }
}
