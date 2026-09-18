<?php
declare(strict_types=1);

// Parte B: Exercícios Práticos no Laboratório
// Exercício 3: Caixa de Busca com Proteção em Atributos (Reflected XSS)

// Função usada para escapar os dados antes de mostrar na página
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

// Recebe o valor enviado pelo GET
$busca = $_GET["q"] ?? "";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Busca de Produtos</title>
</head>

<body>

<h1>Busca de Produtos</h1>

<form method="GET">

    <label for="q">Pesquisar:</label>

    <input
        type="text"
        id="q"
        name="q"
        value="<?= e($busca) ?>"
    >

    <button type="submit">Buscar</button>

</form>

<?php if ($busca !== ""): ?>

    <p>
        Você buscou por:
        <?= e($busca) ?>
    </p>

<?php endif; ?>

</body>
</html>