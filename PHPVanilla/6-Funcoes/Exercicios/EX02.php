<?php
declare(strict_types=1);

// Exercício 2: Classificação de IMC
// Crie a função classificarIMC(float $imc): string. Use if / elseif / else para retornar uma classificação:
// Menor que 18.5: Abaixo do peso;
// De 18.5 até 24.9: Peso normal;
// De 25.0 até 29.9: Sobrepeso;
// Igual ou maior que 30.0: Obesidade.

function classificarIMC(float $imc): string {
    if ($imc < 18.5) {
        return "Abaixo do peso";
    } elseif ($imc < 25.0) {
        return "Peso normal";
    } elseif ($imc < 30.0) {
        return "Sobrepeso";
    } else {
        return "Obesidade";
    }
}

echo classificarIMC(17.8) . "\n";
echo classificarIMC(22.5) . "\n";
echo classificarIMC(27.3) . "\n";
echo classificarIMC(31.2);
?>