<?php
declare(strict_types=1);

// Encerra a sessão quando necessário
function encerrarSessao(): void
{
    $_SESSION = [];
    session_destroy();

    // Remove o cookie da sessão
    setcookie(session_name(), '', time() - 3600, '/');

    http_response_code(403);
    exit("Sessão encerrada. Faça login novamente.");
}

// Verifica o acesso e o tempo de inatividade
function verificarPermissao(string $perfilMinimo): void
{
    // Verifica se existe um usuário conectado
    if (!isset($_SESSION['usuario'])) {
        http_response_code(403);
        exit("Acesso negado. Faça login primeiro.");
    }

    // Verifica se passaram 15 minutos sem atividade
    if (isset($_SESSION['ultima_atividade'])) {
        if (time() - $_SESSION['ultima_atividade'] > 900) {
            encerrarSessao();
        }
    }

    // Atualiza o horário da última atividade
    $_SESSION['ultima_atividade'] = time();

    // Define os níveis de permissão
    $niveis = [
        'OPERADOR' => 1,
        'ADMIN' => 2
    ];

    $perfil = $_SESSION['usuario']['perfil'] ?? '';

    // Confere se o usuário tem permissão
    if (
        !isset($niveis[$perfilMinimo]) ||
        ($niveis[$perfil] ?? 0) < $niveis[$perfilMinimo]
    ) {
        http_response_code(403);
        exit("Acesso negado. Você não tem permissão.");
    }
}