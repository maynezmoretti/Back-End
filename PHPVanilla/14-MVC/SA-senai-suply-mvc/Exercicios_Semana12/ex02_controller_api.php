<?php
declare(strict_types=1);

namespace App\Exercicios;

use App\Core\Roteador;
use App\Controllers\ProdutoController;

class Ex02ControllerApi
{
    public static function registrar(Roteador $roteador): void
    {
        $controlador = new ProdutoController();

        $roteador->get(
            '/api/produtos',
            [$controlador, 'listarJson']
        );
    }
}
