<?php
declare(strict_types=1);

// Parte B: Exercícios Práticos de Laboratório
// Exercício 3: Alternador de Ambientes (Desenvolvimento vs Homologação)

/**
 * Carrega as configurações do ambiente escolhido.
 */
function carregarAmbiente(string $ambiente): array
{
    $configuracoes = parse_ini_file(
        __DIR__ . '/config/database.ini',
        true
    );

    if ($configuracoes === false) {
        throw new RuntimeException(
            'Erro ao carregar o arquivo database.ini.'
        );
    }

    if (!isset($configuracoes[$ambiente])) {
        throw new InvalidArgumentException(
            "Ambiente '{$ambiente}' não encontrado."
        );
    }

    return $configuracoes[$ambiente];
}

try {
    // Escolhe o ambiente.
    $ambiente = 'development';

    // Carrega as configurações.
    $config = carregarAmbiente($ambiente);

    // Monta a conexão com o PostgreSQL.
    $dsn = "pgsql:host={$config['db_host']};"
        . "port={$config['db_port']};"
        . "dbname={$config['db_name']}";

    $pdo = new PDO($dsn, 'postgres', 'postgres');

    // Configura o PDO para mostrar erros.
    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    echo "Ambiente: {$ambiente}" . PHP_EOL;
    echo "Banco: {$config['db_name']}" . PHP_EOL;
    echo "Conexão realizada com sucesso!" . PHP_EOL;

} catch (Throwable $e) {
    echo "Erro: " . $e->getMessage() . PHP_EOL;
}