<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Listar todos os clientes cadastrados
     */
    public function index(): View
    {
        return view("clientes.index", [
            "clientes" => Cliente::all(),
            "titulo"   => "Parceiros e Clientes Industriais"
        ]);
    }

    /**
     * Exibir o formulário para cadastro de novos clientes
     */
    public function create(): View
    {
        return view("clientes.create", [
            "titulo" => "Novo cadastro de Parceiro Industrial"
        ]);
    }

    /**
     * Salvar o novo cliente no banco de dados injetado pela request POST
     */
    // Injeção por dependência request para pegar informações do formulário
    public function store(Request $request): RedirectResponse
    {
        $dados = $request -> validate([
            "razao_social" => "required|min:3",
            "cnpj"         => "required|unique:clientes,cnpj", // permite a validação de cnpj único no banco
            "setor"        => "required"
        ]);

        Cliente::create($dados + ["status" => "ATIVO"]);

        return redirect() -> route("cliente.index") -> with("sucesso", "Cliente cadastrado com sucesso!");
    }

    /**
     * Exibir os detalhes de um cliente específico
     */
    public function show(int $id): View
    {
        // busca as informações do cliente no banco
        $cliente = Cliente::findOrFail($id);
        // findOrFail -> retorna a mensagem de erro caso não encontre o cliente

        // se encontrado, abre uma tela com as informações do cliente
        return view("clientes.show", [
            "clientes" => $cliente,
            "titulo"   => "Ficha Técnica: {$cliente["razao_social"]}"
        ]);
    }

    /**
     * Exibir (view) o formulário de edição de um cliente
     */
    public function edit(int $id): View
    {
        $cliente = Cliente::findOrFail($id);

        return view("cliente.edit", [
            "cliente" => $cliente,
            "titulo"  => "Editar Parceiro: {$cliente["razao_social"]}"
        ]);
    }

    /**
     * Atualizar os dados do cliente (Method Spooting -> @method PUT)
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $dados = $request -> validate([
            "razao_social" => "required|min:3",
            "setor"        => "required"
        ]);

        Cliente::findOrFail($id) -> update($dados);

        return redirect() -> route("cliente.show", $id) -> with("sucesso", "Dados atualizados com sucesso!");
    }

    /**
     * Remove o cliente via @method DELETE
     */
    public function destroy(int $id): RedirectResponse
    {
        Cliente::findOrFail($id) -> delete();

        return redirect() -> route("cliente.index") -> with("sucesso", "Parceiro removido do sistema!");
    }

    // Filtro: Server Side por setor
}