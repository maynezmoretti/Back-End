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