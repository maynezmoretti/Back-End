<?php
declare(strict_types=1);

// Parte B: Exercícios Práticos no Laboratório
// Exercício 1: Mural de Recados Blindado (Stored XSS)

// Função para proteger os dados exibidos na página
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

$arquivo = "mural.json";

// Cria o arquivo caso ele ainda não exista
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([]));
}

// Lê os recados salvos
$conteudo = file_get_contents($arquivo);
$recados = json_decode($conteudo, true);

// Se o arquivo estiver vazio ou com problema, começa com um array vazio
if (!is_array($recados)) {
    $recados = [];
}

$nome = "";
$mensagem = "";
$erros = [];
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $mensagem = trim($_POST["mensagem"] ?? "");

    // Validação do nome
    if ($nome === "") {
        $erros[] = "O nome é obrigatório.";
    }

    // Validação da mensagem
    if ($mensagem === "") {
        $erros[] = "A mensagem é obrigatória.";
    }

    // Salva o recado se não houver erros
    if (empty($erros)) {

        $recados[] = [
            "nome" => $nome,
            "mensagem" => $mensagem
        ];

        file_put_contents(
            $arquivo,
            json_encode($recados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        $sucesso = "Recado enviado com sucesso!";

        $nome = "";
        $mensagem = "";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Mural de Recados</title>
</head>

<body>

<h1>Mural de Recados</h1>

<?php if (!empty($erros)): ?>
    <ul>
        <?php foreach ($erros as $erro): ?>
            <li><?= e($erro) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($sucesso !== ""): ?>
    <p><?= e($sucesso) ?></p>
<?php endif; ?>

<form method="POST">

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?= e($nome) ?>">

    <br><br>

    <label for="mensagem">Mensagem:</label>
    <br>
    <textarea id="mensagem" name="mensagem"><?= e($mensagem) ?></textarea>

    <br><br>

    <button type="submit">Enviar</button>

</form>

<hr>

<h2>Recados</h2>

<?php foreach ($recados as $recado): ?>

    <div>
        <strong><?= e($recado["nome"]) ?>:</strong>

        <p><?= nl2br(e($recado["mensagem"])) ?></p>
    </div>

    <hr>

<?php endforeach; ?>

</body>
</html>