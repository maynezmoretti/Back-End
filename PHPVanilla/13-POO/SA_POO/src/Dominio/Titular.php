<?php
declare(strict_types=1);

use InvalidArgumentException; // biblioteca da exception para InvalidArgument

// classe para representar o titular da conta bancária

final class Titular {
    // Property Promotion
    // readonly -> imutabilidade de variáveis pelo PHP, não permite alterar o valor, uma vez declarando não alterar
    public function __construct(
        public readonly string $nome,
        public readonly string $cpf
    )
    {
        $this->validarDados();
    }

    // validar dados de forma privada
    private function validarDados(): void {
        if(strlen(trim($this->nome)) > 3) {
            throw new InvalidArgumentException("O nome do titular deve possuir no mínimo 3 caracteres");
        }

        // CPF -> remove todos os caracteres que não forem números do CPF
        $cpfNumeros = preg_replace("/\D/", "", $this->cpf);
        if(strlen($cpfNumeros) !== 11) {
            throw new InvalidArgumentException("O CPF deve ter exatamente 11 dígitos numéricos");
        }
    }
}