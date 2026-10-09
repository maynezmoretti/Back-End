<?php
declare(strict_types=1);

// Conecta ao banco de dados PostgreSQL.
function conectarBanco(): PDO
{
    $config = parse_ini_file(__DIR__ . '/database.ini', true);

    if ($config === false || !isset($config['development'])) {
        throw new RuntimeException('Configuração do banco não encontrada.');
    }

    $db = $config['development'];
    $dsn = "pgsql:host={$db['db_host']};port={$db['db_port']};dbname={$db['db_name']}";

    return new PDO($dsn, $db['db_user'], $db['db_password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
}

// Cadastra uma peça usando parâmetros nomeados.
function cadastrarPeca(PDO $pdo): void
{
    echo "Código SKU: ";
    $sku = trim((string) fgets(STDIN));
    echo "Descrição: ";
    $descricao = trim((string) fgets(STDIN));
    echo "Categoria: ";
    $categoria = trim((string) fgets(STDIN));
    echo "Quantidade: ";
    $quantidade = filter_var(trim((string) fgets(STDIN)), FILTER_VALIDATE_INT);
    echo "Preço unitário: ";
    $preco = filter_var(trim((string) fgets(STDIN)), FILTER_VALIDATE_FLOAT);

    if ($sku === '' || $descricao === '' || $categoria === '' ||
        $quantidade === false || $quantidade < 0 ||
        $preco === false || $preco < 0) {
        echo "Dados inválidos.\n";
        return;
    }

    $sql = 'INSERT INTO pecas_industriais
        (codigo_sku, descricao, categoria, quantidade, preco_unitario)
        VALUES (:sku, :descricao, :categoria, :quantidade, :preco)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':sku' => $sku,
        ':descricao' => $descricao,
        ':categoria' => $categoria,
        ':quantidade' => $quantidade,
        ':preco' => $preco
    ]);

    echo "Peça cadastrada com sucesso!\n";
}

// Lista somente as peças que estão ativas.
function listarPecas(PDO $pdo): void
{
    $sql = 'SELECT id, codigo_sku, descricao, categoria, quantidade,
            preco_unitario FROM pecas_industriais WHERE ativo = TRUE
            ORDER BY id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    foreach ($stmt->fetchAll() as $peca) {
        echo "{$peca['id']} - {$peca['codigo_sku']} - ";
        echo "{$peca['descricao']} - Quantidade: {$peca['quantidade']}\n";
    }
}

// Executa o menu do terminal.
function executarMenu(PDO $pdo): void
{
    do {
        echo "\n1 - Cadastrar peça\n2 - Listar peças ativas\n3 - Sair\n";
        echo "Escolha: ";
        $opcao = trim((string) fgets(STDIN));

        try {
            if ($opcao === '1') {
                cadastrarPeca($pdo);
            } elseif ($opcao === '2') {
                listarPecas($pdo);
            } elseif ($opcao !== '3') {
                echo "Opção inválida.\n";
            }
        } catch (PDOException $erro) {
            echo "Erro ao acessar o banco de dados.\n";
        }
    } while ($opcao !== '3');

    echo "Programa encerrado.\n";
}

try {
    executarMenu(conectarBanco());
} catch (Throwable $erro) {
    echo "Não foi possível conectar ao banco de dados.\n";
}