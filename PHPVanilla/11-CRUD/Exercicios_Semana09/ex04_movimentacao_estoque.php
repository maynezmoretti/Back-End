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

// Controla as movimentações de entrada e saída do estoque.
final class PecaDAO
{
    public function __construct(private PDO $pdo)
    {
    }

    // Registra uma movimentação de forma atômica.
    public function registrarMovimentacao(
        int $pecaId,
        int $quantidade,
        string $tipo
    ): bool {
        if ($pecaId <= 0 || $quantidade <= 0 ||
            !in_array($tipo, ['entrada', 'saida'], true)) {
            return false;
        }

        try {
            $this->pdo->beginTransaction();

            $sql = 'SELECT quantidade FROM pecas_industriais
                    WHERE id = :id FOR UPDATE';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $pecaId]);
            $peca = $stmt->fetch();

            if (!$peca) {
                $this->pdo->rollBack();
                return false;
            }

            $saldo = (int) $peca['quantidade'];
            $novoSaldo = $tipo === 'entrada'
                ? $saldo + $quantidade
                : $saldo - $quantidade;

            if ($novoSaldo < 0) {
                $this->pdo->rollBack();
                return false;
            }

            $sql = 'UPDATE pecas_industriais SET quantidade = :saldo
                    WHERE id = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':saldo' => $novoSaldo, ':id' => $pecaId]);

            $this->pdo->commit();
            return true;
        } catch (Throwable $erro) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return false;
        }
    }
}

// Exemplo de movimentação para testar o método.
try {
    $dao = new PecaDAO(conectarBanco());
    $sucesso = $dao->registrarMovimentacao(1, 2, 'entrada');
    echo $sucesso ? "Movimentação registrada.\n" : "Movimentação não realizada.\n";
} catch (Throwable $erro) {
    echo "Não foi possível acessar o banco.\n";
}