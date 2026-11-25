<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EquipamentoController extends Controller
{
    /**
     * Tela para exibir os equipamentos cadastrados
     */
    public function index(): View {
        return view('equipamentos.index', [
            'equipamentos' => Equipamento::query()->latest()->get(),
            'titulo'       => 'Parque de Máquinas e Equipamentos Industriais',
        ]);
    }

    /**
     * tela para exibir o formulário de cadastro de equipamento
     */
    public function create(): View {
        return view('equipamentos.create', [
            'titulo' => 'Cadastrar Equipamento',
        ]);
    }

    /**
     * permite cadastrar um novo equipamento no BD
     */
    public function store(Request $request): RedirectResponse {
        Equipamento::create($this->validar($request));

        return redirect()->route('equipamentos.index')
            ->with('mensagem_sucesso', 'Equipamento cadastrado com sucesso!');
    }

    /**
     * exibir dados detalhados do equipamento
     */
    public function show(string $id)
    {
        //
    }

    /**
     * exibir um formulário para editar
     */
    public function edit(Equipamento $equipamento): View {
        return view('equipamentos.edit', [
            'equipamento' => $equipamento,
            'titulo'      => 'Editar Equipamento',
        ]);
    }

    /**
     * botão para atualizar informação de equipamento
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove um equipamento da base de dados
     */
     public function destroy(Equipamento $equipamento): RedirectResponse {
        $equipamento->delete();

        return redirect()->route('equipamentos.index')
            ->with('mensagem_sucesso', 'Equipamento removido com sucesso!');
    }


    //função para validar dados antes de qualquer coisa(cadastrar/atualizar e deletar)
    private function validar(Request $request, ?int $id = null): array {
        $regraTag = 'required|string|max:255|unique:equipamentos,tag' . ($id ? ",{$id}" : '');

        return $request->validate([
            'tag'         => $regraTag,
            'nome'        => 'required|string|max:255',
            'setor'       => 'required|string|max:255',
            'criticidade' => 'required|in:BAIXA,MEDIA,ALTA,CRITICA',
            'status'      => 'required|in:OPERANDO,MANUTENCAO,PARADO',
        ]);
    }
}
