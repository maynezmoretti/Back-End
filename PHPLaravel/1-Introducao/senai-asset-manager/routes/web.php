<?php
declare(strict_types=1);

use App\Http\Controllers\AtivoController;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\FornecedorController;

// Rotas do módulo de produtos
Route::resource('produtos', ProdutoController::class);

// Rotas públicas de fornecedores: somente leitura
Route::resource('fornecedores', FornecedorController::class)
    ->only(['index', 'show']);

// Rota principal da minha aplicação: Dashboard de Ativos Fabris
Route::get("/", [AtivoController::class, "index"]) -> name("ativos.index");

// Rota de Infraestrutura para exibir o status em um json
Route::get("/status", [AtivoController::class, "status"]) -> name("ativos.status");

// Rota para consultar as métricas dos setores fabris
Route::get('/setores', [AtivoController::class, 'setores']) ->name('ativos.setores');

Route::get('/ativos/{codigo}', [AtivoController::class, 'detalhar'])
    ->name('ativos.detalhar');

// Laravel possui uma técnica de criação de rotas usando o resources
// Rota Restful com identificador numérico (GET/clientes; Get/clientes/id; POST/clientes; PUT/clientes/id; DELETE/clientes/id)
Route::resource("clientes", ClienteController::class) -> whereNumber("cliente");

// Rota customizada para a busca por setor 
Route::get("/clientes/setor/{setor?}" , [ClienteController::class, "filtrarPorSetor"])
    ->name("clientes.setor")
    ->whereAlphaNumeric("setor");

// Rota para consultar contratos de um cliente por ano
Route::get('/clientes/{cliente}/contratos/{ano}', [
    ClienteController::class,
    'contratosPorAno'
])
    ->whereNumber('cliente')
    ->where('ano', '[0-9]{4}')
    ->name('clientes.contratos.ano');

// Rota para identificar a origem da requisição HTTP
Route::get('/clientes/origem/requisicao', [
    ClienteController::class,
    'origemRequisicao'
])->name('clientes.origem');

// Rota para alteração parcial do status do cliente
Route::patch('/clientes/{id}/status', [
    ClienteController::class,
    'alterarStatus'
])->whereNumber('id')->name('clientes.status');

// Verifica a saúde da aplicação
Route::get('/healthz', function () {
    return response()->json([
        "status" => "UP",
        "uptime_segundos" => round(microtime(true) - LARAVEL_START, 2),
        "memoria_mb" => round(memory_get_usage(true) / 1024 / 1024, 2)
    ]);
})->name('healthz');

// Grupo de rotas administrativas
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/auditoria/clientes', function () {
            return response()->json([
                'total_parceiros_ativos' => \App\Models\Cliente::where(
                    'status',
                    'ATIVO'
                )->count()
            ]);
        })->name('auditoria.clientes');
    });