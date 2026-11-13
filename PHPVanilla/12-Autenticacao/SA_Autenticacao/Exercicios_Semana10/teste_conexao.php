<?php
declare(strict_types=1);

require_once 'config/database.php';

try {
    // Tenta conectar ao PostgreSQL
    $pdo = conectarBanco();

    echo "Conexão realizada com sucesso!";
} catch (PDOException $erro) {
    // Mostra se aconteceu algum erro
    echo "Erro na conexão: " . $erro->getMessage();
}