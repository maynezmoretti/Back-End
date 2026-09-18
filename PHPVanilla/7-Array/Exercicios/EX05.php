<?php
declare (strict_types=1);

// Exercício 5: Black Friday no E-commerce (Mapeamento)

$carrinho = [
    ["produto" => "Notebook", "preco" => 4000.00],
    ["produto" => "Mouse", "preco" => 150.00],
    ["produto" => "Teclado", "preco" => 300.00]
];

$carrinhoBlackFriday = array_map(
    fn($item) => [
        "produto" => $item["produto"],
        "preco" => $item["preco"] * 0.80
    ],
    $carrinho
);

foreach ($carrinhoBlackFriday as $item) {
    echo "Produto: " . $item["produto"] . "\n";
    echo "Novo preço: R$ " . number_format($item["preco"], 2, ",", ".") . "\n";
}
?>