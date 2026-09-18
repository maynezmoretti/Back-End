<?php
declare(strict_types=1);

// Calculadora de Tarifas Logísticas
// Uma transportadora cobra valores diferentes por região. Use a expressão match (não use if/else nem switch) para resolver.
// Crie uma variável $siglaEstado (ex: "SP").
// Use o match para retornar o valor do frete para a variável $valorFrete:
// "SP", "RJ", "MG", "ES" ➔ Frete de R$ 35.00 (Região Sudeste - Dica: o match permite agrupar usando vírgula).
// "PR", "SC", "RS" ➔ Frete de R$ 45.00 (Região Sul).
// "BA", "CE", "PE" ➔ Frete de R$ 60.00 (Região Nordeste).
// Qualquer outra sigla (default) ➔ Frete de R$ 80.00 (Resto do Brasil).
// Exiba: "Para o estado X, o frete é R$ Y".

$siglaEstado = "SP";
$valorFrete = match($siglaEstado) {
    "SP", "RJ", "MG", "ES" => 35.00,
    "PR", "SC", "RS" => 45.00,
    "BA", "CE", "PE" => 60.00,
    default => 80.00
};

echo "Para o estado $siglaEstado, o frete é R$ " . number_format ($valorFrete, 2, ",", ".");
?>