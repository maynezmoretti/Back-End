<?php
declare(strict_types=1);

class Titular
{
    // Armazena os dados protegidos do titular
    public function __construct(
        private readonly string $nome,
        private readonly string $cpf,
        private readonly string $email,
        private readonly string $telefone
    ) {
    }

    // Retorna o nome do titular
    public function getNome(): string
    {
        return $this->nome;
    }

    // Retorna o CPF
    public function getCpf(): string
    {
        return $this->cpf;
    }

    // Retorna o e-mail
    public function getEmail(): string
    {
        return $this->email;
    }

    // Retorna o telefone
    public function getTelefone(): string
    {
        return $this->telefone;
    }
}