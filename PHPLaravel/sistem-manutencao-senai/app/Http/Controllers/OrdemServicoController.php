<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use App\Models\OrdemServico;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrdemServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View {
        $filtroStatus = (string) $request->query('status', '');
        $consulta = OrdemServico::query()->with('equipamento');

        if ($filtroStatus !== '') {
            $consulta->where('status', strtoupper($filtroStatus));
        }

        return view('ordens.index', [
            'ordens'      => $consulta->latest()->get(),
            'filtroAtivo' => $filtroStatus,
            'titulo'      => 'Gestão de Ordens de Serviço',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View {
        return view('ordens.create', [
            'equipamentos' => Equipamento::orderBy('nome')->get(),
            'titulo'       => 'Abertura de Chamado de Manutenção',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse {
        $dados = $this->validar($request);
        $dados['codigo'] = 'OS-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4));
        $dados['data_abertura'] = now()->toDateString();
        $dados['status'] = 'ABERTA';

        OrdemServico::create($dados);

        return redirect()->route('ordens.index')
            ->with('mensagem_sucesso', 'Ordem de serviço registrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrdemServico $ordem): View {
        $ordem->load('equipamento');

        return view('ordens.show', [
            'ordem'       => $ordem,
            'equipamento' => $ordem->equipamento,
            'titulo'      => "Ficha da Ordem {$ordem->codigo}",
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrdemServico $ordem): View {
        return view('ordens.edit', [
            'ordem'        => $ordem,
            'equipamentos' => Equipamento::orderBy('nome')->get(),
            'titulo'       => "Editar Ordem {$ordem->codigo}",
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrdemServico $ordem): RedirectResponse {
        $ordem->update($this->validar($request, true));

        return redirect()->route('ordens.show', $ordem)
            ->with('mensagem_sucesso', 'Ordem de serviço atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrdemServico $ordem): RedirectResponse {
        $ordem->delete();

        return redirect()->route('ordens.index')
            ->with('mensagem_sucesso', 'Ordem de serviço removida com sucesso!');
    }

    //validar dados da ordem de serviço (antes de cadastrar e atualizar)
    private function validar(Request $request, bool $atualizacao = false): array {
        return $request->validate([
            'titulo'         => 'required|string|min:5|max:255',
            'equipamento_id' => 'required|exists:equipamentos,id',
            'tipo'           => 'required|in:PREVENTIVA,CORRETIVA,PREDITIVA',
            'prioridade'     => 'required|in:BAIXA,MEDIA,ALTA,CRITICA',
            'tecnico'        => 'required|string|max:255',
            'prazo_limite'   => 'required|date',
            'status'         => $atualizacao ? 'required|in:ABERTA,EM_ANDAMENTO,CONCLUIDA' : 'sometimes|in:ABERTA,EM_ANDAMENTO,CONCLUIDA',
        ]);
    }
}
