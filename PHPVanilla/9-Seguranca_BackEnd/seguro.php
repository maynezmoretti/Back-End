<?php
declare(strict_types=1);

// função para codificar escape contra XSS
function e(string $texto) : string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, "UTF-8");
}

$nome = trim($_GET ["nome"] ?? "");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página blindada contra XSS</title>
</head>
<body>
    <h1>Perfil do Usuário</h1>
    <!-- Blindando a função e(), os caracteres especiais são convertidos em entidades HTML inofensivas -->
    <p>Bem-vindo(a), <?= e($nome) ?></p>

    <form action="seguro.php" method="GET">
        <label for="">Digite seu nome:</label>
        <input type="text" name="nome" value="<?= e($nome) ?>">
        <button type="submit">Atualizar</button>
    </form>
</body>
</html>