<?php
declare(strict_types=1);

// Parte B: Exercícios Práticos no Laboratório
// Exercício 3: Caixa de Busca com Proteção em Atributos (Reflected XSS)

// Função para proteger os dados antes de mostrar no HTML
function e(string $texto): string
{
    return htmlspecialchars(
        $texto,
        ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5,
        "UTF-8"
    );
}

// Captura o termo pesquisado pela URL
$busca = $_GET['q'] ?? '';

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Busca Blindada</title>
</head>
<body>

    <h1>Busca de Produtos</h1>

    <form method="GET">
        <input
            type="text"
            name="q"
            value="<?= e($busca) ?>"
        >

        <button type="submit">Buscar</button>
    </form>

    <?php if ($busca !== ''): ?>

        <p>
            Você buscou por:
            <?= e($busca) ?>
        </p>

    <?php endif; ?>

</body>
</html>