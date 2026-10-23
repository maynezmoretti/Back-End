<?php
declare(strict_types=1);

// Super Classe Abstrata de Conta Bancaria -> Não permite instanciamento

abstract class ContaBancaria {
    // atributo
    protected float $saldo;

    // construtor da classe usando property promotion (declaro os atributos dentro do construtor)
    public function __construct (
        public readonly string $agencia, // atributo que receberá a agência
        public readonly string $numeroConta, // atributo que receberá o número da conta
        public readonly Titular $titular, // atributo que receberá os dados do titular (Classe Titular)
        float $saldoInicial = 0.0
    ) {
        if($saldoInicial < 0.0) { // lança uma exception caso o valor do saldo inicial seja negativo
            throw new ValorInvalidoException($saldoInicial);
        }
        $this->saldo = $saldoInicial;
    }

    // método para depositar na conta (adicionar ao saldo)
    public function depositar(float $valor): void {
        if($valor <= 0.0){ // se o valor for negativo lança uma exception
            throw new ValorInvalidoException($valor);
        }
        // se tudo der certo
        // $this->saldo = $this->saldo + $valor;
        $this->saldo += $valor;
    }

    // método abstrato: cada subclasse define sua política de saque
    abstract public function sacar(float $valor): void;

    // Criar um método com polimorfismo
    // método de transferência entre contas
    public function transferir (float $valor, ContaBancaria $contaDestino): void {
        if($this === $contaDestino) { // se a conta que estou transferindo for igual a conta de destino lança uma exception
            throw new ValorInvalidoException($valor);
        }

        // se tudo estiver certo
        // realizar o saque da conta de origem
        $this->sacar($valor);
        // depositar na conta de Destino
        $contaDestino->depositar($valor);
    }

    // consulta o saldo (getter)
    public function getSaldo(): float {
        return $this->saldo;
    }
}