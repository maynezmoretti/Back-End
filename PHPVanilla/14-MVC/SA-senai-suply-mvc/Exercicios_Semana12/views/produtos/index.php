<?php
declare(strict_types=1);

$categoria = $categoria ?? '';
$produtos = $produtos ?? [];

function e(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Produtos</title>
</head>
<body>
    <h1>Catálogo de Produtos</h1>

    <form method="GET" action="/produtos">
        <label for="categoria">Categoria:</label>
        <input
            type="text"
            name="categoria"
            id="categoria"
            value="<?= e((string) $categoria) ?>"
        >
        <button type="submit">Filtrar</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= e((string) $produto['id']) ?></td>
                    <td><?= e((string) $produto['nome']) ?></td>
                    <td><?= e((string) $produto['categoria']) ?></td>
                    <td>
                        <form
                            method="POST"
                            action="/produtos/excluir"
                            onsubmit="return confirm('Deseja excluir este produto?')"
                        >
                            <input
                                type="hidden"
                                name="id"
                                value="<?= e((string) $produto['id']) ?>"
                            >
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
