<?php
declare(strict_types=1);

// Conecta ao PostgreSQL usando a configuração do projeto.
function conectarBanco(): PDO
{
    $config = parse_ini_file(__DIR__ . '/database.ini', true);

    if ($config === false || !isset($config['development'])) {
        throw new RuntimeException('Configuração não encontrada.');
    }

    $db = $config['development'];
    $dsn = "pgsql:host={$db['db_host']};port={$db['db_port']};dbname={$db['db_name']}";

    return new PDO($dsn, $db['db_user'], $db['db_password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
}

// Retorna o número da página, sem aceitar valores menores que um.
function obterPagina(): int
{
    $pagina = filter_var($_GET['p'] ?? 1, FILTER_VALIDATE_INT);
    return ($pagina !== false && $pagina > 0) ? $pagina : 1;
}

// Busca cinco peças de acordo com a página escolhida.
function listarPagina(PDO $pdo, int $pagina): void
{
    $offset = ($pagina - 1) * 5;
    $sql = 'SELECT id, codigo_sku, descricao, quantidade
            FROM pecas_industriais
            ORDER BY id
            LIMIT :limite OFFSET :offset';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limite', 5, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    foreach ($stmt->fetchAll() as $peca) {
        echo "{$peca['codigo_sku']} - {$peca['descricao']} ";
        echo "- Quantidade: {$peca['quantidade']}\n";
    }
}

// Executa a paginação e trata possíveis erros.
try {
    listarPagina(conectarBanco(), obterPagina());
} catch (PDOException $erro) {
    echo "Erro ao consultar o catálogo.\n";
}