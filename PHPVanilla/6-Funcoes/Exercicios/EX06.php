<?php
declare(strict_types=1);

// Exercício 6: Aplicação de Desconto por Referência
// Crie a função aplicarDesconto(float &$preco, float $porcentagem): void. Altere o preço original usando referência. Teste com um produto de R$ 200,00 e desconto de 15%, exibindo o valor antes e depois da chamada.

function aplicarDesconto(float &$preco, float $porcentagem): void {
    $preco = $preco - ($preco * $porcentagem / 100);
}

$preco = 200.00;

echo "Antes do desconto: R$ " . number_format($preco, 2, ",", ".") . "\n";

aplicarDesconto($preco, 15);

echo "Depois do desconto: R$ " . number_format($preco, 2, ",", ".");
?>