<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class FornecedorController extends Controller
{
    /**
     * Listar os fornecedores disponíveis.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'mensagem' => 'Consulta pública de fornecedores.',
            'operacao' => 'Listagem'
        ]);
    }

    /**
     * Exibir os detalhes de um fornecedor.
     */
    public function show(int $fornecedor): JsonResponse
    {
        return response()->json([
            'mensagem' => 'Consulta de fornecedor realizada.',
            'fornecedor_id' => $fornecedor
        ]);
    }
}
