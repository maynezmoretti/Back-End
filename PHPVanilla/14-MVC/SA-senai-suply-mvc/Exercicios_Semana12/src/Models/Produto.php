<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\ConexaoBanco;
use PDO;

class Produto
{
    public function listar(): array
    {
        $sql = 'SELECT * FROM produtos ORDER BY id';
        $stmt = ConexaoBanco::obterConexao()->query($sql);

        return $stmt->fetchAll();
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = 'SELECT * FROM produtos WHERE id = :id';
        $stmt = ConexaoBanco::obterConexao()->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public function buscarPorCategoria(string $categoria): array
    {
        $sql = 'SELECT * FROM produtos WHERE categoria = :categoria';
        $stmt = ConexaoBanco::obterConexao()->prepare($sql);
        $stmt->execute(['categoria' => $categoria]);

        return $stmt->fetchAll();
    }

    public function excluir(int $id): bool
    {
        $sql = 'DELETE FROM produtos WHERE id = :id';
        $stmt = ConexaoBanco::obterConexao()->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }
}
