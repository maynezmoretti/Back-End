<!-- DESAFIO EM SALA: SIMULADOR DE COBRANÇA (FINANSENAI) -->

<?php

echo "Digite a categoria do cliente: ";
$categoriaCliente = readline();
$divida = 1000.00;
$mesesAtraso = 12;

// Definir a taxa de juros de acordo com a classificação do cliente

$taxaJuros = match ($categoriaCliente) {
    'A' => 0.01,
    'B' => 0.02,
    'C' => 0.03,
    default => 0.05
};

// Demonstrar a evolução da dívida ao longo de 12 meses

for ($mes = 1; $mes <= $mesesAtraso; $mes++) {

// Regra da Anistia

    if ($mes === 6) {
        echo "Mês $mes: Isenção de Juros\n";
        echo "Saldo: R$ " . number_format($divida, 2, ',', '.') . "\n";
        continue;
    }

    $juros = $divida * $taxaJuros;
    $divida = $divida + $juros;

    echo "Mês $mes:\n";
    echo "Juros: R$ " . number_format($juros, 2, ',', '.') . "\n";
    echo "Saldo: R$ " . number_format($divida, 2, ',', '.') . "\n";
}
?>