<?php
declare(strict_types=1);

// ContaCorrente é uma subclasse de ContaBancaria
// Regras de Negócio: ChequeEspecial e Cobrança da taxa de saque

final class ContaCorrente extends ContaBancaria {
    // atributos que não existem na ContaBancaria
    public const TARIFA_SAQUE = 2.50;

    // substituir o construtor da ContaBancaria
    // ChequeEspecial -> quando criar a conta precisa declarar o cheque especial

    public function __construct(
        string $agencia,
        string $numeroConta,
        Titular $titular,
        float $saldoInicial = 0.0,
        private float $limiteChequeEspecial = 500.00)
    {
        parent::__construct($agencia, $numeroConta, $titular, $saldoInicial);
    }

    #[Override] // implementando o método
    public function sacar(float $valor): void {
        if($valor <= 0.0) {
            throw new ValorInvalidoException($valor);
        }

        $custoTotal = $valor + self::TARIFA_SAQUE;
        $saldoTotalDisponivel = $this->saldo + $this->limiteChequeEspecial;

        // se o valor do saque for maior que o saldo disponível lança uma exception
        if($custoTotal > $saldoTotalDisponivel) {
            throw new SaldoInsuficienteException($saldoTotalDisponivel, $custoTotal);
        }

        // se tudo estiver certo
        $this->saldo -= $custoTotal;
    }

    // método de acesso ao cheque especial
    public function getLimiteChequeEspecial(): float {
        return $this->limiteChequeEspecial;
    }
}