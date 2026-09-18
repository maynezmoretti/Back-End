<?php
declare(strict_types=1);

// Parte B: Exercícios Práticos no Laboratório

// Exercício 5: Inscrição em Processo Seletivo (Validação Completa)

// Array que vai armazenar os erros encontrados no formulário
$erros = [];

// Variáveis que vão guardar os dados preenchidos pelo candidato
$nomeCandidato = "";
$idade = "";
$cursoDesejado = "";

// Começa como false porque os termos ainda não foram aceitos
$aceiteTermos = false;

// Lista com os cursos que podem ser escolhidos
$cursosPermitidos = [
    "Desenvolvimento de Sistemas",
    "Mecatrônica",
    "Redes"
];

// Verifica se o formulário foi enviado usando o método POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Pega o nome enviado pelo formulário
    // trim() remove espaços do começo e do final
    // (string) transforma o valor em texto
    // ?? "" usa vazio caso o campo não exista
    $nomeCandidato = trim(
        (string) ($_POST["nome_candidato"] ?? "")
    );

    // Pega a idade enviada pelo formulário
    $idadeTexto = trim(
        (string) ($_POST["idade"] ?? "")
    );

    // Pega o curso escolhido pelo candidato
    $cursoDesejado = trim(
        (string) ($_POST["curso_desejado"] ?? "")
    );

    // Verifica se o candidato marcou a caixa de aceite dos termos
    // isset() verifica se essa informação foi enviada
    $aceiteTermos = isset($_POST["aceite_termos"]);

        // Validação do Nome

        // strlen() conta a quantidade de caracteres do nome
        // Se tiver menos de 5 caracteres, será criado um erro
        if (strlen($nomeCandidato) < 5) {

            // Guarda a mensagem de erro dentro do array $erros
            $erros["nome_candidato"] =
                "O nome deve ter pelo menos 5 caracteres.";
        }

        // Validação da Idade

        // Verifica se o valor digitado é um número inteiro válido
        $idade = filter_var(
            $idadeTexto,
            FILTER_VALIDATE_INT
        );

    // Se não for um número inteiro válido
    if ($idade === false) {

        // Guarda a mensagem de erro
        $erros["idade"] =
            "Informe uma idade válida.";


    // Se a idade for válida, verifica se é menor que 16
    } elseif ($idade < 16) {

        // Guarda a mensagem de erro
        $erros["idade"] =
            "A idade deve ser maior ou igual a 16 anos.";
    }

        // Validação do Curso

        // Verifica se nenhum curso foi escolhido
        // OU se o curso escolhido não está na lista de cursos permitidos
        if (
            $cursoDesejado === "" ||
            !in_array($cursoDesejado, $cursosPermitidos, true)
        ) {

        // Guarda a mensagem de erro
        $erros["curso_desejado"] =
            "Selecione um curso válido.";
    }

        // Validação dos Termos

        // Verifica se a caixa de termos NÃO foi marcada
        if (!isset($_POST["aceite_termos"])) {

            // Guarda a mensagem de erro
            $erros["aceite_termos"] =
                "Você deve aceitar os termos para realizar a inscrição.";
        }
}

// Verifica se o formulário foi enviado e se não existe nenhum erro
if ($_SERVER["REQUEST_METHOD"] === "POST" && $erros === []) {

    // Aqui significa que todos os dados foram preenchidos corretamente
    // e que o candidato aceitou os termos

    // Mostra uma mensagem de sucesso
    echo "Inscrição realizada com sucesso!";

    // Mostra o nome do candidato
    echo $nomeCandidato;

    // Mostra a idade
    echo $idade;

    // Mostra o curso escolhido
    echo $cursoDesejado;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Inscrição SENAI</title>
    <style>
        .erro {
            color: red;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .sucesso {
            color: green;
            margin-top: 20px;
        }
    </style>
</head>
    <body>
        <main>
            <h1>Inscrição para Curso Técnico</h1>

        <form method="POST">

        <!-- Nome -->

        <label for="nome_candidato">
            Nome do candidato
        </label>

        <input
            type="text"
            name="nome_candidato"
            id="nome_candidato"
            placeholder="Digite seu nome"
            value="<?= htmlspecialchars($nomeCandidato) ?>"
        >

        <?php if (isset($erros["nome_candidato"])): ?>

            <div class="erro">
                <?= htmlspecialchars($erros["nome_candidato"]) ?>
            </div>

        <?php endif; ?>


        <!-- Idade -->

        <label for="idade">
            Idade
        </label>

        <input
            type="number"
            name="idade"
            id="idade"
            min="16"
            placeholder="Digite sua idade"
            value="<?= htmlspecialchars((string) $idade) ?>"
        >

        <?php if (isset($erros["idade"])): ?>

            <div class="erro">
                <?= htmlspecialchars($erros["idade"]) ?>
            </div>

        <?php endif; ?>


        <!-- Curso -->

        <label for="curso_desejado">
            Curso desejado
        </label>

        <select
            name="curso_desejado"
            id="curso_desejado"
        >

            <option value="">
                Selecione um curso
            </option>

            <?php foreach ($cursosPermitidos as $curso): ?>

                <option
                    value="<?= htmlspecialchars($curso) ?>"
                    <?= $cursoDesejado === $curso ? "selected" : "" ?>
                >
                    <?= htmlspecialchars($curso) ?>
                </option>

            <?php endforeach; ?>

        </select>

        <?php if (isset($erros["curso_desejado"])): ?>

            <div class="erro">
                <?= htmlspecialchars($erros["curso_desejado"]) ?>
            </div>

        <?php endif; ?>


        <!-- Termos -->

        <label>
            <input
                type="checkbox"
                name="aceite_termos"
                value="1"
                <?= $aceiteTermos ? "checked" : "" ?>
            >

            Aceito os termos da inscrição
        </label>

        <?php if (isset($erros["aceite_termos"])): ?>

            <div class="erro">
                <?= htmlspecialchars($erros["aceite_termos"]) ?>
            </div>

        <?php endif; ?>


        <button type="submit">
            Inscrever-se
        </button>

    </form>


    <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && $erros === []): ?>

        <div class="sucesso">

            <h2>Inscrição realizada com sucesso!</h2>

            <p>
                Candidato:
                <?= htmlspecialchars($nomeCandidato) ?>
            </p>

            <p>
                Idade:
                <?= htmlspecialchars((string) $idade) ?>
            </p>

            <p>
                Curso:
                <?= htmlspecialchars($cursoDesejado) ?>
            </p>

        </div>

            <?php endif; ?>

        </main>
    </body>
</html>