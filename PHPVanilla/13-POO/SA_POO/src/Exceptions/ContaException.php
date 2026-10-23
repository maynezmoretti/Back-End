<?php
declare(strict_types=1);

class ContaException extends DomainException {
    // herdando as exceptions da biblioteca DomainException
    public function __construct(string $message = "Falha na operação bancária!")
    {
        parent::__construct($message);
    }
}