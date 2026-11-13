<?php
declare(strict_types=1);

abstract class ContaBancaria
{
    protected array $historico = [];
    private array $notificadores = [];
    private float $saldo;

    public function __construct(
        private readonly Titular $titular,
        float $saldoInicial = 0.0
    ) {
        if (!is_finite($saldoInicial) || $saldoInicial < 0) {
            throw new ValorInvalidoException("Saldo inicial inválido.");
        }

        $this->saldo = $saldoInicial;
    }

    // Retorna o saldo atual
    public function getSaldo(): float
    {
        return $this->saldo;
    }

    // Retorna o titular
    public function getTitular(): Titular
    {
        return $this->titular;
    }

    // Adiciona um notificador
    public function adicionarNotificador(
        NotificadorInterface $notificador
    ): void {
        $this->notificadores[] = $notificador;
    }

    // Envia notificações
    protected function notificarTodos(string $mensagem): void
    {
        foreach ($this->notificadores as $notificador) {
            try {
                $notificador->notificar($this->titular, $mensagem);
            } catch (Throwable) {
                continue;
            }
        }
    }

    // Valida valores
    protected function validarValor(float $valor): void
    {
        if (!is_finite($valor) || $valor <= 0) {
            throw new ValorInvalidoException("Valor inválido.");
        }
    }

    // Registra uma transação
    protected function registrarTransacao(
        string $tipo,
        float $valor,
        bool $sucesso
    ): void {
        $this->historico[] = new Transacao(
            $tipo,
            $valor,
            new DateTimeImmutable(),
            $sucesso
        );
    }

    // Registra uma operação que falhou
    protected function registrarFalha(
        string $tipo,
        float $valor
    ): void {
        $this->registrarTransacao($tipo, $valor, false);
    }

    // Valida um crédito
    protected function validarCreditoInterno(float $valor): void
    {
        $this->validarValor($valor);

        if (!is_finite($this->saldo + $valor)) {
            throw new ValorInvalidoException("Valor acima do limite.");
        }
    }

    // Verifica se a conta pode receber um valor
    public function validarRecebimento(float $valor): void
    {
        $this->validarCreditoInterno($valor);
    }

    // Realiza um crédito
    protected function creditarMovimentacao(
        float $valor,
        string $tipo
    ): void {
        try {
            $this->validarCreditoInterno($valor);
        } catch (DomainException $erro) {
            $this->registrarFalha($tipo, $valor);
            throw $erro;
        }

        $this->saldo += $valor;
        $this->registrarTransacao($tipo, $valor, true);
        $this->notificarTodos("$tipo realizado.");
    }

    // Valida um débito
    protected function validarDebito(
        float $valor,
        float $taxa
    ): void {
        $this->validarValor($valor);

        if (!is_finite($taxa) || $taxa < 0) {
            throw new ValorInvalidoException("Taxa inválida.");
        }

        if ($this->saldo < $valor + $taxa) {
            throw new SaldoInsuficienteException("Saldo insuficiente.");
        }
    }

    // Realiza um débito com taxa
    protected function debitarComTaxa(
        float $valor,
        float $taxa = 0.0,
        string $tipo = 'Saque'
    ): void {
        try {
            $this->validarDebito($valor, $taxa);
        } catch (DomainException $erro) {
            $this->registrarFalha($tipo, $valor);
            throw $erro;
        }

        $total = $valor + $taxa;
        $this->saldo -= $total;

        $this->registrarTransacao($tipo, $total, true);
        $this->notificarTodos("$tipo realizado.");
    }

    // Realiza um depósito
    public function depositar(
        float $valor,
        ?string $cnpjOrigem = null
    ): void {
        $this->creditarMovimentacao($valor, 'Depósito');
    }

    // Verifica se as contas possuem o mesmo titular
    protected function mesmoTitular(
        ContaBancaria $destino
    ): bool {
        return $this->titular->getCpf()
            === $destino->titular->getCpf();
    }

    // Realiza uma transferência
    public function transferir(
        float $valor,
        ContaBancaria $destino
    ): void {
        try {
            $this->validarValor($valor);

            if (!$this->mesmoTitular($destino)) {
                throw new OperacaoNaoAutorizadaException(
                    "Titulares diferentes."
                );
            }

            $destino->validarCreditoInterno($valor);
        } catch (DomainException $erro) {
            $this->registrarFalha('Transferência', $valor);
            throw $erro;
        }

        $this->sacar($valor);
        $destino->receberTransferencia($valor);
    }

    // Recebe uma transferência
    protected function receberTransferencia(float $valor): void
    {
        $this->creditarMovimentacao(
            $valor,
            'Transferência recebida'
        );
    }

    // Retorna o extrato
    public function getExtrato(): array
    {
        return $this->historico;
    }

    // Método obrigatório nas subclasses
    abstract public function sacar(float $valor): void;
}