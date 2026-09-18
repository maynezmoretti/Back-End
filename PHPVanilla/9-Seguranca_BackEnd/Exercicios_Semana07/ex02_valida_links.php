<?php
declare(strict_types=1);

// Parte B: Exercícios Práticos no Laboratório
// Exercício 2: Validador de Links de Portfólio (Prevenção javascript:)

// Escapa os dados antes de colocar no HTML
function e(string $texto): string
{
    return htmlspecialchars(
        $texto,
        ENT_QUOTES | ENT_SUBSTITUTE,
        "UTF-8"
    );
}

$nome = "";
$link = "";
$linkValido = "";
$erros = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $link = trim($_POST["link"] ?? "");

    // Validação do nome
    if ($nome === "" || mb_strlen($nome) < 3) {
        $erros[] = "O nome deve ter pelo menos 3 caracteres.";
    }

    // Validação da URL
    if ($link === "") {

        $erros[] = "O link é obrigatório.";

    } elseif (filter_var($link, FILTER_VALIDATE_URL) === false) {

        $erros[] = "Digite uma URL válida.";

    } elseif (
        !str_starts_with($link, "http://") &&
        !str_starts_with($link, "https://")
    ) {

        // Aceita somente HTTP e HTTPS
        $erros[] = "O link deve usar HTTP ou HTTPS.";

    } else {

        $linkValido = $link;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Validador de Links</title>
</head>

<body>

<h1>Cadastro de Portfólio</h1>

<?php if (!empty($erros)): ?>

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
        value="<?= e($nome) ?>"
    >

    <br><br>

    <label for="link">Link do GitHub/LinkedIn:</label>

    <input
        type="text"
        id="link"
        name="link"
        value="<?= e($link) ?>"
    >

    <br><br>

    <button type="submit">Cadastrar</button>

</form>

<?php if ($linkValido !== ""): ?>

    <hr>

    <h2>Portfólio cadastrado</h2>

    <p>Nome: <?= e($nome) ?></p>

    <a href="<?= e($linkValido) ?>" target="_blank">
        Visitar Portfólio
    </a>

<?php endif; ?>

</body>
</html>