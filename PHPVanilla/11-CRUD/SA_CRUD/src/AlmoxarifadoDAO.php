<?php

declare(strict_types=1);

// Camada de Acesso a Dados (DAO) para Almoxarifado
// Essa camada é uma classe - usa paradigma de Programação Orientada ao Objeto

final class AlmoxarifadoDAO {

    // atributos -> características do objeto
    private PDO $pdo;

    // métodos -> ações
    // método que toda classe tem -> construtor
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // CREATE -> salva informações no banco
    public function salvar(array $dados): bool {

        $sql = "INSERT INTO pecas_industriais
                (codigo_sku, descricao, categoria, quantidade, preco_unitario)
                VALUES (:sku, :descricao, :categoria, :quantidade, :preco_unitario)";

        $stmt = $this->pdo->prepare($sql);

        $resultado = $stmt->execute([
            ":sku"            => strtoupper(trim($dados["codigo_sku"])),
            ":descricao"      => trim($dados["descricao"]),
            ":categoria"      => trim($dados["categoria"]),
            ":quantidade"     => (int)$dados["quantidade"],
            ":preco_unitario" => (float)$dados["preco_unitario"]
        ]);

        return $resultado;
    }

    // READ
    // listar todos
    public function listarTodos(): array {

        $sql = "SELECT * FROM pecas_industriais ORDER BY id DESC";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // listar uma peça específica pelo ID
    public function buscarPorId(int $id): ?array {

        $sql = "SELECT * FROM pecas_industriais
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado ?: null;
    }

    // UPDATE
    public function atualizar(int $id, array $dados): bool {

        $sql = "UPDATE pecas_industriais
                SET codigo_sku = :sku,
                    descricao = :descricao,
                    categoria = :categoria,
                    quantidade = :quantidade,
                    preco_unitario = :preco_unitario
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $resultado = $stmt->execute([
            ":sku"            => strtoupper(trim($dados["codigo_sku"])),
            ":descricao"      => trim($dados["descricao"]),
            ":categoria"      => trim($dados["categoria"]),
            ":quantidade"     => (int)$dados["quantidade"],
            ":preco_unitario" => (float)$dados["preco_unitario"],
            ":id"             => $id
        ]);

        return $resultado;
    }

    // DELETE
    public function excluir(int $id): bool {

        $sql = "DELETE FROM pecas_industriais
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $resultado = $stmt->execute();

        return $resultado;
    }

    // buscar produtos por termo
    public function buscarPorTermo(string $termo): array {

        $sql = "SELECT * FROM pecas_industriais
                WHERE codigo_sku ILIKE :termo
                OR descricao ILIKE :termo
                OR categoria ILIKE :termo
                ORDER BY descricao ASC";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ":termo" => "%" . trim($termo) . "%"
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}