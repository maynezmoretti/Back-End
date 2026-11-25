<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Produto;

class ProdutoController extends Controller
{
    private Produto $produto;

    public function __construct()
    {
        $this->produto = new Produto();
    }

    public function detalhar(int $id): void
    {
        $produto = $this->produto->buscarPorId($id);

        if ($produto === null) {
            http_response_code(404);
            echo 'Produto não encontrado.';
            return;
        }

        echo htmlspecialchars(
            json_encode($produto, JSON_UNESCAPED_UNICODE) ?: '',
            ENT_QUOTES,
            'UTF-8'
        );
    }

    public function listarJson(): void
    {
        $this->renderizarJson($this->produto->listar());
    }

    public function excluir(): void
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id === false || $id === null || $id <= 0) {
            http_response_code(400);
            echo 'ID inválido.';
            return;
        }

        $excluido = $this->produto->excluir($id);
        http_response_code($excluido ? 200 : 404);
        echo $excluido ? 'Produto excluído.' : 'Produto não encontrado.';
    }


    public function listarPorCategoria(): void
    {
        $categoria = filter_input(INPUT_GET, 'categoria') ?: '';

        $produtos = $categoria !== ''
            ? $this->produto->buscarPorCategoria($categoria)
            : $this->produto->listar();

        require dirname(__DIR__, 2) . '/views/produtos/index.php';
    }

}
