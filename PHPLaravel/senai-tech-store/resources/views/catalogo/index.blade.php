@extends('layouts.app')

@section('titulo', 'Catálogo da Loja de Informática')

@section('conteudo')
<div class="card">
    <h2 style="color: #38bdf8; margin: 0 0 10px 0;">Painel de Produtos & Estoque de Informática</h2>
    
    {{-- Cards de Indicadores gerados a partir do banco semeado --}}
    <div class="grid-stats">
        <x-card-kpi titulo="Produtos Cadastrados" :valor="$kpis['totalItens']" subtitulo="SKUs ativos na loja" />
        <x-card-kpi titulo="Saldo Total em Estoque" :valor="number_format($kpis['saldoPecas'], 0, ',', '.')" cor="#4ade80" subtitulo="Unidades disponíveis" />
        <x-card-kpi titulo="Patrimônio em Estoque" valor="R$ {{ number_format($kpis['valorEstoque'], 2, ',', '.') }}" cor="#f59e0b" subtitulo="Valor total em inventário" />
        <x-card-kpi titulo="Alerta de Reposição" :valor="$kpis['baixoEstoque']" cor="#f87171" subtitulo="Saldo < 10 unidades" />
    </div>

    {{-- Filtro de Categorias via Query String --}}
    <form action="{{ route('catalogo.index') }}" method="GET" style="margin: 25px 0 15px 0; display: flex; gap: 10px; align-items: center;">
        <label for="categoria_id" style="font-size: 0.85rem; color: #cbd5e1; font-weight: bold;">Filtrar por Categoria:</label>
        <select name="categoria_id" id="categoria_id" style="padding: 8px 12px; background: #0f172a; border: 1px solid #475569; border-radius: 5px; color: #f8fafc;">
            <option value="0">-- Todas as Categorias --</option>
            @foreach($categorias as $cat)
                <option value="{{ $cat->id }}" @selected($categoriaId === $cat->id)>{{ $cat->nome }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn">Aplicar Filtro</button>
        @if($categoriaId > 0)
            <a href="{{ route('catalogo.index') }}" style="color: #94a3b8; font-size: 0.85rem; text-decoration: none;">Limpar Filtro</a>
        @endif
    </form>

    {{-- Tabela do Catálogo Povoado com Migrations, Seeders e Factories --}}
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>SKU</th>
                <th>Descrição do Produto</th>
                <th>Categoria</th>
                <th>Fornecedor / Distribuidor</th>
                <th>Preço Unitário</th>
                <th>Disponibilidade</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produtos as $prod)
                <tr style="background: {{ $loop->even ? '#1e293b' : '#0f172a' }};">
                    <td>{{ $loop->iteration }}</td>
                    <td><code>{{ $prod->sku }}</code></td>
                    <td><strong>{{ $prod->nome }}</strong></td>
                    <td>{{ $prod->categoria->nome }}</td>
                    <td>{{ $prod->fornecedor->razao_social }}</td>
                    <td style="color: #38bdf8; font-weight: bold;">
                        R$ {{ number_format((float)$prod->preco, 2, ',', '.') }} / {{ $prod->unidade_medida }}
                    </td>
                    <td><x-badge-status :estoque="$prod->estoque" /></td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 30px; color: #94a3b8;">
                        Nenhum produto cadastrado para os critérios selecionados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginação Nativa do Laravel --}}
    <div style="margin-top: 20px;">
        {{ $produtos->links() }}
    </div>
</div>
@endsection
