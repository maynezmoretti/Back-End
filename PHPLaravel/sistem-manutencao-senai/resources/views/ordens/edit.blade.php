
@extends('layouts.app')

@section('titulo', $titulo)

@section('conteudo')
<div class="card" style="max-width: 650px; margin: 0 auto;">
    <h2>{{ $titulo }}</h2>
    <p style="color: #94a3b8; font-size: 0.85rem;">Preencha os dados técnicos para atualizar a intervenção de manutenção.</p>

    <form action="{{ route('ordens.update', $ordem) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 0.85rem; color: #cbd5e1; margin-bottom: 5px;">Título da Ocorrência</label>
            <input type="text" name="titulo" value="{{ old('titulo', $ordem->titulo) }}" required placeholder="Ex.: Superaquecimento do mancal frontal" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #475569; background: #0f172a; color: #f8fafc; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 0.85rem; color: #cbd5e1; margin-bottom: 5px;">Equipamento Alvo</label>
            <select name="equipamento_id" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #475569; background: #0f172a; color: #f8fafc; box-sizing: border-box;">
                <option value="">-- Selecione a Máquina --</option>
                @foreach($equipamentos as $e)
                    <option value="{{ $e->id }}" @selected(old('equipamento_id', $ordem->equipamento_id) == $e->id)>
                        {{ $e->tag }} - {{ $e->nome }} ({{ $e->setor }})
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 0.85rem; color: #cbd5e1; margin-bottom: 5px;">Tipo de Manutenção</label>
            <select name="tipo" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #475569; background: #0f172a; color: #f8fafc; box-sizing: border-box;">
                @foreach(['PREVENTIVA', 'CORRETIVA', 'PREDITIVA'] as $tipo)
                    <option value="{{ $tipo }}" @selected(old('tipo', $ordem->tipo) === $tipo)>
                        {{ ucfirst(strtolower($tipo)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 0.85rem; color: #cbd5e1; margin-bottom: 5px;">Grau de Prioridade</label>
            <select name="prioridade" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #475569; background: #0f172a; color: #f8fafc; box-sizing: border-box;">
                <option value="BAIXA" @selected(old('prioridade', $ordem->prioridade) === 'BAIXA')>Baixa (Rotina preventiva)</option>
                <option value="MEDIA" @selected(old('prioridade', $ordem->prioridade) === 'MEDIA')>Média (Atendimento em até 48h)</option>
                <option value="ALTA" @selected(old('prioridade', $ordem->prioridade) === 'ALTA')>Alta (Risco potencial de parada)</option>
                <option value="CRITICA" @selected(old('prioridade', $ordem->prioridade) === 'CRITICA')>Crítica (Linha parada / Emergência)</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 0.85rem; color: #cbd5e1; margin-bottom: 5px;">Técnico Responsável</label>
            <input type="text" name="tecnico" value="{{ old('tecnico', $ordem->tecnico) }}" required placeholder="Ex.: Carlos Eduardo" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #475569; background: #0f172a; color: #f8fafc; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 0.85rem; color: #cbd5e1; margin-bottom: 5px;">Prazo Limite</label>
            <input type="date" name="prazo_limite" value="{{ old('prazo_limite', $ordem->prazo_limite ? \Carbon\Carbon::parse($ordem->prazo_limite)->format('Y-m-d') : '') }}" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #475569; background: #0f172a; color: #f8fafc; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 0.85rem; color: #cbd5e1; margin-bottom: 5px;">Status da Ordem</label>
            <select name="status" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #475569; background: #0f172a; color: #f8fafc; box-sizing: border-box;">
                <option value="ABERTA" @selected(old('status', $ordem->status) === 'ABERTA')>Aberta</option>
                <option value="EM_ANDAMENTO" @selected(old('status', $ordem->status) === 'EM_ANDAMENTO')>Em andamento</option>
                <option value="CONCLUIDA" @selected(old('status', $ordem->status) === 'CONCLUIDA')>Concluída</option>
            </select>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 25px;">
            <a href="{{ route('ordens.index') }}" style="color: #94a3b8; text-decoration: none; font-size: 0.9rem;">← Cancelar</a>
            <button type="submit" class="btn btn-success">Atualizar Chamado</button>
        </div>
    </form>
</div>
@endsection
