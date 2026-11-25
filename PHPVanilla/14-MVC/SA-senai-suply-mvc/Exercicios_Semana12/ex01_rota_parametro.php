<?php
declare(strict_types=1);

namespace App\Exercicios;

use App\Core\Roteador;
use App\Controllers\ProdutoController;

class Ex01RotaParametro
{
    public static function registrar(Roteador $roteador): void
    {
        $controlador = new ProdutoController();

        $roteador->get(
            '/produtos/detalhe/{id}',
            function (string $id) use ($controlador): void {
                $controlador->detalhar((int) $id);
            }
        );

        $roteador->get(
            '/produtos/{id}',
            function (string $id) use ($controlador): void {
                $controlador->detalhar((int) $id);
            }
        );
    }
}
