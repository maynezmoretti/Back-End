<?php

declare(strict_types=1);

$extrato = [
    ["data" => "2026-09-01", "descricao" => "Salário", "tipo" => "Entrada", "valor" => 4000.00],
    ["data" => "2026-09-02", "descricao" => "Supermercado", "tipo" => "Saida", "valor" => 450.50],
    ["data" => "2026-09-05", "descricao" => "Pix João", "tipo" => "Entrada", "valor" => 200.00],
    ["data" => "2026-09-10", "descricao" => "Conta de Luz", "tipo" => "Saida", "valor" => 120.00],
    ["data" => "2026-09-12", "descricao" => "Cinema", "tipo" => "Saida", "valor" => 65.00]
];

$totalEntradas = 0;
$totalSaidas = 0;

foreach ($extrato as $transacao) {

    if ($transacao["tipo"] === "Entrada") {
        $totalEntradas += $transacao["valor"];
    }

    if ($transacao["tipo"] === "Saida") {
        $totalSaidas += $transacao["valor"];
    }
}

$saldoAtual = $totalEntradas - $totalSaidas;

$gastosAltos = array_filter($extrato, function ($transacao) {
    return $transacao["tipo"] === "Saida" && $transacao["valor"] > 100;
});

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Financeiro</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1 class="titulo">Dashboard Financeiro</h1>

    <h2 class="subtitulo">Entradas</h2>
    <p class="valor">
        R$ <?php echo number_format($totalEntradas, 2, ',', '.'); ?>
    </p>

    <h2 class="subtitulo">Saídas</h2>
    <p class="valor">
        R$ <?php echo number_format($totalSaidas, 2, ',', '.'); ?>
    </p>

    <h2 class="subtitulo">Saldo Atual</h2>
    <p class="saldo">
        R$ <?php echo number_format($saldoAtual, 2, ',', '.'); ?>
    </p>

    <h2 class="subtitulo">Extrato do Mês</h2>

    <table class="tabela">

        <tr>
            <th>Data</th>
            <th>Descrição</th>
            <th>Tipo</th>
            <th>Valor</th>
        </tr>

        <?php foreach ($extrato as $transacao) { ?>

            <tr>
                <td><?php echo $transacao["data"]; ?></td>
                <td><?php echo $transacao["descricao"]; ?></td>
                <td><?php echo $transacao["tipo"]; ?></td>
                <td>
                    R$ <?php echo number_format($transacao["valor"], 2, ',', '.'); ?>
                </td>
            </tr>

        <?php } ?>

    </table>

    <h2 class="subtitulo">Atenção: Gastos Altos do Mês</h2>

    <table class="tabela">

        <tr>
            <th>Data</th>
            <th>Descrição</th>
            <th>Valor</th>
        </tr>

        <?php foreach ($gastosAltos as $gasto) { ?>

            <tr>
                <td><?php echo $gasto["data"]; ?></td>
                <td><?php echo $gasto["descricao"]; ?></td>
                <td>
                    R$ <?php echo number_format($gasto["valor"], 2, ',', '.'); ?>
                </td>
            </tr>

        <?php } ?>

    </table>

</body>

</html>