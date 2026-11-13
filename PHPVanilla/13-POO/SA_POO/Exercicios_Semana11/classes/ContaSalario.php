<?php
declare(strict_types=1);

class ContaSalario extends ContaBancaria
{
    // Controla a quantidade de saques realizados
    private int $saquesMes = 0;
    private string $mesAtual;

    public function __construct(
        Titular $titular,
        private readonly string $cnpjEmpregador,
        float $saldoInicial = 0.0
    ) {
        parent::__construct($titular, $saldoInicial);

        if ($cnpjEmpregador === '') {
            throw new OperacaoNaoAutorizadaException("CNPJ inválido.");
        }

        $this->mesAtual = date('Y-m');
    }

    // Aceita depósitos somente do empregador cadastrado
    public function depositar(float $valor, ?string $cnpjOrigem = null): void
    {
        if (!hash_equals($this->cnpjEmpregador, $cnpjOrigem ?? '')) {
            $this->registrarFalha('Depósito não autorizado', $valor);
            throw new OperacaoNaoAutorizadaException("Empregador não autorizado.");
        }

        parent::depositar($valor, $cnpjOrigem);
    }

    // Reinicia o contador quando começa um novo mês
    private function atualizarMes(): void
    {
        $mes = date('Y-m');

        if ($mes !== $this->mesAtual) {
            $this->saquesMes = 0;
            $this->mesAtual = $mes;
        }
    }

    // Controla os saques gratuitos e a taxa
    public function sacar(float $valor): void
    {
        $this->atualizarMes();
        $taxa = $this->saquesMes >= 2 ? 4.00 : 0.00;
        $this->debitarComTaxa($valor, $taxa);
        $this->saquesMes++;
    }
}