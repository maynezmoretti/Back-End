<?php
declare(strict_types=1);

// Classe responsável por desativar peças do estoque
final class ex05_soft_delete
{
    // Armazena a conexão com o banco de dados
    private PDO $pdo;

    // Recebe a conexão ao criar o objeto
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Desativa a peça sem removê-la do banco
    public function excluir(int $id): bool
    {
        $sql = "UPDATE pecas_industriais
                SET ativo = FALSE
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        // Retorna true se alguma linha foi alterada
        return $stmt->rowCount() > 0;
    }
}