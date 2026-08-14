<?php
declare(strict_types=1);

// Bilheteria Inteligente (Cinema)
// O cinema CineSenai possui regras de cobrança cumulativas. Você deve processar a compra de 1 ingresso.
// Regras de Negócio:
// O ingresso base custa R$ 40.00.
// Desconto do Dia da Semana (Use o match):
// Segunda e Terça: 20% de desconto no valor base.
// Quarta-feira: 50% de desconto no valor base.
// Quinta a Domingo: Valor normal (sem desconto).
// Desconto de Estudante (Use o if/else):
// Se a variável $isEstudante for true, o cliente tem direito a mais 50% de desconto sobre o valor que sobrou após o desconto do dia da semana.

$ingressoBase = 40.00;
$diaSemana = "Quarta";
$isEstudante = true;

$ingressoBase = match($diaSemana) {
    "Segunda", "Terça" => $ingressoBase * 0.8,
    "Quarta" => $ingressoBase * 0.5,
    "Quinta", "Sexta", "Sábado", "Domingo" => $ingressoBase
};

$descontoDia = $ingressoBase;

if($isEstudante === true) {
    $descontoDia = $descontoDia * 0.5;
} 

$valorFinal = $descontoDia;

echo "O valor final do ingresso ficou R$" . number_format($valorFinal, 2, ",", ".");
?>