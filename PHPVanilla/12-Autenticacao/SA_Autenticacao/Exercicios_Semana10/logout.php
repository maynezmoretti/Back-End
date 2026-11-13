<?php
declare(strict_types=1);

require_once 'includes/bootstrap.php';

// Apaga os dados armazenados na sessão
$_SESSION = [];

// Recupera as configurações do cookie
$parametros = session_get_cookie_params();

// Expira o cookie da sessão
setcookie(session_name(), '', [
    'expires' => time() - 42000,
    'path' => $parametros['path'],
    'domain' => $parametros['domain'],
    'secure' => $parametros['secure'],
    'httponly' => $parametros['httponly'],
    'samesite' => $parametros['samesite']
]);

// Destrói a sessão
session_destroy();

// Volta para a tela de login
header('Location: ex04_bloqueio_tentativas.php');
exit;