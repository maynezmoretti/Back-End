<?php
declare(strict_types=1);

// Exercício 8: Limpeza e Formatação de CPF
// Crie a função limparCPF(string $cpf): string usando str_replace() para remover pontos e traço. Depois, crie cpfValido(string $cpf): bool, que deve verificar se o resultado possui exatamente 11 caracteres numéricos. Use strlen() e is_numeric().

function limparCPF(string $cpf): string {
    return str_replace([".", "-"], "", $cpf);
}

function cpfValido(string $cpf): bool {
    $cpf = limparCPF($cpf);

    if (strlen($cpf) == 11 && is_numeric($cpf)) {
        return true;
    } else {
        return false;
    }
}

$cpf = "123.456.789-000";

echo "CPF limpo: " . limparCPF($cpf) . "\n";

if (cpfValido($cpf)) {
    echo "CPF válido!";
} else {
    echo "CPF inválido!";
}
?>