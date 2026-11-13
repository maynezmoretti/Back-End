<?php
declare(strict_types=1);

class ContaCorrente extends ContaBancaria
{
    public function __construct(Titular $titular, float $saldoInicial = 0.0)
    {
        // Inicializa a classe principal
        parent::__construct($titular, $saldoInicial);
    }

    // Realiza saque sem cobrança de taxa
    public function sacar(float $valor): void
    {
        $this->debitarComTaxa($valor);
    }
}