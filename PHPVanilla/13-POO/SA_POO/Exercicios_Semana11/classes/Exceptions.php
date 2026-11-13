<?php
declare(strict_types=1);

// Exceção para valores inválidos
class ValorInvalidoException extends DomainException
{
}

// Exceção para saldo insuficiente
class SaldoInsuficienteException extends DomainException
{
}

// Exceção para operações não autorizadas
class OperacaoNaoAutorizadaException extends DomainException
{
}