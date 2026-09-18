<?php
declare(strict_types=1);

// Exercício 10: Controle de Estoque
// Crie a função 
// retirarEstoque(array &$produto, int $quantidade): bool. 
// Use referência para atualizar o estoque original. Retorne true quando houver estoque suficiente e false quando a quantidade solicitada for inválida ou maior que o estoque. Teste uma retirada permitida e uma retirada recusada.

function retirarEstoque(array &$produto, int $quantidade): bool {
    if ($quantidade <= 0 || $quantidade > $produto["estoque"]) {
        return false;
    }

    $produto["estoque"] -= $quantidade;

    return true;
}

$produto = [
    "nome" => "Caderno",
    "estoque" => 10
];

// Retirada permitida
if (retirarEstoque($produto, 10)) {
    echo "Retirada permitida! \nEstoque: " . $produto["estoque"];
} else {
    echo "Retirada recusada!";
}
?>