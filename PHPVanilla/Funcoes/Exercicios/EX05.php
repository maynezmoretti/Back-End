<?php
declare(strict_types=1);

// Exercício 5: Carrinho de Compras
// Crie a função calcularCarrinho(array $produtos): float. Cada produto deve ser um array associativo com nome, preco e quantidade. Use foreach para calcular e retornar o total da compra.
// $produtos = [
//     ["nome" => "Caderno", "preco" => 25.00, "quantidade" => 2],
//     ["nome" => "Caneta", "preco" => 3.50, "quantidade" => 4]
// ];

function calcularCarrinho(array $produtos): float {
    $total = 0;

    foreach ($produtos as $produto) {
        $total += $produto["preco"] * $produto["quantidade"];
    }

    return $total;
}

$produtos = [
    ["nome" => "Caderno", "preco" => 25.00, "quantidade" => 2],
    ["nome" => "Caneta", "preco" => 3.50, "quantidade" => 4]
];

$total = calcularCarrinho($produtos);

echo "Total da compra: R$ " . number_format($total, 2, ",", ".");
?>