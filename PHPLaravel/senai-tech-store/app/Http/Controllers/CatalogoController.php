<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;

/**
 * Controller responsavel por renderizar o catalogo e relatorios de estoque.
 */
final class CatalogoController extends Controller {
    /**
     * Exibe o catalogo da loja de informatica com paginacao e filtros.
     */
    public function index(Request $request): View {
        $categoriaId = (int)$request->query('categoria_id', 0);
        $categorias = Categoria::all();

        $query = Produto::with(['categoria', 'fornecedor'])->where('ativo', true);

        if ($categoriaId > 0) {
            $query->where('categoria_id', $categoriaId);
        }

        $produtos = $query->orderBy('nome')->paginate(12);

        return view('catalogo.index', [
            'produtos'    => $produtos,
            'categorias'  => $categorias,
            'categoriaId' => $categoriaId,
            'kpis'        => $this->calcularKpis()
        ]);
    }

    /**
     * Calcula metricas sinteticas do estoque para exibicao em cards.
     */
    private function calcularKpis(): array {
        return [
            'totalItens'    => Produto::count(),
            'saldoPecas'    => (int)Produto::sum('estoque'),
            'valorEstoque'  => (float)Produto::selectRaw('SUM(preco * estoque) as total')->value('total'),
            'baixoEstoque'  => Produto::where('estoque', '<', 10)->count()
        ];
    }
}
