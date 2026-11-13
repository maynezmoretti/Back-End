<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

// Cria um titular para os testes
$titular = new Titular(
    "Maria Silva",
    "12345678900",
    "maria@email.com",
    "19999999999"
);

// Cria uma conta corrente para os testes
$conta = new ContaCorrente($titular, 1000.00);

$resultados = [];

// Teste 1: Tentativa de alterar o saldo privado
try {
    $conta->saldo = 999999.00;
    $resultados[] = ["Saldo privado", false];
} catch (Error $erro) {
    $resultados[] = ["Saldo privado", true];
    echo "Erro capturado: " . $erro->getMessage() . PHP_EOL;
}

// Teste 2: Tentativa de alterar o titular privado
try {
    $conta->titular = new Titular(
        "Outro Titular",
        "98765432100",
        "outro@email.com",
        "18888888888"
    );
    $resultados[] = ["Titular privado", false];
} catch (Error $erro) {
    $resultados[] = ["Titular privado", true];
    echo "Erro capturado: " . $erro->getMessage() . PHP_EOL;
}

// Teste 3: Tentativa de instanciar classe abstrata
try {
    $contaAbstrata = new ContaBancaria($titular);
    $resultados[] = ["Classe abstrata", false];
} catch (Error $erro) {
    $resultados[] = ["Classe abstrata", true];
    echo "Erro capturado: " . $erro->getMessage() . PHP_EOL;
}

// Teste 4: Tentativa de depósito negativo
try {
    $conta->depositar(-100.00);
    $resultados[] = ["Depósito negativo", false];
} catch (ValorInvalidoException $erro) {
    $resultados[] = ["Depósito negativo", true];
    echo "Exceção capturada: " . $erro->getMessage() . PHP_EOL;
}

// Calcula os resultados
$total = count($resultados);
$bloqueados = count(array_filter(
    $resultados,
    fn(array $teste): bool => $teste[1]
));

$porcentagem = ($bloqueados / $total) * 100;

// Exibe o relatório final
echo PHP_EOL;
echo "========================================" . PHP_EOL;
echo "   RELATÓRIO DE TESTES DE ENCAPSULAMENTO" . PHP_EOL;
echo "========================================" . PHP_EOL;

foreach ($resultados as [$teste, $sucesso]) {
    $status = $sucesso ? "BLOQUEADO" : "FALHOU";
    printf("%-25s | %s" . PHP_EOL, $teste, $status);
}

echo "----------------------------------------" . PHP_EOL;
echo "Total de testes: $total" . PHP_EOL;
echo "Violações bloqueadas: $bloqueados" . PHP_EOL;
echo "Integridade preservada: " . number_format(
    $porcentagem,
    2,
    ',',
    '.'
) . "%" . PHP_EOL;
echo "========================================" . PHP_EOL;
