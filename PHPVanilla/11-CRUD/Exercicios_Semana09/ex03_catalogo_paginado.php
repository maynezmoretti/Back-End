<?php
declare(strict_types=1);

// Evita que caracteres especiais sejam interpretados como HTML
function e(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}

// Estabelece a conexão com o banco de dados
$pdo = new PDO(
    "pgsql:host=localhost;dbname=almoxarifado_senai",
    "postgres",
    "postgres"
);

// Recebe o número da página pela URL
$pagina = (int) ($_GET['p'] ?? 1);

// Impede que o número da página seja menor que 1
if ($pagina < 1) {
    $pagina = 1;
}

// Define a partir de qual registro a consulta começa
$offset = ($pagina - 1) * 5;

// Busca as peças de acordo com a página selecionada
$sql = "SELECT * FROM pecas_industriais
        ORDER BY id
        LIMIT :limite OFFSET :offset";

$stmt = $pdo->prepare($sql);

// Define os valores dos parâmetros como números inteiros
$stmt->bindValue(':limite', 5, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();

// Exibe o título do catálogo
echo "<h1>Catálogo de peças industriais</h1>";

// Apresenta os dados de cada peça encontrada
while ($peca = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: " . e((string) $peca['id']) . "<br>";
    echo "Código SKU: " . e((string) $peca['codigo_sku']) . "<br>";
    echo "Descrição: " . e((string) $peca['descricao']) . "<br>";
    echo "Categoria: " . e((string) $peca['categoria']) . "<br>";
    echo "<hr>";
}

// Cria um link para acessar a próxima página
echo '<a href="?p=' . ($pagina + 1) . '">Próxima página</a>';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Peças</title>
</head>
<body>

    <!-- Formulário para selecionar a página do catálogo -->
    <h1>Catálogo de Peças Industriais</h1>

    <form action="ex03_catalogo_paginado.php" method="GET">
        <label for="p">Número da página:</label>
        <input type="number" id="p" name="p" min="1" value="1" required>

        <button type="submit">Consultar peças</button>
    </form>

</body>
</html>