<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Logger;
use App\Models\Produto;

final class ProdutoController extends Controller {

    // Método para listar os produtos
    public function listar():void {
        $produtos = Produto::listarTodos();
        $this->renderizar('produtos/listar', [
            'titulo'   => 'Catálogo Geral de Insumos',
            'produtos' => $produtos
        ]);
    }

    // Método para renderizar o formulário de cadastro dos produtos
    public function formulario(): void {
        $this->renderizar('produtos/criar', [
            'titulo'    => 'Cadastro de Novo Insumo',
            'csrfToken' => $this->obterCsrfToken()
        ]);
    }

    // Método para cadastrar produtos
    public function salvar(): void {
        if (!$this->validarCsrfToken($_POST['csrf_token'] ?? null)) {
            $this->renderizar('produtos/criar', ['titulo' => 'Novo Insumo', 'erro' => 'Falha CSRF.']);
            return;
        }
        $nome = trim($_POST['nome'] ?? '');
        $cat  = trim($_POST['categoria'] ?? '');
        $preco = (float)($_POST['preco'] ?? 0.0);
        $est  = (int)($_POST['estoque'] ?? 0);

        if ($nome !== '' && $cat !== '' && $preco > 0.0 && $est >= 0) {
            Produto::salvar($nome, $cat, $preco, $est);
            Logger::info("Novo insumo cadastrado no almoxarifado", ['nome' => $nome, 'categoria' => $cat]);
            $this->redirecionar('/produtos');
        }
        // Se tentar cadastrar falando informações, manda uma mensagem de aviso para o usuário
        $this->renderizar('produtos/criar', [
            'titulo'    => 'Novo Insumo',
            'erro'      => 'Preencha todos os campos corretamente.',
            'csrfToken' => $this->obterCsrfToken()
        ]);
    }
}