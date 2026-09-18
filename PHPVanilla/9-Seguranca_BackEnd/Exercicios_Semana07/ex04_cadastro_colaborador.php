<?php
declare(strict_types=1);

// Parte B: Exercícios Práticos no Laboratório
// Exercício 4: Sanitizador de Cadastro de Colaboradores

// Remove espaços desnecessários e tags HTML
function sanitizarTexto(string $dado): string
{
    return trim(strip_tags($dado));
}

// Valida os dados do colaborador
function validarColaborador(array $dados): array
{
    $erros = [];

    // Validação do nome
    if ($dados["nome"] === "") {
        $erros["nome"] = "O nome é obrigatório.";
    }

    // Validação do e-mail
    if ($dados["email"] === "") {

        $erros["email"] = "O e-mail é obrigatório.";

    } elseif (filter_var($dados["email"], FILTER_VALIDATE_EMAIL) === false) {

        $erros["email"] = "Digite um e-mail válido.";
    }

    // Validação da matrícula
    if ($dados["matricula"] === "") {

        $erros["matricula"] = "A matrícula é obrigatória.";

    } elseif (filter_var($dados["matricula"], FILTER_VALIDATE_INT) === false) {

        $erros["matricula"] = "A matrícula deve ser um número inteiro.";
    }

    // Validação do salário
    if ($dados["salario"] === "") {

        $erros["salario"] = "O salário é obrigatório.";

    } elseif (filter_var($dados["salario"], FILTER_VALIDATE_FLOAT) === false) {

        $erros["salario"] = "O salário deve ser um número decimal.";
    }

    return $erros;
}

// Protege os dados na hora de exibir no HTML
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

$dados = [
    "nome" => "",
    "email" => "",
    "matricula" => "",
    "salario" => ""
];

$erros = [];
$cadastroRealizado = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recebe e sanitiza os dados
    $dados["nome"] = sanitizarTexto($_POST["nome"] ?? "");
    $dados["email"] = sanitizarTexto($_POST["email"] ?? "");
    $dados["matricula"] = sanitizarTexto($_POST["matricula"] ?? "");
    $dados["salario"] = sanitizarTexto($_POST["salario"] ?? "");

    // Faz as validações
    $erros = validarColaborador($dados);

    if (empty($erros)) {
        $cadastroRealizado = true;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Colaborador</title>
</head>

<body>

<h1>Cadastro de Colaborador</h1>

<?php if (!empty($erros)): ?>

    <h2>Erros encontrados:</h2>

    <ul>

        <?php foreach ($erros as $erro): ?>

            <li><?= e($erro) ?></li>

        <?php endforeach; ?>

    </ul>

<?php endif; ?>

<form method="POST">

    <label for="nome">Nome:</label>
    <input
        type="text"
        id="nome"
        name="nome"
        value="<?= e($dados["nome"]) ?>"
    >

    <br><br>

    <label for="email">E-mail:</label>
    <input
        type="text"
        id="email"
        name="email"
        value="<?= e($dados["email"]) ?>"
    >

    <br><br>

    <label for="matricula">Matrícula:</label>
    <input
        type="text"
        id="matricula"
        name="matricula"
        value="<?= e($dados["matricula"]) ?>"
    >

    <br><br>

    <label for="salario">Salário:</label>
    <input
        type="text"
        id="salario"
        name="salario"
        value="<?= e($dados["salario"]) ?>"
    >

    <br><br>

    <button type="submit">Cadastrar</button>

</form>

<?php if ($cadastroRealizado): ?>

    <hr>

    <h2>Cadastro realizado com sucesso!</h2>

    <p>
        <strong>Nome:</strong>
        <?= e($dados["nome"]) ?>
    </p>

    <p>
        <strong>E-mail:</strong>
        <?= e($dados["email"]) ?>
    </p>

    <p>
        <strong>Matrícula:</strong>
        <?= e($dados["matricula"]) ?>
    </p>

    <p>
        <strong>Salário:</strong>
        R$ <?= e($dados["salario"]) ?>
    </p>

<?php endif; ?>

</body>
</html>