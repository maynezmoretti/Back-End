<?php
declare(strict_types=1);

namespace App\Controllers;

class Controller
{
    protected function renderizarJson(
        array $dados,
        int $status = 200
    ): void {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(
            $dados,
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
    }
}
