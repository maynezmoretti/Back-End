<?php
declare(strict_types=1);

use DomainException; // biblioteca de erros/exceptions do PHP

class ContaException extends DomainException {
    // herdando as exceptions da biblioteca DomainException
    #[Override]
    public function __construct(string $message = "Falha na operação bancária!")
    {
        return parent::__construct($message);
    }
}