<?php
declare(strict_types=1);

class UsuarioDAO
{
    private PDO $pdo;

    // Recebe a conexão com o banco
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Cadastra um novo usuário
    public function criar(
        string $nome,
        string $email,
        string $hash,
        string $perfil = 'OPERADOR'
    ): bool {
        $sql = "INSERT INTO usuarios
                (nome, email, senha_hash, perfil)
                VALUES (:nome, :email, :hash, :perfil)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':hash' => $hash,
            ':perfil' => $perfil
        ]);
    }

    // Procura um usuário pelo e-mail
    public function buscarPorEmail(string $email): array|false
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);

        return $stmt->fetch();
    }

    // Registra uma tentativa de login
    public function registrarAuditoria(
        string $email,
        string $ip,
        string $navegador,
        bool $sucesso
    ): void {
        $sql = "INSERT INTO auditoria_logins
                (email, ip, user_agent, sucesso)
                VALUES (:email, :ip, :navegador, :sucesso)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':email' => $email,
            ':ip' => $ip,
            ':navegador' => $navegador,
            ':sucesso' => $sucesso
        ]);
    }

    // Busca os últimos acessos registrados
    public function ultimosAcessos(): array
    {
        $sql = "SELECT * FROM auditoria_logins
                ORDER BY data_hora DESC LIMIT 50";

        return $this->pdo->query($sql)->fetchAll();
    }
}