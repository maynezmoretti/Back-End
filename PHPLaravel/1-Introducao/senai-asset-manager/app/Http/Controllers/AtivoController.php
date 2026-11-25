<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class AtivoController extends Controller
{
    // Retorna a view com as métricas simuladas
    public function index(): View
    {
        $metricas = [
            "totalAtivos" => 42,
            "emOperacao" => 37,
            "emManutencao" => 4,
            "parados" => 1,
            "taxaEficiencia" => 88.5
        ];

        return view("ativos.index", [
            "metricas" => $metricas,
            "titulo" => "Painel Geral de Ativos Industriais"
        ]);
    }

    // Retorna o status do servidor em JSON
    public function status(): JsonResponse
    {
        return response()->json([
            "plataforma" => config("app.name"),
            "ambiente" => config("app.env"),
            "version_php" => PHP_VERSION,
            "status" => "ONLINE",
            "timestamp" => now()->toIso8601String()
        ]);
    }

    // Retorna as métricas dos setores fabris
    public function setores(): JsonResponse
    {
        return response()->json([
            [
                "setor" => "Usinagem",
                "quantidade_maquinas" => 15,
                "eficiencia_media" => 92.5
            ],
            [
                "setor" => "Estamparia",
                "quantidade_maquinas" => 10,
                "eficiencia_media" => 87.0
            ],
            [
                "setor" => "Montagem Robótica",
                "quantidade_maquinas" => 12,
                "eficiencia_media" => 95.0
            ]
        ]);
    }

    // Consulta os detalhes de um ativo pelo código
    public function detalhar(string $codigo): JsonResponse
    {
        $ativos = [
            "PAT-001" => [
                "codigo" => "PAT-001",
                "tensao_operacao" => 220,
                "horas_trabalhadas" => 1200
            ],
            "PAT-002" => [
                "codigo" => "PAT-002",
                "tensao_operacao" => 380,
                "horas_trabalhadas" => 850
            ]
        ];

        if (!preg_match('/^PAT-\d{3}$/', $codigo) || !isset($ativos[$codigo])) {
            return response()->json([
                "erro" => "Ativo não encontrado.",
                "mensagem" => "Verifique o código de patrimônio informado."
            ], 404);
        }

        return response()->json($ativos[$codigo]);
    }
}
