<?php
declare(strict_types=1);

// Parte B: Exercícios Práticos no Laboratório
// Exercício 2: Validador de Links de Portfólio (Prevenção javascript:)

// Protege os dados que serão exibidos no HTML
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

$nome = "";
$link = "";
$linkValido = "";
$erros = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $link = trim($_POST["link"] ?? "");

    // Verifica o nome
    if ($nome === "") {
        $erros[] = "O nome é obrigatório.";
    }

    // Verifica o link
    if ($link === "") {

        $erros[] = "O link é obrigatório.";

    } else {

        // Verifica se a URL possui um formato válido
        if (filter_var($link, FILTER_VALIDATE_URL) === false) {

            $erros[] = "Digite uma URL válida.";

        } elseif (
            !str_starts_with($link, "http://") &&
            !str_starts_with($link, "https://")
        ) {

            // Bloqueia protocolos como javascript:
            $erros[] = "O link deve começar com http:// ou https://.";

        } else {

            $linkValido = $link;
        }
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
    <input type="text" id="nome" name="nome" value="<?= e($nome) ?>">

    <br><br>

    <label for="link">Link do GitHub/LinkedIn:</label>
    <input type="text" id="link" name="link" value="<?= e($link) ?>">

    <br><br>

    <button type="submit">Cadastrar</button>

</form>

<?php if ($linkValido !== ""): ?>

    <hr>

    <h2>Portfólio cadastrado</h2>

    <p>Nome: <?= e($nome) ?></p>

    <a href="<?= e($linkValido) ?>" target="_blank">
        Visitar portfólio
    </a>

<?php endif; ?>

</body>
</html>