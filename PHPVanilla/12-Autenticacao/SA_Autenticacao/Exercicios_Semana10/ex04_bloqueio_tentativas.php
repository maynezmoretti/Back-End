<?php
declare(strict_types=1);

require_once 'includes/bootstrap.php';

// Inicializa as variáveis da sessão
$_SESSION['tentativas'] = $_SESSION['tentativas'] ?? 0;
$_SESSION['bloqueado_ate'] = $_SESSION['bloqueado_ate'] ?? 0;

$erro = '';

// Confere se o usuário está bloqueado
if (time() < $_SESSION['bloqueado_ate']) {
    $restante = $_SESSION['bloqueado_ate'] - time();
    $erro = "Aguarde $restante segundos para tentar novamente.";
}

// Processa o formulário
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Confere a proteção CSRF
    if (!validarCsrf()) {
        exit("Formulário inválido.");
    }

    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    // Busca o usuário no banco
    $usuario = $usuarioDAO->buscarPorEmail($email);

    // Verifica se a senha está correta
    if ($usuario && password_verify($senha, $usuario['senha_hash'])) {

        // Reseta as tentativas após login correto
        $_SESSION['tentativas'] = 0;
        $_SESSION['bloqueado_ate'] = 0;

        // Libera o usuário quando o bloqueio termina
        if (
            $_SESSION['bloqueado_ate'] > 0 &&
            time() >= $_SESSION['bloqueado_ate']
        ) {
            $_SESSION['tentativas'] = 0;
            $_SESSION['bloqueado_ate'] = 0;
        }

        // Regenera o ID da sessão
        session_regenerate_id(true);

        // Guarda os dados do usuário
        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nome' => $usuario['nome'],
            'perfil' => $usuario['perfil']
        ];

        $_SESSION['ultima_atividade'] = time();

        // Registra o login bem-sucedido
        $usuarioDAO->registrarAuditoria(
            $email,
            $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
            $_SERVER['HTTP_USER_AGENT'] ?? 'desconhecido',
            true
        );

        // Encaminha para a página de acesso
        header('Location: ex03_rbac_guard.php');
        exit;
    }

    // Soma uma tentativa incorreta
    $_SESSION['tentativas']++;

    // Registra o login que falhou
    $usuarioDAO->registrarAuditoria(
        $email,
        $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
        $_SERVER['HTTP_USER_AGENT'] ?? 'desconhecido',
        false
    );

    // Bloqueia por 60 segundos após três erros
    if ($_SESSION['tentativas'] >= 3) {
        $_SESSION['bloqueado_ate'] = time() + 60;
        $erro = "Muitas tentativas. Aguarde 60 segundos.";
    } else {
        $erro = "E-mail ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

    <h1>Login</h1>

    <!-- Mostra mensagens de erro -->
    <p><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></p>

    <!-- Formulário de acesso -->
    <form method="POST">
        <input type="hidden" name="csrf_token"
               value="<?= htmlspecialchars(tokenCsrf()) ?>">

        <label>E-mail:</label>
        <input type="email" name="email" required>

        <br><br>

        <label>Senha:</label>
        <input type="password" name="senha" required>

        <br><br>

        <button type="submit">Entrar</button>
    </form>

</body>
</html>