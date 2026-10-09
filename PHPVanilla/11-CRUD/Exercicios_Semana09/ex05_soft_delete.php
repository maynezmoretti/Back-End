<?php
declare(strict_types=1);

// Conecta ao banco de dados.
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

// Contém as operações de exclusão lógica e listagem.
final class PecaDAO
{
    public function __construct(private PDO $pdo)
    {
    }

    // Desativa a peça sem apagar o registro.
    public function excluir(int $id): bool
    {
        $sql = 'UPDATE pecas_industriais SET ativo = FALSE WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    // Lista apenas as peças ativas.
    public function listarTodos(): array
    {
        $sql = 'SELECT id, codigo_sku, descricao, categoria,
                quantidade, preco_unitario
                FROM pecas_industriais WHERE ativo = TRUE ORDER BY id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Consulta uma peça, mesmo que esteja desativada.
    public function buscarPorId(int $id): array|false
    {
        $sql = 'SELECT * FROM pecas_industriais WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}

// Cria a coluna de exclusão lógica caso ainda não exista.
try {
    $pdo = conectarBanco();
    $pdo->exec(
        'ALTER TABLE pecas_industriais
         ADD COLUMN IF NOT EXISTS ativo BOOLEAN DEFAULT TRUE'
    );

    $dao = new PecaDAO($pdo);

    // Altere o ID para testar com uma peça existente.
    $id = 1;
    $excluida = $dao->excluir($id);
    echo $excluida ? "Peça desativada.\n" : "Peça não encontrada ou já desativada.\n";

    // Confirma que o registro continua armazenado.
    $registro = $dao->buscarPorId($id);
    echo $registro ? "Registro preservado no banco.\n" : "Registro não encontrado.\n";
} catch (PDOException $erro) {
    echo "Erro ao executar a exclusão lógica.\n";
}