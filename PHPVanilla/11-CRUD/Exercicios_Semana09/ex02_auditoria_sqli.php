<?php
declare(strict_types=1);

// Abre a conexão com o PostgreSQL.
function conectarBanco(): PDO
{
    $config = parse_ini_file(__DIR__ . '/database.ini', true);

    if ($config === false || !isset($config['development'])) {
        throw new RuntimeException('Configuração não encontrada.');
    }

    $db = $config['development'];
    $dsn = "pgsql:host={$db['db_host']};port={$db['db_port']};dbname={$db['db_name']}";

    return new PDO($dsn, $db['db_user'], $db['db_password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}

// Demonstra uma consulta vulnerável à injeção de SQL.
function buscarVulneravel(string $termo): void
{
    $pdo = conectarBanco();
    $sql = "SELECT id, descricao FROM pecas_industriais
            WHERE descricao = '$termo'";

    echo "\nConsulta vulnerável:\n$sql\n";
    $resultado = $pdo->query($sql);
    echo "Registros encontrados: " . $resultado->rowCount() . "\n";
}

// Pesquisa com parâmetro nomeado e consulta preparada.
function buscarProtegido(string $termo): void
{
    $pdo = conectarBanco();
    $sql = 'SELECT id, descricao FROM pecas_industriais
            WHERE descricao = :termo';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':termo' => $termo]);

    echo "\nConsulta protegida:\n";
    echo "Registros encontrados: " . count($stmt->fetchAll()) . "\n";
}

// Compara os dois comportamentos com um texto de teste.
try {
    $termo = "' OR '1'='1";

    echo "=== TESTE VULNERÁVEL ===\n";
    buscarVulneravel($termo);

    echo "\n=== TESTE PROTEGIDO ===\n";
    buscarProtegido($termo);
} catch (PDOException $erro) {
    echo "Erro durante o teste de SQL Injection.\n";
}