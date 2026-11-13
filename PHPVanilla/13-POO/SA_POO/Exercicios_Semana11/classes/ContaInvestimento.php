<?php
declare(strict_types=1);

class ContaInvestimento extends ContaBancaria
{
    // Guarda as aplicações e seus rendimentos
    private array $aplicacoes = [];

    public function __construct(
        Titular $titular,
        float $saldoInicial = 0.0
    ) {
        parent::__construct($titular, $saldoInicial);

        if ($saldoInicial > 0) {
            $this->adicionarAplicacao($saldoInicial);
        }
    }

    // Adiciona uma nova aplicação
    private function adicionarAplicacao(float $valor): void
    {
        $this->aplicacoes[] = [
            'saldo' => $valor,
            'rendimento' => 0.0,
            'data' => new DateTimeImmutable()
        ];
    }

    // Realiza um depósito e registra a aplicação
    public function depositar(
        float $valor,
        ?string $cnpjOrigem = null
    ): void {
        parent::depositar($valor, $cnpjOrigem);
        $this->adicionarAplicacao($valor);
    }

    // Soma o saldo das aplicações
    private function saldoAplicacoes(): float
    {
        return array_sum(
            array_column($this->aplicacoes, 'saldo')
        );
    }

    // Distribui o rendimento entre as aplicações
    private function distribuirRendimento(float $valor): void
    {
        $total = $this->saldoAplicacoes();

        if ($total <= 0) {
            return;
        }

        foreach ($this->aplicacoes as $indice => $aplicacao) {
            if ($aplicacao['saldo'] <= 0) {
                continue;
            }

            $parte = $valor * ($aplicacao['saldo'] / $total);

            $this->aplicacoes[$indice]['saldo'] += $parte;
            $this->aplicacoes[$indice]['rendimento'] += $parte;
        }
    }

    // Registra um rendimento
    public function registrarRendimento(float $valor): void
    {
        try {
            $this->validarValor($valor);

            if ($this->saldoAplicacoes() <= 0) {
                throw new ValorInvalidoException(
                    "Não há aplicação."
                );
            }
        } catch (DomainException $erro) {
            $this->registrarFalha('Rendimento', $valor);
            throw $erro;
        }

        $this->creditarMovimentacao($valor, 'Rendimento');
        $this->distribuirRendimento($valor);
    }

    // Define a taxa de administração
    private function taxaAdministracao(): float
    {
        $saldo = $this->getSaldo();

        if ($saldo <= 1000) {
            return 0.015;
        }

        if ($saldo <= 5000) {
            return 0.010;
        }

        return 0.005;
    }

    // Calcula o IOF regressivo
    private function calcularIOF(int $dias): float
    {
        if ($dias >= 30) {
            return 0.0;
        }

        return max(
            0.0,
            96 * (30 - max(1, $dias)) / 29
        ) / 100;
    }

    // Calcula o imposto de renda
    private function calcularIR(int $dias): float
    {
        if ($dias <= 180) {
            return 0.225;
        }

        if ($dias <= 360) {
            return 0.20;
        }

        if ($dias <= 720) {
            return 0.175;
        }

        return 0.15;
    }

    // Calcula os impostos de cada aplicação
    private function calcularResgate(float $valor): array
    {
        $aplicacoes = $this->aplicacoes;
        $restante = $valor;
        $impostos = 0.0;

        foreach ($aplicacoes as $indice => $aplicacao) {
            if ($restante <= 0) {
                break;
            }

            if ($aplicacao['saldo'] <= 0) {
                continue;
            }

            $retirada = min($restante, $aplicacao['saldo']);
            $proporcao = $retirada / $aplicacao['saldo'];
            $rendimento = $aplicacao['rendimento'] * $proporcao;

            $dias = (int) $aplicacao['data']
                ->diff(new DateTimeImmutable())->days;

            $iof = $rendimento * $this->calcularIOF($dias);
            $ir = ($rendimento - $iof) * $this->calcularIR($dias);

            $impostos += $iof + $ir;

            $aplicacoes[$indice]['saldo'] -= $retirada;
            $aplicacoes[$indice]['rendimento'] -= $rendimento;

            $restante -= $retirada;
        }

        return [
            'aplicacoes' => $aplicacoes,
            'impostos' => $impostos
        ];
    }

    // Consome as aplicações na ordem de entrada
    private function consumirAplicacoes(float $valor): void
    {
        foreach ($this->aplicacoes as $indice => $aplicacao) {
            if ($valor <= 0) {
                break;
            }

            if ($aplicacao['saldo'] <= 0) {
                continue;
            }

            $retirada = min($valor, $aplicacao['saldo']);
            $proporcao = $retirada / $aplicacao['saldo'];
            $rendimento = $aplicacao['rendimento'] * $proporcao;

            $this->aplicacoes[$indice]['saldo'] -= $retirada;
            $this->aplicacoes[$indice]['rendimento'] -= $rendimento;

            $valor -= $retirada;
        }
    }

    // Realiza saque com taxa de administração
    public function sacar(float $valor): void
    {
        $taxa = $valor * $this->taxaAdministracao();

        $this->debitarComTaxa($valor, $taxa);
        $this->consumirAplicacoes($valor + $taxa);
    }

    // Valida o resgate
    public function resgatar(
        float $valor,
        ContaCorrente $destino
    ): void {
        try {
            $this->validarValor($valor);

            if (!$this->mesmoTitular($destino)) {
                throw new OperacaoNaoAutorizadaException(
                    "Titular diferente."
                );
            }

            if ($valor > $this->getSaldo()) {
                throw new SaldoInsuficienteException(
                    "Saldo insuficiente."
                );
            }
        } catch (DomainException $erro) {
            $this->registrarFalha('Resgate', $valor);
            throw $erro;
        }

        $this->processarResgate($valor, $destino);
    }

    // Aplica os descontos e transfere o valor líquido
    private function processarResgate(
        float $valor,
        ContaCorrente $destino
    ): void {
        $resultado = $this->calcularResgate($valor);
        $administracao = $valor * $this->taxaAdministracao();

        $liquido = $valor
            - $resultado['impostos']
            - $administracao;

        if ($liquido <= 0) {
            $this->registrarFalha('Resgate', $valor);

            throw new ValorInvalidoException(
                "Valor líquido do resgate inválido."
            );
        }

        $destino->validarRecebimento($liquido);

        $this->debitarComTaxa($valor, 0.0, 'Resgate');

        $this->aplicacoes = $resultado['aplicacoes'];

        $destino->depositar($liquido);
    }
}