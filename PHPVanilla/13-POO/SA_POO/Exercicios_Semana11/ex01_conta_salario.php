<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

// Cria o titular
$titular = new Titular(
    'João Silva',
    '12345678900',
    'joao@email.com',
    '19999999999'
);

// Cria as contas do mesmo titular
$contaSalario = new ContaSalario(
    $titular,
    '12345678000199',
    1000.00
);

$contaCorrente = new ContaCorrente($titular, 200.00);

// Realiza depósito autorizado
$contaSalario->depositar(500.00, '12345678000199');

// Realiza três saques
$contaSalario->sacar(100.00);
$contaSalario->sacar(100.00);
$contaSalario->sacar(100.00);

// Transfere para outra conta do mesmo titular
$contaSalario->transferir(100.00, $contaCorrente);

// Exibe os saldos
echo "Conta salário: R$ ";
echo number_format($contaSalario->getSaldo(), 2, ',', '.') . PHP_EOL;

echo "Conta corrente: R$ ";
echo number_format($contaCorrente->getSaldo(), 2, ',', '.') . PHP_EOL;

// Testa depósito de empregador não autorizado
try {
    $contaSalario->depositar(100.00, '00000000000100');
} catch (DomainException $erro) {
    echo "Depósito bloqueado: " . $erro->getMessage() . PHP_EOL;
}