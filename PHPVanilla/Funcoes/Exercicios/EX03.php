<?php
declare(strict_types=1);

// Exercício 3: Validador de Senha
// Crie a função senhaForte(string $senha): bool. Ela deve retornar true quando a senha possuir mais de 8 caracteres e false caso contrário. Use strlen() e mostre uma mensagem de acordo com o resultado.

function senhaForte(string $senha): bool {
    return strlen($senha) > 8;
}

$senha = "123456789";

if (senhaForte($senha)) {
    echo "A senha é forte!";
} else {
    echo "A senha é fraca!";
}
?>