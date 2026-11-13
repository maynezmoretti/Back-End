<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

// Cria o titular
$titular = new Titular(
    'Carlos Santos',
    '11122233344',
    'carlos@email.com',
    '19977776666'
);

// Cria a conta
$conta = new ContaCorrente($titular, 500.00);

// Realiza movimentações
$conta->depositar(200.00);
$conta->sacar(100.00);
$conta->depositar(300.00);

// Testa uma operação inválida
try {
    $conta->depositar(-50.00);
} catch (ValorInvalidoException $erro) {
    echo "Operação bloqueada: " . $erro->getMessage() . PHP_EOL;
}

// Recupera o extrato
$extrato = $conta->getExtrato();

// Exibe o relatório
echo PHP_EOL . "========== EXTRATO BANCÁRIO ==========" . PHP_EOL;
echo "Titular: " . $titular->getNome() . PHP_EOL;
echo "--------------------------------------" . PHP_EOL;

foreach ($extrato as $transacao) {
    echo "Tipo: " . $transacao->getTipo() . PHP_EOL;

    echo "Valor: R$ ";
    echo number_format($transacao->getValor(), 2, ',', '.') . PHP_EOL;

    echo "Data: ";
    echo $transacao->getDataHora()->format('d/m/Y H:i:s') . PHP_EOL;

    echo "Situação: ";
    echo $transacao->getSucesso() ? "Sucesso" : "Falhou";
    echo PHP_EOL . "--------------------------------------" . PHP_EOL;
}

// Exibe o saldo final
echo "Saldo final: R$ ";
echo number_format($conta->getSaldo(), 2, ',', '.') . PHP_EOL;