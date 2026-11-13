<?php
declare(strict_types=1);

require_once 'config/database.php';
require_once 'src/UsuarioDAO.php';

// Verifica se a senha atende aos requisitos
function validarSenha(string $senha): bool
{
    return strlen($senha) >= 8
        && preg_match('/[A-Z]/', $senha)
        && preg_match('/[a-z]/', $senha)
        && preg_match('/[0-9]/', $senha)
        && preg_match('/[^a-zA-Z0-9]/', $senha);
}

// Solicita os dados do colaborador
echo "CADASTRO DE COLABORADOR\n";

$nome = readline("Nome: ");
$email = readline("E-mail: ");
$senha = readline("Senha: ");

// Confere se os campos foram preenchidos
if (trim($nome) === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Nome ou e-mail inválido!\n");
}

// Confere a complexidade da senha
if (!validarSenha($senha)) {
    exit("Senha não atende aos requisitos!\n");
}

// Cria o hash seguro da senha
$hash = password_hash($senha, PASSWORD_ARGON2ID);

try {
    // Conecta ao banco e cadastra o colaborador
    $pdo = conectarBanco();
    $dao = new UsuarioDAO($pdo);

    $dao->criar($nome, $email, $hash, 'OPERADOR');

    echo "Colaborador cadastrado com sucesso!\n";
} catch (PDOException $erro) {
    echo "Erro ao cadastrar. Verifique se o e-mail já existe.\n";
}