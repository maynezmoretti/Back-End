<?php
declare(strict_types=1);

// Exercício 7: Relatório de Notas
// Crie as funções calcularMedia(array $notas): float e verificarAprovacao(float $media): string. Use count() para calcular a média e if / else para retornar Aprovado quando a média for maior ou igual a 7, ou Reprovado caso contrário. Mostre também a maior e a menor nota usando max() e min().

function calcularMedia(array $notas): float {
    return array_sum($notas) / count($notas);
}

function verificarAprovacao(float $media): string {
    if ($media >= 7) {
        return "Aprovado";
    } else {
        return "Reprovado";
    }
}

$notas = [8.0, 7.5, 6.0, 9.0];

$media = calcularMedia($notas);

echo "Média: " . number_format($media, 2, ",", ".") . "\n";
echo "Situação: " . verificarAprovacao($media) . "\n";
echo "Maior nota: " . max($notas) . "\n";
echo "Menor nota: " . min($notas);
?>