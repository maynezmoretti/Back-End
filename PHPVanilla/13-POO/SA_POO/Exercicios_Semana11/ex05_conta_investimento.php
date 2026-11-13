<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

// Cria o titular
$titular = new Titular(
    'Pedro Costa',
    '44455566677',
    'pedro@email.com',
    '19955554444'
);

// Cria as contas
$investimento = new ContaInvestimento($titular);
$corrente = new ContaCorrente($titular, 100.00);

// Realiza o depósito inicial
$investimento->depositar(1000.00);

// Registra um rendimento
$investimento->registrarRendimento(100.00);

// Realiza o resgate
$investimento->resgatar(500.00, $corrente);

// Exibe os saldos finais
echo "Saldo do investimento: R$ ";
echo number_format($investimento->getSaldo(), 2, ',', '.') . PHP_EOL;

echo "Saldo da conta corrente: R$ ";
echo number_format($corrente->getSaldo(), 2, ',', '.') . PHP_EOL;