<?php
declare(strict_types=1);

// Classe responsável pelas movimentações do estoque
final class ex04_movimentacao_estoque
{
    // Armazena a conexão com o banco de dados
    private PDO $pdo;

    // Recebe a conexão ao criar o objeto
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Consulta a quantidade disponível da peça
    private function buscarSaldo(int $pecaId): ?int
    {
        $sql = "SELECT quantidade FROM pecas_industriais
                WHERE id = :id FOR UPDATE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $pecaId]);
        $peca = $stmt->fetch(PDO::FETCH_ASSOC);

        return $peca ? (int) $peca['quantidade'] : null;
    }

    // Altera a quantidade da peça no estoque
    private function atualizarSaldo(int $pecaId, int $saldo): void
    {
        $sql = "UPDATE pecas_industriais
                SET quantidade = :quantidade WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'quantidade' => $saldo,
            'id' => $pecaId
        ]);
    }

    // Processa uma entrada ou saída de peças
    public function registrarMovimentacao(
        int $pecaId,
        int $quantidade,
        string $tipo
    ): bool {
        if ($quantidade <= 0 ||
            ($tipo !== 'entrada' && $tipo !== 'saida')) {
            return false;
        }

        $this->pdo->beginTransaction();

        try {
            $saldo = $this->buscarSaldo($pecaId);

            // Cancela a operação se a peça não existir ou faltar estoque
            if ($saldo === null ||
                ($tipo === 'saida' && $saldo < $quantidade)) {
                $this->pdo->rollBack();
                return false;
            }

            // Calcula o novo saldo conforme o tipo de movimentação
            $novoSaldo = $tipo === 'entrada'
                ? $saldo + $quantidade
                : $saldo - $quantidade;

            // Salva a alteração e confirma a transação
            $this->atualizarSaldo($pecaId, $novoSaldo);
            $this->pdo->commit();

            return true;
        } catch (PDOException $e) {
            // Desfaz a operação caso ocorra algum erro
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return false;
        }
    }
}