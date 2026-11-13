<?php
declare(strict_types=1);

// Função responsável por conectar ao banco
function conectarBanco(): PDO
{
    $host = getenv('DB_HOST') ?: 'SEU_IP';
    $port = getenv('DB_PORT') ?: '5432';
    $nome = getenv('DB_NAME') ?: 'senai_asset_manager';
    $usuario = getenv('DB_USER') ?: 'postgres';
    $senha = getenv('DB_PASS') ?: 'SUA_SENHA';

    // Monta o endereço de conexão
    $dsn = "pgsql:host=$host;port=$port;dbname=$nome";

    // Retorna a conexão configurada
    return new PDO($dsn, $usuario, $senha, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
}