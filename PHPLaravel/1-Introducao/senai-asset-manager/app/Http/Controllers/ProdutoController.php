<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    // Exibe todos os produtos cadastrados
    public function index()
    {
        $produtos = Produto::all();
        $titulo = 'Lista de Produtos';

        return view('produtos.index', compact('produtos', 'titulo'));
    }

    // Exibe o formulário de cadastro
    public function create()
    {
        $titulo = 'Cadastrar Produto';

        return view('produtos.create', compact('titulo'));
    }

    // Salva um novo produto no banco de dados
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'fabricante' => 'required|string|max:255',
            'quantidade' => 'required|integer|min:0',
            'preco' => 'required|numeric|min:0',
        ]);

        Produto::create($dados);

        return redirect()
            ->route('produtos.index')
            ->with('success', 'Produto cadastrado com sucesso!');
    }

    // Exibe os detalhes de um produto
    public function show(Produto $produto)
    {
        $titulo = 'Detalhes do Produto';

        return view('produtos.show', compact('produto', 'titulo'));
    }

    // Exibe o formulário de edição
    public function edit(Produto $produto)
    {
        $titulo = 'Editar Produto';

        return view('produtos.edit', compact('produto', 'titulo'));
    }

    // Atualiza os dados de um produto
    public function update(Request $request, Produto $produto)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'fabricante' => 'required|string|max:255',
            'quantidade' => 'required|integer|min:0',
            'preco' => 'required|numeric|min:0',
        ]);

        $produto->update($dados);

        return redirect()
            ->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    // Exclui um produto
    public function destroy(Produto $produto)
    {
        $produto->delete();

        return redirect()
            ->route('produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
}