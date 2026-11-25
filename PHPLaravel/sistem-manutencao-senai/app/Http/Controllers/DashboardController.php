<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use App\Models\OrdemServico;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //Função do Tipo index() -> exibição de métricas  para construção de kpi
    public function index(): View {
        return view('dashboard.index', [
            'totalEquipamentos'    => Equipamento::count(),
            'equipamentosOperando' => Equipamento::where('status', 'OPERANDO')->count(),
            'ordensAbertas'        => OrdemServico::where('status', 'ABERTA')->count(),
            'ordensCriticas'       => OrdemServico::where('prioridade', 'CRITICA')
                ->where('status', '!=', 'CONCLUIDA')
                ->count(),
            'ultimasOrdens'        => OrdemServico::with('equipamento')->latest()->take(3)->get(),
        ]);
    }
}
