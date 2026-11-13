<?php
declare(strict_types=1);

// Configura os cookies da sessão
session_set_cookie_params([
    'httponly' => true,
    'secure' => !empty($_SERVER['HTTPS']),
    'samesite' => 'Lax'
]);

// Inicia a sessão
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Carrega a conexão e a classe DAO
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/UsuarioDAO.php';

// Cria os objetos necessários
$pdo = conectarBanco();
$usuarioDAO = new UsuarioDAO($pdo);

// Gera um token para proteger formulários
function tokenCsrf(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

// Confere se o token enviado é válido
function validarCsrf(): bool
{
    return isset($_POST['csrf_token'], $_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
}