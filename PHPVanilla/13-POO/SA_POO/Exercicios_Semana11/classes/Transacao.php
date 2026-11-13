<?php
declare(strict_types=1);

class Transacao
{
    // Armazena os dados de uma movimentação
    public function __construct(
        private readonly string $tipo,
        private readonly float $valor,
        private readonly DateTimeImmutable $dataHora,
        private readonly bool $sucesso
    ) {
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function getValor(): float
    {
        return $this->valor;
    }

    public function getDataHora(): DateTimeImmutable
    {
        return $this->dataHora;
    }

    public function getSucesso(): bool
    {
        return $this->sucesso;
    }
}