<?php
declare(strict_types=1);

// Parte B: Exercícios Práticos no Laboratório
// Exercício 5: Chat Industrial com Tratamento de Emojis e Quebras de Linha

// Protege os dados antes de exibir no HTML
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

$arquivo = "chat.json";

// Cria o arquivo se ele ainda não existir
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([]));
}

// Lê as mensagens salvas
$conteudo = file_get_contents($arquivo);
$mensagens = json_decode($conteudo, true);

if (!is_array($mensagens)) {
    $mensagens = [];
}

$operador = "";
$mensagem = "";
$erros = [];
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $operador = trim($_POST["operador"] ?? "");
    $mensagem = trim($_POST["mensagem"] ?? "");

    // Verifica quem está enviando
    if ($operador === "") {
        $erros[] = "Selecione quem está enviando a mensagem.";
    }

    // Verifica a mensagem
    if ($mensagem === "") {

        $erros[] = "A mensagem é obrigatória.";

    } elseif (mb_strlen($mensagem) > 250) {

        $erros[] = "A mensagem deve ter no máximo 250 caracteres.";
    }

    // Salva a mensagem
    if (empty($erros)) {

        $mensagens[] = [
            "operador" => $operador,
            "mensagem" => $mensagem
        ];

        file_put_contents(
            $arquivo,
            json_encode(
                $mensagens,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            )
        );

        $sucesso = "Mensagem enviada com sucesso!";

        $operador = "";
        $mensagem = "";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Chat da Operação</title>
</head>

<body>

<h1>Chat da Operação</h1>

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

    <label for="operador">Quem está enviando:</label>

    <select id="operador" name="operador">

        <option value="">Selecione</option>

        <option
            value="Operador de Máquina"
            <?= $operador === "Operador de Máquina" ? "selected" : "" ?>
        >
            Operador de Máquina
        </option>

        <option
            value="Supervisor"
            <?= $operador === "Supervisor" ? "selected" : "" ?>
        >
            Supervisor
        </option>

    </select>

    <br><br>

    <label for="mensagem">Mensagem:</label>

    <br>

    <textarea
        id="mensagem"
        name="mensagem"
        maxlength="250"
        rows="5"
        cols="50"
    ><?= e($mensagem) ?></textarea>

    <br>

    <small>Máximo de 250 caracteres.</small>

    <br><br>

    <button type="submit">Enviar mensagem</button>

</form>

<hr>

<h2>Mensagens</h2>

<?php foreach ($mensagens as $item): ?>

    <div>

        <strong>
            <?= e($item["operador"]) ?>:
        </strong>

        <p>
            <?= nl2br(e($item["mensagem"])) ?>
        </p>

    </div>

    <hr>

<?php endforeach; ?>

</body>
</html>