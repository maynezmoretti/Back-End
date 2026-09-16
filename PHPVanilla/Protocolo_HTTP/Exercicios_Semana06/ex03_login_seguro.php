<?php
declare(strict_types=1);

// Parte B: Exercícios Práticos no Laboratório

// Exercício 3: Painel de Autenticação Segura (POST)

// Declaração das variáveis 
$email = "";
$loginValidado = false;
$erros = [];

// Pegar os dados do formulário
// Verificar se o formulário está enviando os dados como post
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $email = trim($_POST["email"] ?? ""); // limpar os espaços vazios antes e depois do texto
    $senha = trim($_POST["senha"] ?? "");

    // Validação de dados (encontrando erros)
    // Erro de email
    if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erros["email"] = "Informe um email válido";
    }

    // Erro de senha
    if (strlen($senha) < 6){
        $erros["senha"] = "A senha deve ter no mínimo 6 dígitos";
    }

    // Se a senha e o email estiverem 'ok'
    if (empty($erros)){
        $emailCorreto = "admin@senai.br";
        $senhaCorreta = "senhaSegura123";
    
        // Validando o email e a senha
        if ($email === $emailCorreto && $senha == $senhaCorreta){
            $loginValidado = true;
        } else {
            $erros["login"] = "Credenciais inválidas";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Seguro</title>

    <style>
        body { font-family: Arial, sans-serif; background: #eef2f7; padding: 30px; }
        .card { max-width: 420px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        label { display: block; margin-bottom: 6px; font-weight: bold; }
        input { width: 100%; padding: 10px; margin-bottom: 12px; box-sizing: border-box; }
        .erro { color: #c0392b; font-size: 0.9em; margin-top: -8px; margin-bottom: 10px; }
        .sucesso { background: #e7f9ee; color: #1f8a4c; padding: 12px; border-radius: 8px; font-weight: bold; }
        .alerta { background: #fdecea; color: #b42318; padding: 12px; border-radius: 8px; margin-bottom: 15px; }
    </style>

</head>
<body>

    <div class="card">
        <h2>Login do Sistema</h2>
        <?php if(isset($erros["login"])): ?> 
            <div class="alerta"><?=  htmlspecialchars($erros["login"], ENT_QUOTES, "UTF-8") ?></div>    
        <?php endif; ?>
        
        <?php if($loginValidado): ?> 
            <div class="sucesso">Bem-vindo(a), Admin!!!</div>    
        <?php else: ?>
            <form method="POST">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($email, ENT_QUOTES, "UTF-8") ?>">
                <?php if(isset($erros["email"])): ?>
                    <div class="erro"><?= htmlspecialchars($erros["email"], ENT_QUOTES, "UTF-8") ?></div>
                <?php endif; ?>
                
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" value="">
                <?php if(isset($erros["senha"])): ?>
                    <div class="erro"><?= htmlspecialchars($erros["senha"], ENT_QUOTES, "UTF-8") ?></div>
                <?php endif; ?>

                <button type="submit">Entrar</button>

            </form>
        <?php endif; ?>
    </div>
</body>
</html>