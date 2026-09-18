<?php
declare(strict_types=1);

// Parte B: Exercícios Práticos no Laboratório

// Exercício 1: Buscador de Produtos com Filtro de Preço (GET)

// Criamos um array com os produtos.
// Cada produto possui nome, categoria e preço.
$produtos = [

    [
        'nome' => 'Teclado USB',
        'categoria' => 'Eletrônicos',
        'preco' => 80.00
    ],

    [
        'nome' => 'Mouse sem fio',
        'categoria' => 'Eletrônicos',
        'preco' => 65.00
    ],

    [
        'nome' => 'Caderno',
        'categoria' => 'Papelaria',
        'preco' => 25.00
    ],

    [
        'nome' => 'Caneta azul',
        'categoria' => 'Papelaria',
        'preco' => 3.50
    ],

    [
        'nome' => 'Monitor 24 polegadas',
        'categoria' => 'Eletrônicos',
        'preco' => 899.90
    ],

    [
        'nome' => 'Mochila',
        'categoria' => 'Papelaria',
        'preco' => 150.00
    ]

];

// Pegamos o nome do produto enviado pelo formulário usando GET.
// Se o campo estiver vazio, usamos uma string vazia.
$buscaProduto = trim((string) ($_GET["produto"] ?? ""));

// Pegamos o preço máximo enviado pelo formulário.
// Se o campo estiver vazio, usamos uma string vazia.
$precoMaximoTexto = trim((string) ($_GET["preco_maximo"] ?? ""));

// Inicialmente, mostramos todos os produtos.
$produtosFiltrado = $produtos;

// Verificamos se pelo menos um dos filtros foi preenchido.
if ($buscaProduto !== "" || $precoMaximoTexto !== "") {

    // array_filter filtra os produtos de acordo com as condições abaixo.
    $produtosFiltrado = array_filter(

        $produtos,

        function (array $produto) use ($buscaProduto, $precoMaximoTexto): bool {

            // Começamos considerando que os dois filtros são verdadeiros.
            $nomeStatus = true;
            $precoStatus = true;

            // Filtro pelo nome do produto.
            if ($buscaProduto !== "") {

                // Verifica se o nome digitado aparece no nome do produto.
                // strtolower deixa os textos em letras minúsculas para facilitar a comparação.
                $nomeStatus = str_contains(
                    strtolower($produto["nome"]),
                    strtolower($buscaProduto)
                );
            }

            // Filtro pelo preço máximo.
            if ($precoMaximoTexto !== "") {

                // Converte o valor informado para um número.
                $precoMaximo = filter_var(
                    $precoMaximoTexto,
                    FILTER_VALIDATE_FLOAT
                );

                // Verifica se o preço é válido e se o produto
                // possui preço menor ou igual ao valor máximo.
                $precoStatus =
                    $precoMaximo !== false &&
                    $produto["preco"] <= $precoMaximo;
            }

            // O produto só será exibido se passar pelos dois filtros.
            return $nomeStatus && $precoStatus;
        }
    );
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Exercício 01</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <main>

        <h1>Exercício 01</h1>

        <section>

            <h2>Buscador de Produtos com Filtro de Preço (GET)</h2>

            <!-- Formulário utilizado para realizar a busca dos produtos -->
            <form method="GET">

                <!-- Campo para pesquisar pelo nome do produto -->
                <label for="produto">Nome do Produto</label>

                <input
                    type="text"
                    name="produto"
                    id="produto"
                    placeholder="Buscar Produto"
                    value="<?= htmlspecialchars($buscaProduto) ?>"
                >

                <!-- Campo para informar o preço máximo -->
                <label for="preco_maximo">Preço Máximo</label>

                <input
                    type="number"
                    name="preco_maximo"
                    id="preco_maximo"
                    step="0.01"
                    placeholder="100"
                    value="<?= htmlspecialchars($precoMaximoTexto) ?>"
                >

                <!-- Botão que envia o formulário -->
                <button type="submit">Pesquisar</button>

            </form>

            <h2>Lista de Produtos Filtrados</h2>

            <!-- Verifica se nenhum produto foi encontrado -->
            <?php if ($produtosFiltrado === []): ?>

                <p class="vazio">Nenhum produto encontrado.</p>

            <?php else: ?>

                <!-- Tabela para mostrar os produtos encontrados -->
                <table>

                    <thead>

                        <tr>

                            <th>Produto</th>

                            <th>Categoria</th>

                            <th>Preço</th>

                        </tr>

                    </thead>

                    <tbody>

                        <!-- Percorremos os produtos filtrados -->
                        <?php foreach ($produtosFiltrado as $produto): ?>

                            <tr>

                                <!-- Mostra o nome do produto -->
                                <td>
                                    <?= htmlspecialchars($produto['nome'], ENT_QUOTES, "UTF-8") ?>
                                </td>

                                <!-- Mostra a categoria do produto -->
                                <td>
                                    <?= htmlspecialchars($produto['categoria'], ENT_QUOTES, "UTF-8") ?>
                                </td>

                                <!-- Mostra o preço formatado em reais -->
                                <td>
                                    R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            <?php endif; ?>

        </section>

    </main>

</body>

</html>