<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

// Cria o titular
$titular = new Titular(
    'Maria Oliveira',
    '98765432100',
    'maria@email.com',
    '19988887777'
);

// Cria a conta
$conta = new ContaCorrente($titular, 1000.00);

// Adiciona os três canais de notificação
$conta->adicionarNotificador(new NotificadorEmail());
$conta->adicionarNotificador(new NotificadorSMS());
$conta->adicionarNotificador(new NotificadorWhatsApp());

// Realiza um depósito
echo "Realizando depósito..." . PHP_EOL;
$conta->depositar(300.00);

// Realiza um saque
echo PHP_EOL . "Realizando saque..." . PHP_EOL;
$conta->sacar(100.00);

// Exibe o saldo
echo PHP_EOL . "Saldo atual: R$ ";
echo number_format($conta->getSaldo(), 2, ',', '.') . PHP_EOL;