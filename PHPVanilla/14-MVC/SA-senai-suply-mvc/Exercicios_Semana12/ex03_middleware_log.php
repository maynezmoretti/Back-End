<?php
declare(strict_types=1);

namespace App\Exercicios;

use App\Core\Roteador;

class Ex03MiddlewareLog
{
    public static function registrar(Roteador $roteador): void
    {
        $roteador->adicionarMiddleware(
            [self::class, 'registrarAcesso']
        );
    }

    public static function registrarAcesso(): void
    {
        $arquivo = __DIR__ . '/logs/acessos.log';

        $registro = sprintf(
            "[%s] IP: %s | Método: %s | URI: %s\n",
            date('d/m/Y H:i:s'),
            $_SERVER['REMOTE_ADDR'] ?? 'Desconhecido',
            $_SERVER['REQUEST_METHOD'] ?? 'Desconhecido',
            $_SERVER['REQUEST_URI'] ?? 'Desconhecida'
        );

        file_put_contents($arquivo, $registro, FILE_APPEND);
    }
}
