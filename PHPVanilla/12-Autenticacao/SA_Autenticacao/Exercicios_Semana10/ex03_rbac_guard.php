<?php
declare(strict_types=1);

require_once 'includes/bootstrap.php';
require_once 'guard.php';

// Somente administradores podem acessar
verificarPermissao('ADMIN');

echo "<h1>Área administrativa</h1>";
echo "<p>Bem-vindo, administrador!</p>";