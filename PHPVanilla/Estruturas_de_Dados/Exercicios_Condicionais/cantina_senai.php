<!-- DESAFIO FINAL — SISTEMA DE PEDIDOS COM MENU - Estruturas de Dados -->

<?php

$produtos = [
1 => ["Nome" => "Coxinha", "Preço" => 6.00, "Estoque" => 10],
2 => ["Nome" => "Suco", "Preço" => 5.00, "Estoque" => 8],
3 => ["Nome" => "Sanduíche", "Preço" => 12.00, "Estoque" => 5],
4 => ["Nome" => "Bolo", "Preço" => 7.50, "Estoque" => 6]
];

$pedido = [];
$opcao = 0;

do{
echo "==========CANTINA SENAI==========\n";
echo "Escolha a opção desejada:\n";
echo "1 - Listar produtos\n";
echo "2 - Adicionar produto ao pedido\n";
echo "3 - Exibir resumo do pedido\n";
echo "4 - Finalizar compra\n";
echo "0 - Sair sem finalizar\n";
echo "=================================\n";
$opcao = readline();

} while($opcao=="0");
?>