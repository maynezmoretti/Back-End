<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\ConexaoBanco;
use PDO;

// Classe de conexão com o BD e Regras de Negócio
final class Usuario {
    // Classe ligada a tabela de Usuário

    // Método de conexão com o BD
    private static function pdo(): PDO {
        $cfg = dirname(__DIR__, 2) . "/config/database.ini"; // Caminho das configurações do BD
        return ConexaoBanco::obterConexao($cfg);
    }
    
    // Método para localizar o usuário pelo email
    public static function buscarPorEmail(string $email): ?array {
        // ?array -> pode ou não ter retorno de dados do usuário (aceita nulo)
        $sql = "SELECT id, nome, email, senha_hash, perfil FROM usuarios
                WHERE email = :email LIMIT 1";
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute([':email' => trim($email)]);
        $resultado = $stmt->fetch();
        return $resultado ?: null;
    }

    // Método para localizar o usuário pelo ID
    public static function buscarPorId(string $id): ?array {
        $sql = "SELECT id, nome, email, senha_hash, perfil FROM usuarios
                WHERE email = :email LIMIT 1";
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $resultado = $stmt->fetch();
        return $resultado ?: null;
    }
}