<?php
declare(strict_types=1);

namespace App\Core;

class Roteador
{
    private array $rotas = [];
    private array $middlewares = [];

    public function get(string $caminho, callable $acao): void
    {
        $this->registrar('GET', $caminho, $acao);
    }

    public function post(string $caminho, callable $acao): void
    {
        $this->registrar('POST', $caminho, $acao);
    }

    private function registrar(
        string $metodo,
        string $caminho,
        callable $acao
    ): void {
        $this->rotas[] = compact('metodo', 'caminho', 'acao');
    }

    public function adicionarMiddleware(callable $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    public function executar(): void
    {
        foreach ($this->middlewares as $middleware) {
            $middleware();
        }

        $metodo = $_SERVER['REQUEST_METHOD'];
        $caminho = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $rota = $this->encontrarRota($metodo, (string) $caminho);

        if ($rota === null) {
            http_response_code(404);
            echo 'Página não encontrada.';
            return;
        }

        call_user_func_array($rota['acao'], $rota['parametros']);
    }

    private function encontrarRota(string $metodo, string $caminho): ?array
    {
        foreach ($this->rotas as $rota) {
            if ($rota['metodo'] !== $metodo) {
                continue;
            }

            $padrao = $this->criarPadrao($rota['caminho']);

            if (preg_match($padrao, $caminho, $dados)) {
                array_shift($dados);
                return $rota + ['parametros' => $dados];
            }
        }

        return null;
    }

    private function criarPadrao(string $caminho): string
    {
        $padrao = preg_replace(
            '/\{[a-zA-Z_][a-zA-Z0-9_]*\}/',
            '([^/]+)',
            $caminho
        );

        return '#^' . $padrao . '$#';
    }
}
