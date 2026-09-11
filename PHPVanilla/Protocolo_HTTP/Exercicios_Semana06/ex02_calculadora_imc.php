<?php
declare(strict_types=1);

// Parte B: Exercícios Práticos no Laboratório

// Exercício 2: Calculadora de IMC Interativa (POST)

// Array que guarda as mensagens de erro
$erros = [];

// Guarda a mensagem de sucesso
$mensagemSucesso = "";

// Variáveis usadas no formulário
$nome = "";
$peso = "";
$altura = "";

// Guarda o resultado do IMC
$imc = null;

// Guarda a classificação do IMC
$classificacao = "";

// Guarda a classe CSS do resultado
$classeIMC = "";

// Função responsável por calcular o IMC
function calcularIMC(float $peso, float $altura): float
{
    return $peso / ($altura ** 2);
}

// Função responsável por classificar o resultado do IMC
function classificarIMC(float $imc): string
{
    if ($imc < 18.5) {
        return "Abaixo do peso";
    }

    if ($imc < 25) {
        return "Normal";
    }

    if ($imc < 30) {
        return "Sobrepeso";
    }

    return "Obesidade";
}

// Verifica se o formulário foi enviado pelo método POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recebe os dados enviados pelo formulário
    $nome = trim((string) ($_POST["nome"] ?? ""));
    $pesoTexto = trim((string) ($_POST["peso"] ?? ""));
    $alturaTexto = trim((string) ($_POST["altura"] ?? ""));

    // Validação do nome
    if ($nome === "") {
        $erros["nome"] = "Informe o nome.";
    }

    // Validação do peso
    $peso = filter_var($pesoTexto, FILTER_VALIDATE_FLOAT);

    if ($peso === false) {

        // Caso o peso não seja válido
        $erros["peso"] = "Informe um peso válido.";
        $peso = "";

    } elseif ($peso < 20 || $peso > 300) {

        // Verifica se o peso está dentro do limite permitido
        $erros["peso"] = "O peso deve estar entre 20 e 300 kg.";
    }

    // Validação da altura
    $altura = filter_var($alturaTexto, FILTER_VALIDATE_FLOAT);

    if ($altura === false) {

        // Caso a altura não seja válida
        $erros["altura"] = "Informe uma altura válida.";
        $altura = "";

    } elseif ($altura < 0.5 || $altura > 2.5) {

        // Verifica se a altura está dentro do limite permitido
        $erros["altura"] = "A altura deve estar entre 0,5 e 2,5 metros.";
    }

    // Se não houver nenhum erro, o IMC será calculado
    if ($erros === []) {

        // Calcula o IMC usando a função criada anteriormente
        $imc = calcularIMC((float) $peso, (float) $altura);

        // Classifica o resultado do IMC
        $classificacao = classificarIMC($imc);

        // Define a classe CSS de acordo com o resultado
        if ($imc < 25) {
            $classeIMC = "normal";

        } elseif ($imc < 30) {
            $classeIMC = "sobrepeso";

        } else {
            $classeIMC = "obesidade";
        }

        // Exibe uma mensagem de sucesso
        $mensagemSucesso = "Cálculo realizado com sucesso!";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cálculo de IMC</title>

    <style>

        /* Estilo geral da área do resultado */
        .resultado {
            padding: 15px;
            margin-top: 20px;
            border-radius: 8px;
        }

        /* Estilo para resultado normal */
        .normal {
            background-color: #d4edda;
            color: #155724;
        }

        /* Estilo para sobrepeso */
        .sobrepeso {
            background-color: #fff3cd;
            color: #856404;
        }

        /* Estilo para obesidade */
        .obesidade {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Estilo das mensagens de erro */
        .erro {
            color: #dc3545;
            margin: 5px 0 10px;
        }

        /* Estilo da mensagem de sucesso */
        .sucesso {
            color: #155724;
            margin-top: 15px;
        }

    </style>

</head>

<body>

<main>

    <h1>Cálculo de IMC</h1>

    <section>

        <h2>Cadastro</h2>

        <!-- Formulário que envia os dados pelo método POST -->
        <form action="index.php" method="POST">

            <!-- Campo para informar o nome -->
            <label for="nome">Nome</label>

            <input
                type="text"
                name="nome"
                id="nome"
                placeholder="Digite seu nome"
                value="<?= htmlspecialchars($nome) ?>"
            >

            <!-- Mostra o erro do nome, caso exista -->
            <?php if (isset($erros["nome"])): ?>

                <div class="erro">
                    <?= htmlspecialchars($erros["nome"]) ?>
                </div>

            <?php endif; ?>


            <!-- Campo para informar o peso -->
            <label for="peso">Peso (kg)</label>

            <input
                type="number"
                name="peso"
                id="peso"
                step="0.01"
                min="20"
                max="300"
                placeholder="Ex: 80"
                value="<?= htmlspecialchars((string) $peso) ?>"
            >

            <!-- Mostra o erro do peso, caso exista -->
            <?php if (isset($erros["peso"])): ?>

                <div class="erro">
                    <?= htmlspecialchars($erros["peso"]) ?>
                </div>

            <?php endif; ?>


            <!-- Campo para informar a altura -->
            <label for="altura">Altura (m)</label>

            <input
                type="number"
                name="altura"
                id="altura"
                step="0.01"
                min="0.5"
                max="2.5"
                placeholder="Ex: 1.80"
                value="<?= htmlspecialchars((string) $altura) ?>"
            >

            <!-- Mostra o erro da altura, caso exista -->
            <?php if (isset($erros["altura"])): ?>

                <div class="erro">
                    <?= htmlspecialchars($erros["altura"]) ?>
                </div>

            <?php endif; ?>


            <!-- Botão para enviar o formulário -->
            <button type="submit">
                Calcular IMC
            </button>

        </form>


        <!-- Mostra a mensagem de sucesso após o cálculo -->
        <?php if ($mensagemSucesso !== ""): ?>

            <div class="sucesso">
                <?= htmlspecialchars($mensagemSucesso) ?>
            </div>

        <?php endif; ?>


        <!-- Mostra o resultado somente quando o IMC foi calculado -->
        <?php if ($imc !== null): ?>

            <div class="resultado <?= $classeIMC ?>">

                <h2>Resultado</h2>

                <p>
                    Nome:
                    <?= htmlspecialchars($nome) ?>
                </p>

                <p>
                    IMC:
                    <?= number_format($imc, 2, ',', '.') ?>
                </p>

                <p>
                    Classificação:
                    <?= htmlspecialchars($classificacao) ?>
                </p>

            </div>

        <?php endif; ?>

    </section>

</main>

</body>

</html>